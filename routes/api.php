<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\GetUsersController;
use App\Http\Controllers\User\GetUserController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\User\DeleteUserController;

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

Route::get('users', GetUsersController::class);
Route::get('user/{id}', GetUserController::class);
Route::post('user', CreateUserController::class);
Route::put('user/{id}', UpdateUserController::class);
Route::delete('user/{id}', DeleteUserController::class);

Route::get('/test', function () {
    echo phpinfo();
});
