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

                    // Product URL using slug
                    'url' => route(
                        'products.show',
                        $product->slug
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
    public function show($slug)
    {
        $product = Product::with([
            'category',
            'images'
        ])
            ->where('slug', $slug)
            ->where('status', 'Active')
            ->firstOrFail();

        $comboProducts = collect();

        if (
            $product->product_type === 'combo' &&
            !empty($product->combo_product_ids)
        ) {
            $comboIds = is_array($product->combo_product_ids)
                ? $product->combo_product_ids
                : json_decode($product->combo_product_ids, true);

            if (is_array($comboIds) && count($comboIds)) {

                $comboProducts = Product::with([
                    'images',
                    'category'
                ])
                    ->whereIn('id', $comboIds)
                    ->where('status', 'Active')
                    ->get();
            }
        }

        return view(
            'pages.view-product',
            compact('product', 'comboProducts')
        );
    }
}