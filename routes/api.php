<?php

use Illuminate\Support\Facades\Route;
use App\Solution\Catalog\Controller\CatalogController;
use App\Solution\Checkout\Controllers\CartController;
use App\Solution\Checkout\Controllers\CheckoutController;
use App\Solution\User\Controllers\UserController;

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

// Users
Route::get('/users/{id}', [UserController::class, 'show']);

// Catalog
Route::get('/catalog', [CatalogController::class, 'getList']);

// Cart
Route::get('/cart/{id}', [CartController::class, 'show']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/update', [CartController::class, 'update']);

// Checkout
Route::post('/orders/place', [CheckoutController::class, 'placeOrder']);
