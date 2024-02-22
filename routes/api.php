<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
#Users
use App\Http\Controllers\User\GetAllUsersController;
use App\Http\Controllers\User\GetUserController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\User\DeleteUserController;

#Products
use App\Http\Controllers\Product\GetAllProductsController;
use App\Http\Controllers\Product\GetProductController;
use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\Product\DeleteProductController;


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

#users
Route::get('users', GetAllUsersController::class);
Route::get('user/{id}', GetUserController::class);
Route::post('user', CreateUserController::class);
Route::put('user/{id}', UpdateUserController::class);
Route::delete('user/{id}', DeleteUserController::class);

#products
Route::get('products', GetAllProductsController::class);
Route::get('product/{id}', GetProductController::class);
Route::post('product', CreateProductController::class);
Route::put('product/{id}', UpdateProductController::class);
Route::delete('product/{id}', DeleteProductController::class);


Route::get('/test', function () {
    echo phpinfo();
});
