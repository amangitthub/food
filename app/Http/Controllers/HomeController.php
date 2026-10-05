<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // All Single Products - Random Order
        $popularProducts = Product::with(['category', 'images'])
            ->where('status', 'Active')
            ->where('product_type', 'single')
            ->inRandomOrder()
            ->get();

        // All Combo Products - Random Order
        $popularComboItems = Product::with(['category', 'images'])
            ->where('status', 'Active')
            ->where('product_type', 'combo')
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view(
            'pages.home',
            compact('popularProducts', 'popularComboItems')
        );
    }
}