<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'registerUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
});

Route::middleware('auth:api')->prefix('user')->group(function() {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'getAllProducts']);
        Route::get('/{slug}', [ProductController::class, 'getOneProduct']);
    });

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'getUserCart']);
        Route::post('/', [CartController::class, 'addToCart']);
        Route::delete('/', [CartController::class, 'deleteCart']);
        Route::delete('/{cartItemId}', [CartController::class, 'deleteCartItem']);
    });

    Route::prefix('')->group(function () {
        Route::get('/', [CheckoutController::class, 'initializePayment']);
        Route::post('/confirm', [CheckoutController::class, 'paymentConfirmation']);
    });
});
