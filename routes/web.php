<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    $stats = [
        'total_orders' => '862',
        'pending'      => '37',
        'revenue'      => '₹2.8L',
        'customers'    => '419',
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
