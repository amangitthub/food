<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteProductController;
use App\Http\Controllers\SiteComboController;
use App\Http\Controllers\HomeController;
use App\Models\Product;
use App\Http\Controllers\AuthController;


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

// ================== Admin Dashboard ==================

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', function () {

        $stats = [
            'total_orders' => '862',
            'pending' => '37',
            'revenue' => '₹2.8L',
            'customers' => '419',
        ];

        return view('dash.home', compact('stats'));

    })->name('dashboard');


    // ================== Orders ==================
    Route::view('/orders', 'dash.orders')
        ->name('orders.index');


    // ================== Customers ==================
    Route::get('/customers', function () {

        return view('dash.customers');

    })->name('customers.index');


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