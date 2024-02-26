<?php

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

#Cart
use App\Http\Controllers\Cart\GetCartController;
use App\Http\Controllers\Cart\AddItemCartController;
use App\Http\Controllers\Cart\UpdateCartController;
use App\Http\Controllers\Cart\DeleteCartController;

#Order
use App\Http\Controllers\Order\GetOrderController;
use App\Http\Controllers\Order\ConfirmPurchaseController;

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
Route::prefix('user')->group(function () {
    Route::get('/{id}', GetUserController::class);
    Route::post('/', CreateUserController::class);
    Route::put('/{id}', UpdateUserController::class);
    Route::delete('/{id}', DeleteUserController::class);
});

#products
Route::get('products', GetAllProductsController::class);
Route::prefix('product')->group(function () {
    Route::get('/{id}', GetProductController::class);
    Route::post('/', CreateProductController::class);
    Route::put('/{id}', UpdateProductController::class);
    Route::delete('/{id}', DeleteProductController::class);
});

#cart
Route::prefix('cart')->group(function () {
    Route::get('/{id}', GetCartController::class);
    Route::post('/add', AddItemCartController::class);
    Route::put('/{id}', UpdateCartController::class);
    Route::delete('/{id}', DeleteCartController::class);
});

#order
Route::prefix('order')->group(function () {
    Route::get('/{id}', GetOrderController::class);
    Route::post('/{id}/confirm-purchase', ConfirmPurchaseController::class);
});

Route::get('/test', function () {
    echo phpinfo();
});
