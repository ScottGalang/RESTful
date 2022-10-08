<?php

use App\Http\Controllers\Api\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
//     Route::apiResource('products', ProductController::class);
// });

Route::group(['prefix' => 'products'], function() {
    Route::get('/',[ProductController::class, 'index']);

    Route::get('/{id}', [ProductController::class, 'show']);

    Route::get('/search/{title}', [ProductController::class, 'search']);

    Route::get('/categories/{something?}', [ProductController::class, 'showCategories']);

    Route::get('/category/{category}', [ProductController::class, 'category'])->whereIn('category', ['apparel', 'book', 'electronic device']);

    Route::delete('/{id}', [ProductController::class, 'destroy']);

    Route::post('/add', [ProductController::class, 'store']);

    Route::put('/{id}', [ProductController::class, 'update']);
});