<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Xendit webhook
Route::post('/webhook/xendit', [\App\Http\Controllers\WebhookController::class, 'xendit']);

Route::view('/about', 'pages.about')->name('about');

Route::get('/offline', function () {
    return view('offline');
})->name('offline');
Route::view('/help', 'pages.help')->name('help');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Google Login
    Route::get('/auth/google', [\App\Http\Controllers\SocialAuthController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [\App\Http\Controllers\SocialAuthController::class, 'callback']);

    // OTP Forgot Password
    Route::get('/password/reset', [\App\Http\Controllers\OtpPasswordResetController::class, 'showRequestForm'])->name('password.request');
    Route::post('/password/email', [\App\Http\Controllers\OtpPasswordResetController::class, 'sendOtp'])->name('password.email');
    Route::get('/password/verify', [\App\Http\Controllers\OtpPasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
    Route::post('/password/verify', [\App\Http\Controllers\OtpPasswordResetController::class, 'verifyOtp'])->name('password.verify');
    Route::get('/password/reset-form', [\App\Http\Controllers\OtpPasswordResetController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/password/reset-form', [\App\Http\Controllers\OtpPasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('account.orders');
    Route::patch('/account/orders/{order}/complete', [\App\Http\Controllers\OrderController::class, 'markCompleted'])->name('account.orders.complete');

    // Reviews
    Route::get('/reviews/create/{orderItem}', [\App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{orderItem}', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // Wishlist
    Route::get('/wishlists', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlists.index');
    Route::post('/wishlists/toggle/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlists.toggle');

    // Chat
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/start/{seller}', [\App\Http\Controllers\ChatController::class, 'startConversation'])->name('chat.start');
    Route::get('/chat/{conversation}/messages', [\App\Http\Controllers\ChatController::class, 'fetchMessages'])->name('chat.messages');
    Route::post('/chat/{conversation}', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculate_shipping');
    Route::post('/checkout/check-coupon', [CheckoutController::class, 'checkCoupon'])->name('checkout.check_coupon');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{order}/upload-proof', [\App\Http\Controllers\UploadProofController::class, 'show'])->name('checkout.upload_proof_form');
    Route::post('/checkout/{order}/upload-proof', [\App\Http\Controllers\UploadProofController::class, 'store'])->name('checkout.upload_proof');

    // Store opening
    Route::get('/store/create', [\App\Http\Controllers\StoreController::class, 'create'])->name('store.create');
    Route::post('/store/create', [\App\Http\Controllers\StoreController::class, 'store'])->name('store.store');

    // Seller Dashboard
    Route::middleware('is_seller')->prefix('seller')->name('seller.')->group(function () {
        Route::resource('products', \App\Http\Controllers\Seller\ProductController::class);
        Route::get('orders', [\App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{orderItem}/resi', [\App\Http\Controllers\Seller\OrderController::class, 'updateResi'])->name('orders.resi');
        Route::patch('orders/{order}/verify-payment', [\App\Http\Controllers\Seller\OrderController::class, 'verifyPayment'])->name('orders.verify_payment');
        
        Route::get('wallet', [\App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
        Route::post('wallet/withdraw', [\App\Http\Controllers\WalletController::class, 'withdraw'])->name('wallet.withdraw');
        
        Route::get('analytics', [\App\Http\Controllers\Seller\AnalyticsController::class, 'index'])->name('analytics.index');
    });

// Rute khusus untuk Deployment di Shared Hosting
// Akses: domain.com/deploy-migrate?key=pangeran123
Route::get('/deploy-migrate', function () {
    if (request('key') !== 'pangeran123') {
        abort(403, 'Unauthorized action.');
    }
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true
        ]);
        return 'Migrasi Database dan Seeding berhasil dijalankan di Hosting!';
    } catch (\Exception $e) {
        return 'Gagal: ' . $e->getMessage();
    }
});

    // Admin Dashboard
    Route::middleware('is_superadmin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
        Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\AdminController::class, 'toggleUserStatus'])->name('users.toggle');
        Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'settings'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');
        Route::get('/withdrawals', [\App\Http\Controllers\AdminController::class, 'withdrawals'])->name('withdrawals.index');
        Route::patch('/withdrawals/{withdrawal}/process', [\App\Http\Controllers\AdminController::class, 'processWithdrawal'])->name('withdrawals.process');
    });
});
