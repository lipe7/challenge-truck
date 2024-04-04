<?php

namespace App\Domain\ImportHistory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class ImportHistory extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'import_histories';

    protected $fillable = [
        'start_time',
        'end_time',
        'status',
        'imported_quantity'
    ];
}

