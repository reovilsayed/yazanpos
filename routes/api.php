<?php

use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

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

// Route::get('scrap', [ScrapController::class, 'scrap'])->name('scrap');



Route::middleware(['api.auth'])->group(function () {
    Route::get('products', [ApiController::class, 'products']);
    Route::get('point-of-sale', [ApiController::class, 'pos']);
    Route::get('customers', [ApiController::class, 'customers']);
    Route::get('single-customer', [ApiController::class, 'singleCustomer']);
    Route::get('suppliers', [ApiController::class, 'suppliers']);
    Route::get('generics', [ApiController::class, 'generics']);
    Route::get('categories', [ApiController::class, 'categories']);
    Route::post('create-order', [ApiController::class, 'orderCreate']);
    Route::post('create-customer', [ApiController::class, 'customerCreate']);
    Route::get('prescription', [ApiController::class, 'prescription']);
    Route::post('reports', [ApiController::class, 'reports']);

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'api_login']);
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('customer', [CustomerApiController::class, 'customer']);
    Route::post('update-profile', [CustomerApiController::class, 'update_profile']);
    Route::get('order-single/{order}', [CustomerApiController::class, 'orderSingle']);
    Route::get('reports', [CustomerApiController::class, 'reports']);
    Route::get('orders', [CustomerApiController::class, 'orders']);
    Route::post('create-order-apps', [ApiController::class, 'orderCreate']);
});
