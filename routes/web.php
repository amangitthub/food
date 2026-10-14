<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteProductController;
use App\Http\Controllers\SiteComboController;
use App\Http\Controllers\HomeController;
use App\Models\Product;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ForgotPasswordController;

// ================== Website Pages ==================

// Route::view('/', 'pages.home')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/view-product/{id}', [SiteProductController::class, 'show'])->name('products.show');

Route::get('/view-product/{slug}', [SiteProductController::class, 'show'])
    ->name('products.show');

Route::get('/menu', [SiteProductController::class, 'index'])
    ->name('site.products');

Route::get('/combos', [SiteComboController::class, 'index'])
    ->name('site.combos');

Route::view('/contact', 'pages.contact')
    ->name('contact');
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart');

Route::post('/cart/update', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::post('/cart/clear', [CartController::class, 'clear'])
    ->name('cart.clear');


//=================== Auth====================
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ================== Forgot Password ==================

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

// ================== Reset Password ==================

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');


//=================== Checkout ====================
Route::middleware('auth')->group(function () {

    Route::post('/checkout/place-order', [
        CartController::class,
        'placeOrder'
    ])->name('checkout.place-order');

    Route::get('/order-confirmation/{orderNo}', function ($orderNo) {
        $order = \App\Models\Order::with(['items', 'payment'])
            ->where('order_no', $orderNo)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        return view('pages.order-confirmation', compact('order'));
    })->name('checkout.confirmation');

    // CUSTOMER ORDERS
    Route::get('/my-orders', [OrderController::class, 'index'])
        ->name('orders.my');

    Route::get('/my-orders/{orderNo}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::get('/my-orders/{orderNo}/receipt', [OrderController::class, 'downloadReceipt'])
        ->name('orders.receipt.download');

});

// ================== User Profile & Addresses ==================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/my-addresses', [AddressController::class, 'index'])
        ->name('addresses.index');

    Route::post('/my-addresses', [AddressController::class, 'store'])
        ->name('addresses.store');

    Route::put('/my-addresses/{id}', [AddressController::class, 'update'])
        ->name('addresses.update');

    Route::delete('/my-addresses/{id}', [AddressController::class, 'destroy'])
        ->name('addresses.destroy');

    Route::post('/my-addresses/{id}/default', [AddressController::class, 'makeDefault'])
        ->name('addresses.default');
});


// ================== Admin Dashboard ==================

Route::middleware(['auth', 'admin'])->group(function () {
    //=====================Main Dashboard================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ================== Orders ==================
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');

    //=================paytment======================
    Route::patch('/orders/{order}/payment', [AdminOrderController::class, 'updatePayment'])
        ->name('orders.payment.update');


    Route::patch('/orders/{order}/status', [
        AdminOrderController::class,
        'updateStatus'
    ])->name('orders.status.update');

    Route::get('/orders/{order}/details', [
        AdminOrderController::class,
        'show'
    ])->name('admin.orders.show');



    // ================== Customers ==================
    Route::get('/customers', [CustomerController::class, 'index'])
        ->name('customers.index');


    // ================== Settings ==================
    Route::view('/settings', 'dash.settings')
        ->name('settings.index');


    // ================== Category Route ==================
    Route::prefix('category')->group(function () {

        Route::get('/', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::get('/create', [CategoryController::class, 'create'])
            ->name('categories.create');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('/{category}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');

        Route::put('/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        Route::get('/{category}', [CategoryController::class, 'show'])
            ->name('categories.show');

    });


    // ================== Product Route ==================
    Route::prefix('product')->group(function () {

        Route::get('/', [ProductController::class, 'index'])
            ->name('products.index');

        Route::get('/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        Route::get('/{product}', [ProductController::class, 'show'])
            ->name('admin.products.show');

    });

});