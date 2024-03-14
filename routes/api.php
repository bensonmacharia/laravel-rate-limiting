<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use \App\Http\Controllers\Api\V1\Auth;

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

Route::middleware('auth:api')->get('/profile', function (Request $request) {
    return $request->user();
});

Route::post('/user/register', [APIController::class, 'register']);
Route::post('/user/login', [APIController::class, 'login']);
Route::middleware('auth:api')->get('/users', [APIController::class, 'users']);
Route::middleware('auth:api')->get('/user/{id}', [APIController::class, 'user']);

Route::middleware('auth:api')->post('/product', [APIController::class, 'newProduct']);
Route::middleware('auth:api')->get('/products', [APIController::class, 'index']);
Route::middleware('auth:api')->get('/product/{id}', [APIController::class, 'product']);
