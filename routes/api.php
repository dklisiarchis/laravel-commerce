<?php

use App\Solution\Catalog\Controller\CatalogController;
use App\Solution\User\Controllers\UserController;
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

// Users
Route::get('/users/{id}', [UserController::class, 'show']);

// Catalog
Route::get('/catalog', [CatalogController::class, 'getList']);
