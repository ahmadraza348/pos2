<?php

use App\Http\Controllers\Api\Admin\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomePageController;
use App\Http\Controllers\Api\Admin\CategoryApiController;
use Illuminate\Support\Facades\Hash;

// Route::get('/hash', function () {
//     return Hash::make('ahmadraza');
// });


Route::post('/login', [AuthController::class, 'login'])->name('api.admin.login');
Route::middleware(['auth:sanctum'])
    ->prefix('admin')
    ->name('api.admin.category.')
    ->group(function () {

        Route::get('categories', [CategoryApiController::class, 'index']);
        Route::post('categories', [CategoryApiController::class, 'store']);
        Route::get('categories/{category}', [CategoryApiController::class, 'show']);
        Route::put('categories/{category}', [CategoryApiController::class, 'update']);
        Route::delete('categories/{category}', [CategoryApiController::class, 'destroy']);

        Route::delete('categories', [CategoryApiController::class, 'bulkDelete']);
        Route::post('categories/import', [CategoryApiController::class, 'import']);
    });


Route::get('/featured-categories', [HomePageController::class, 'fetch_featured_categories'])->name('api.featured_categories.fetch');
Route::get('/featured-products', [HomePageController::class, 'fetch_featured_products'])->name('api.featured_products.fetch');
Route::get('/hot-deals', [HomePageController::class, 'fetch_hot_deals'])->name('api.hot_deals.fetch');
Route::get('/sale-products', [HomePageController::class, 'fetch_sale_products'])->name('api.sale_products.fetch');
Route::get('/new-arrivals', [HomePageController::class, 'fetch_new_arrivals'])->name('api.new_arrivals.fetch');
Route::get('/brands', [HomePageController::class, 'fetch_brands'])->name('api.brands.fetch');
