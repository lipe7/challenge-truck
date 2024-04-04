<?php

namespace App\Console\Commands;

use App\Domain\ImportHistory\ImportHistory;
use App\Domain\Product\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportOpenFoodFacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:openfoodfacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from Open Food Facts';

    protected $page = 1;
    protected $perPage = 20;
    protected $totalImported = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $importHistory = $this->startImport();

        try {
            do {
                $products = $this->fetchProducts();

                foreach ($products as $productData) {
                    $this->importProduct($productData);
                    $this->totalImported++;
                }

                Log::info("Page {$this->page} imported successfully.");

                $this->page++;
            } while ($this->totalImported < 100);

            $this->finishImport($importHistory);
        } catch (\Exception $e) {
            $this->failImport($importHistory);
        }
    }

    protected function startImport()
    {
        return ImportHistory::create([
            'start_time' => now()->format('Y-m-d H:i:s'),
            'status' => 'starting',
        ]);
    }

    protected function fetchProducts()
    {
        $response = Http::get(Product::LINK_IMPORT, [
            'json' => 1,
            'action' => 'process',
            'sort_by' => 'last_modified_t',
            'page_size' => $this->perPage,
            'page' => $this->page
        ]);

        return $response->json()['products'];
    }

    protected function importProduct($productData)
    {
        $code = $productData['code'];
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

        if ($existingProduct) {
            $existingProduct->update(['status' => 'updated']);
        } else {
            Product::create($defaultData);
        }
    }

    protected function finishImport($importHistory)
    {
        $importHistory->update([
            'end_time' => now()->format('Y-m-d H:i:s'),
            'status' => 'finished',
            'imported_quantity' => $this->totalImported,
        ]);

        Log::info('All pages imported successfully.');
    }

    protected function failImport($importHistory)
    {
        $importHistory->update(['status' => 'finished with error']);
        $this->error('Import failed.');
    }
}
