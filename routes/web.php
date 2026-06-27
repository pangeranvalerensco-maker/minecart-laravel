<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Midtrans webhook
Route::post('/payment/callback', [\App\Http\Controllers\PaymentCallbackController::class, 'receive']);

Route::view('/about', 'pages.about')->name('about');
Route::view('/help', 'pages.help')->name('help');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    // Cart modifications are available to guests, moved outside.

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('account.orders');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Store opening
    Route::get('/store/create', [\App\Http\Controllers\StoreController::class, 'create'])->name('store.create');
    Route::post('/store/create', [\App\Http\Controllers\StoreController::class, 'store'])->name('store.store');

    // Seller Dashboard
    Route::middleware('is_seller')->prefix('seller')->name('seller.')->group(function () {
        Route::resource('products', \App\Http\Controllers\Seller\ProductController::class);
        Route::get('orders', [\App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
    });
});
