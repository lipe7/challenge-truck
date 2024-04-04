<?php

namespace App\Http\Controllers;

use App\Domain\Product\ProductService;
use App\Http\Requests\ListRequest;
use App\Http\Requests\UpdateProductRequest;
use Exception;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function list(ListRequest $request)
    {
        try {
            $products = $this->productService->getAll($request);

            return response()->json($products);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], $e->getCode());
        } catch (HttpExceptionInterface $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show($code)
    {
        try {
            $product = $this->productService->getByCode($code);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            return response()->json($product);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], $e->getCode());
        } catch (HttpExceptionInterface $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(UpdateProductRequest $request, $code)
    {
        try {
            $product = $this->productService->updateProduct($request, $code);

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], $e->getCode());
        } catch (HttpExceptionInterface $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
