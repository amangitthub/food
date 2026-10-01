<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    $stats = [
        'total_orders' => '862',
        'pending' => '37',
        'revenue' => '₹2.8L',
        'customers' => '419',
    ];
    return view('dash.home', compact('stats'));
})->name('dashboard');

Route::get('/orders', function () {
    return view('dash.orders');
})->name('orders.index');

Route::get('/products', function () {
    return view('dash.products');
})->name('products.index');

Route::get('/categories', function () {
    return view('dash.categories');
})->name('categories.index');

Route::get('/customers', function () {
    return view('dash.customers');
})->name('customers.index');

Route::get('/settings', function () {
    return view('dash.settings');
})->name('settings.index');



//================== Category  Controller===================//
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/create', [CategoryController::class, 'create'])
    ->name('categories.create');

Route::post('/categories', [CategoryController::class, 'store'])
    ->name('categories.store');

Route::get('/categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
    ->name('categories.edit');

Route::put('/categories/{category}', [CategoryController::class, 'update'])
    ->name('categories.update');

Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');


// ================== Product Controller ================== //

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create');

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

Route::put('/products/{product}', [ProductController::class, 'update'])
    ->name('products.update');

Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy');