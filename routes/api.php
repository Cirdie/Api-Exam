<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesItemController;
use App\Http\Controllers\QueryController;

Route::get('/', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/users/all-user', action: [UserController::class, 'sortedDesc']);
Route::get('/users/by-role/{role}', [UserController::class, 'byRole']);
Route::get('/users/by-username/{username}', [UserController::class, 'byUsername']);
Route::get('/products/count-category/{category_id?}', [ProductController::class, 'countByCategory']);
Route::get('/products/most-expensive', [ProductController::class, 'mostExpensive']);
Route::get('/products/most-cheapest', [ProductController::class, 'cheapest']);
Route::get('/users/count-role/{role?}', [UserController::class, 'countByRole']);

Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('sales', SaleController::class);
Route::apiResource('sales-items', SalesItemController::class);
