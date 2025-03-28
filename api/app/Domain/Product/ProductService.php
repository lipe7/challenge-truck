<?php

namespace App\Domain\Product;

use App\Domain\ImportHistory\ImportHistory;
use App\Http\Requests\ListRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductService
{
    protected $repository;
    protected $totalImported = 0;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(ListRequest $request)
    {
        $filters = $request->validated();

        return $this->repository->getAll($filters);
    }

    public function getByCode($code)
    {
        return $this->repository->getByCode($code);
    }

    public function updateProduct(UpdateProductRequest $request, $code)
    {

        $data = $request->validated();
        $product = $this->repository->getByCode($code);
        if (!$product) {
            throw new \Exception('Product not found', 404);
        }

        return $this->repository->update($product, $data);
    }

    public function moveToTrash($code)
    {
        $product = $this->getByCode($code);

        if (!$product) {
            throw new \Exception('Product not found', 404);
        }

        return $this->repository->moveToTrash($product);
    }

    public function import()
    {

        $importHistory = $this->startImport();
        $this->generateLog('Import started.');

        try {
            $this->fetchProducts();

            $this->finishImport($importHistory);
            $this->generateLog('Import finished.');

            return response()->json(['message' => 'Open Food Facts data successfully imported.']);
        } catch (\Exception $e) {
            $this->failImport($importHistory);
            $this->generateLog("Import ended with error on the line " . $e->getLine() .": " . $e->getMessage());
        }
    }

    protected function fetchProducts()
    {
        $baseUrl = Product::BASE_URL;
        $indexUrl = Product::LINK_IMPORT;
        $index = Http::get($indexUrl)->body();
        $fileList = explode("\n", $index);

        foreach ($fileList as $key => $value) {
            if (!empty($value)) {
                $fileUrl = $baseUrl . $value;
                $gzipStream = gzopen($fileUrl, 'rb');

                if ($gzipStream !== false) {
                    $buffer = '';
                    $importCount = 0;

                    while ($importCount >= Product::LIMIT_IMPORT || !feof($gzipStream)) {
                        $line = stream_get_line($gzipStream, 4096, "\n");
                        if ($line !== false && $line !== '') {
                            $buffer .= $line;
                            if (json_decode($buffer) !== null) {
                                $productData = json_decode($buffer, true);
                                $import = $this->importProduct($productData);

                                if ($import) {
                                    $this->totalImported++;
                                    $importCount++;

                                    if ($importCount >= Product::LIMIT_IMPORT) {
                                        $message = "Import limit reached for file: $fileUrl";
                                        $this->generateLog($message);
                                        break;
                                    }
                                }
                                $buffer = '';
                            }
                        }
                    }

                    gzclose($gzipStream);
                } else {
                    Log::error("Failed to open file: $fileUrl");
                }
            }
        }
    }

    protected function startImport()
    {
        return ImportHistory::create([
            'start_time' => now()->format('Y-m-d H:i:s'),
            'status' => 'starting',
        ]);
    }

    protected function importProduct($productData)
    {
        $code = preg_replace("/[^0-9]/", "", (string) $productData['code']);
        $existingProduct = Product::where('code', $code)->first();

        $productAttributes = [
            'code', 'status', 'imported_t', 'url', 'creator', 'created_t', 'last_modified_t',
            'product_name', 'quantity', 'brands', 'categories', 'labels', 'cities', 'purchase_places',
            'stores', 'ingredients_text', 'traces', 'serving_size', 'serving_quantity', 'nutriscore_score',
            'nutriscore_grade', 'main_category', 'image_url',
        ];

        $defaultData = Arr::only($productData, $productAttributes);
        $defaultData['imported_t'] = now()->format('Y-m-d H:i:s');
        $defaultData['status'] = 'published';
        $defaultData['code'] = preg_replace("/[^0-9]/", "", (string) $defaultData['code']);;

        if ($existingProduct) {
            return $existingProduct->update(['status' => 'updated']);
        } else {
            return Product::create($defaultData);
        }
    }

    protected function finishImport($importHistory)
    {
        $importHistory->update([
            'end_time' => now()->format('Y-m-d H:i:s'),
            'status' => 'finished',
            'imported_quantity' => $this->totalImported,
        ]);

    }

    protected function failImport($importHistory)
    {
        $importHistory->update(['status' => 'finished with error']);
    }

    protected function generateLog($message)
    {
        return Log::info("$message\n" .
            "Data: " . now()->format('d-m-Y') . "\n" .
            "Hora: " . now()->format('H:i:s'));
    }
}
