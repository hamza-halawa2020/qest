<?php

use App\Http\Controllers\Api\ClientContoller;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\QestController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UserController::class);
Route::apiResource('qests', QestController::class);
Route::apiResource('clients', ClientContoller::class);


Route::post('login', [LoginController::class, 'login']);
Route::post('client-login', [LoginController::class, 'clientLogin']);