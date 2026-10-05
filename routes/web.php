<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteProductController;
use App\Http\Controllers\SiteComboController;
use App\Http\Controllers\HomeController;
use App\Models\Product;

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


// ================== Admin Dashboard ==================
Route::get('/dashboard', function () {
    $stats = ['total_orders' => '862', 'pending' => '37', 'revenue' => '₹2.8L', 'customers' => '419',];
    return view('dash.home', compact('stats'));
})->name('dashboard');

Route::view('/orders', 'dash.orders')->name('orders.index');

Route::get('/customers', function () {
    return view('dash.customers'); })->name('customers.index');

Route::view('/settings', 'dash.settings')->name('settings.index');

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

    Route::delete('{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    Route::get('/{category}', [CategoryController::class, 'show'])
        ->name('categories.show');
        //  Route::get('/categories/{category}', [CategoryController::class, 'show'])
        // ->name('categories.show');

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
        ->name('products.show');

});