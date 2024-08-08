<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register-user', 'register');
    Route::post('/login-user', 'login');
});



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout-user', [AuthController::class, 'logout']);

    Route::controller(PostController::class)->group(function () {
        Route::get('get-posts', 'index');
        Route::get('get-post/{post}', 'show');
    });
});
