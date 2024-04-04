<?php

namespace App\Domain\Product;

use App\Domain\Product\Product;

class ProductRepository
{
    public function getByCode($code)
    {
        return Product::where('code', $code)->first();
    }

    public function getAll($filters)
    {
        $perPage = $filters['per_page'] ?? 10;
        $orderBy = $filters['order_by'] ?? 'products.product_name';
        $orderByType = $filters['order_by_type'] ?? 'asc';
        $searchTerm = $filters['search_term'] ?? '';

        $query = Product::orderBy($orderBy, $orderByType);

        if($searchTerm){
            $query->whereAny([
                'code',
                'status',
                'product_name',
                'categories'
            ], 'LIKE', '%' . $searchTerm . '%');
        }

        return $query->paginate($perPage);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);

        return $product;
    }
}
