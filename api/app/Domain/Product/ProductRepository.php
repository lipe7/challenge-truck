<?php

namespace App\Domain\Product;

use App\Domain\Product\Product;

class ProductRepository
{
    public function getByCode($code)
    {
        return Product::where('code', $code)->first();
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);

        return $product;
    }
}
