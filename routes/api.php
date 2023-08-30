<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\UserTokenController;
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
Route::middleware(App\Http\Middleware\AuthApi::class)->group(function () {
    Route::get('/users', [UserController::class, 'showAll']);
    Route::get('/users/{id}', [UserController::class, 'showById']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'updateById']);
    Route::delete('/users/{id}', [UserController::class, 'deleteById']);
});

Route::post('/generate-token/{id}', [UserTokenController::class, 'generateToken']);
