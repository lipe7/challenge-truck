<?php

namespace App\Domain\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'products';

    const FIELDS_IMPORT = 'product_name,code,status,imported_t,url,creator,created_t,last_modified_t,quantity,brands,categories,labels,cities,purchase_places,stores,ingredients_text,traces,serving_size,serving_quantity,nutriscore_score,nutriscore_grade,main_category,image_url';

    protected $fillable = [
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
    ];
}
