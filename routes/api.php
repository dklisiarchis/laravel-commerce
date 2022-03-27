<?php

use Illuminate\Support\Facades\Route;
use App\Solution\User\Controllers\UserController;
use App\Solution\Catalog\Controller\CatalogController;

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
