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

// Endpoint requires authentication and is throttled through the auth rate limiter
Route::middleware(['auth:api','throttle:auth'])->get('/profile', function (Request $request) {
    return $request->user();
});

// Endpoints do not require authentication but they are throttled through the auth rate limiter
Route::middleware(['throttle:auth'])->post('/user/register', [APIController::class, 'register']);
Route::middleware(['throttle:auth'])->post('/user/login', [APIController::class, 'login']);

// Endpoints require authentication and are throttled through the auth rate limiter
Route::middleware(['auth:api','throttle:auth'])->get('/users', [APIController::class, 'users']);
Route::middleware(['auth:api','throttle:auth'])->get('/user/{id}', [APIController::class, 'user']);

// Endpoints require authentication and are throttled through the auth product limiter
Route::middleware(['auth:api','throttle:product'])->post('/product', [APIController::class, 'newProduct']);
Route::middleware(['auth:api','throttle:product'])->get('/products', [APIController::class, 'index']);
Route::middleware(['auth:api','throttle:product'])->get('/product/{id}', [APIController::class, 'product']);
