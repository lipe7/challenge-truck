<?php

namespace App\Domain\ApiStatus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class ApiKey extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'api_keys';

    protected $fillable = [
        'key'
    ];
}
