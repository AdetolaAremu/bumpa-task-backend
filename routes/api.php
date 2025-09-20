<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'registerUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'getAllProducts']);
    Route::get('/{slug}', [ProductController::class, 'getOneProduct']);
});

Route::middleware('auth:api')->prefix('user')->group(function() {
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'getUserCart']);
        Route::post('/', [CartController::class, 'addToCart']);
        Route::delete('/', [CartController::class, 'deleteCart']);
        Route::delete('/{cartItemId}', [CartController::class, 'deleteCartItem']);
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [CheckoutController::class, 'initializePayment']);
        Route::post('/confirm', [CheckoutController::class, 'paymentConfirmation']);
    });

    Route::prefix('util')->group(function () {
        Route::get('/stats', [UtilController::class, 'getUserStats']);
        Route::get('/orders', [UtilController::class, 'getUserOrders']);
        Route::get('/achievements', [UtilController::class, 'getAllAchievements']);
        Route::get('/badges', [UtilController::class, 'getAllBadges']);
        Route::get('/user-achievements', [UtilController::class, 'getAllUserAchievements']);
        Route::get('/user-badges', [UtilController::class, 'getAllUserBadges']);
        Route::get('/cashback-total', [UtilController::class, 'getUserCashbackTotal']);
    });
});
