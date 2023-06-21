<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
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

// Authentication
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth.jwt'], function () {
    // Product
    Route::get('product', [ProductController::class, 'index']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    
    // Cart
    Route::get('cart', [CartController::class, 'getCart']);
    Route::get('cart/{id}', [CartController::class, 'showCartItem']);

    // Transaction
    Route::get('transaction', [CartController::class, 'getTransaction']);

    Route::group(['middleware' => 'auth.role:admin'], function () {
        // Product
        Route::post('product', [ProductController::class, 'store']);
        Route::put('product/{id}', [ProductController::class, 'update']);
        Route::delete('product/{id}', [ProductController::class, 'destroy']);
    });

    Route::group(['middleware' => 'auth.role:user'], function () {
        // Cart
        Route::post('cart', [CartController::class, 'createCart']);
        Route::post('add-to-cart', [CartController::class, 'addToCart']);

        // Transaction
        Route::post('checkout', [CartController::class, 'checkout']);
    });
});





