<?php

namespace App\Domain\Product;

use App\Http\Requests\UpdateProductRequest;

class ProductService
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
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
}
