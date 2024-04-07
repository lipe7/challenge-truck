<?php

namespace Tests\Feature;

use App\Domain\Product\Product;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testUpdateProduct()
    {
        $product = ProductFactory::new()->create();

        $data = [
            'creator' => 'New Creator',
            'product_name' => 'New Product Name',
            'quantity' => 'New Quantity',
            'brands' => 'New Brands',
            'categories' => 'New Categories',
            'labels' => 'New Labels',
            'cities' => 'New Cities',
            'purchase_places' => 'New Purchase Places',
            'stores' => 'New Stores',
            'ingredients_text' => 'New Ingredients Text',
            'traces' => 'New Traces',
            'serving_size' => 'New Serving Size',
            'serving_quantity' => 10.5,
            'nutriscore_score' => 20,
            'nutriscore_grade' => 'New Grade',
            'main_category' => 'New Main Category'
        ];

        $response = $this->put("/api/products/$product->code", $data);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => [
                    'creator' => 'New Creator',
                    'product_name' => 'New Product Name',
                    'quantity' => 'New Quantity',
                    'brands' => 'New Brands',
                    'categories' => 'New Categories',
                    'labels' => 'New Labels',
                    'cities' => 'New Cities',
                    'purchase_places' => 'New Purchase Places',
                    'stores' => 'New Stores',
                    'ingredients_text' => 'New Ingredients Text',
                    'traces' => 'New Traces',
                    'serving_size' => 'New Serving Size',
                    'serving_quantity' => 10.5,
                    'nutriscore_score' => 20,
                    'nutriscore_grade' => 'New Grade',
                    'main_category' => 'New Main Category'
                ],
            ]);

            $this->assertDatabaseHas('products', [
            'code' => $product->code,
            'product_name' => 'New Product Name'
        ]);
    }

    public function testListProducts()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'code',
                    'status',
                    'imported_t',
                    'url',
                    'last_modified_t',
                    'product_name',
                    'image_url',
                    'updated_at',
                    'created_at'
                ]
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);

        $response->assertJsonFragment(['total' => Product::count()]);
    }

    public function testShowProduct()
    {
        $product = ProductFactory::new()->create();

        $response = $this->get("/api/products/$product->code");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '_id',
                'code',
                'status',
                'imported_t',
                'url',
                'creator',
                'created_t',
                'last_modified_t',
                'product_name',
                'quantity',
                'brands',
                'categories',
                'labels',
                'cities',
                'purchase_places',
                'stores',
                'ingredients_text',
                'traces',
                'serving_size',
                'serving_quantity',
                'nutriscore_score',
                'nutriscore_grade',
                'main_category',
                'image_url',
                'updated_at',
                'created_at'
            ]
        ]);

        $response->assertJsonFragment([
            'code' => $product->code,
            'product_name' => $product->product_name
        ]);
    }
}
