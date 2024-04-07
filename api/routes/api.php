<?php

use App\Http\Controllers\ApiStatusController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['verify.api'])->group(function () {
    Route::get('/', [ApiStatusController::class, 'apiDetails']);

    Route::prefix('products')->group(function () {
        Route::put('/{code}', [ProductController::class, 'update']);
        Route::delete('/{code}', [ProductController::class, 'delete']);
        Route::get('/', [ProductController::class, 'list']);
        Route::get('/{code}', [ProductController::class, 'show']);
    });
});
