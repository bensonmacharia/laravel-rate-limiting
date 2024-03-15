<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Not throttled
Route::get('/', function () {
    return view('welcome');
});

// Throttled through the auth rate limiter
Route::group(['middleware' => 'throttle:auth'], function () {
    Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
    Route::post('/store', [LoginRegisterController::class, 'store'])->name('store');
    Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
    Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
});

// Throttled through the product rate limiter
Route::middleware(['middleware' => 'throttle:product'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
});
