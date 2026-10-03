<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteProductController extends Controller
{
    /**
     * Product Listing
     */
    public function index(Request $request)
    {
        // Active categories
        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        // Active products
        $query = Product::with([
            'category',
            'images'
        ])
            ->where('status', 'Active')
            ->latest();

        // Search filter
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('short_description', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');

            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Infinite Scroll Pagination
        |--------------------------------------------------------------------------
        */

        $products = $query->paginate(9)->withQueryString();


        /*
        |-------------------------------------------------------------------------- 
        | AJAX Request
        |--------------------------------------------------------------------------
        |
        | Scroll se next products mangwane ke liye JSON return hoga.
        |
        */

        if ($request->ajax()) {

            $items = $products->map(function ($product) {

                $image = $product->images->first();

                return [
                    'id' => $product->id,

                    'name' => $product->name,

                    'category' => $product->category->name ?? 'Food',

                    'short_description' =>
                        $product->short_description
                        ?: $product->description
                        ?: 'Delicious food made for you.',

                    'price' => number_format(
                        (float) $product->price,
                        2
                    ),

                    'image' => $image && $image->image_path
                        ? asset($image->image_path)
                        : null,

                    'image_alt' => $image
                        ? ($image->alt_text ?: $product->name)
                        : $product->name,

                    'url' => route(
                        'products.show',
                        $product->id
                    ),
                ];
            });

            return response()->json([
                'products' => $items,

                'current_page' => $products->currentPage(),

                'last_page' => $products->lastPage(),

                'has_more' => $products->hasMorePages(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Normal Page
        |--------------------------------------------------------------------------
        */

        return view('pages.product', compact(
            'categories',
            'products'
        ));
    }


    /**
     * Product Details
     */
    public function show($id)
    {
        $product = Product::with([
            'category',
            'images'
        ])->findOrFail($id);

        return view('pages.view-product', compact(
            'product'
        ));
    }
}