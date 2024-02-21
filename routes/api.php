<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\UpdateUserController;
use App\Http\Controllers\DeleteUserController;

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

Route::get('user/{id}', GetUserController::class);
Route::post('user', CreateUserController::class);
Route::put('user/{id}', UpdateUserController::class);
Route::delete('user/{id}', DeleteUserController::class);

Route::get('/test', function () {
    echo phpinfo();
    //dd('API, Hello, this is an example route!');
});
