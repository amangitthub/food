<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;

class SiteProductController extends Controller
{
    /**
     * Product Listing + Infinite Scroll
     */
    public function index(Request $request)
    {
        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        $query = Product::with(['category', 'images'])
            ->where('status', 'Active')
            ->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Keep 9 products per page
        $products = $query->paginate(9)->withQueryString();

        // Get favorite IDs for the current page
        $favoriteIds = collect();

        if (auth()->check() && $products->isNotEmpty()) {
            $favoriteIds = Favorite::where('user_id', auth()->id())
                ->whereIn('product_id', $products->pluck('id'))
                ->pluck('product_id')
                ->map(fn($id) => (int) $id);
        }

        // AJAX / Infinite Scroll response
        if ($request->ajax() || $request->expectsJson()) {
            $items = $products->getCollection()->map(
                function ($product) use ($favoriteIds, $request) {
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
                            2,
                            '.',
                            ''
                        ),

                        'image' => $image && $image->image_path
                            ? asset($image->image_path)
                            : null,

                        'image_alt' => $image
                            ? ($image->alt_text ?: $product->name)
                            : $product->name,

                        'url' => route('products.show', $product->slug),

                        'is_favorite' => $favoriteIds->contains(
                            (int) $product->id
                        ),

                        'login_url' => route('login', [
                            'redirect' => $request->fullUrl()
                        ]),
                    ];
                }
            );

            return response()->json([
                'products' => $items->values(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'has_more' => $products->hasMorePages(),
            ]);
        }

        return view('pages.product', compact(
            'categories',
            'products'
        ));
    }

    /**
     * Product Details + Random Recommendations
     */
    public function show($slug)
    {
        // Current product details
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('status', 'Active')
            ->firstOrFail();

        // Combo products
        $comboProducts = collect();

        if (
            $product->product_type === 'combo'
            && !empty($product->combo_product_ids)
        ) {
            $comboIds = is_array($product->combo_product_ids)
                ? $product->combo_product_ids
                : json_decode($product->combo_product_ids, true);

            if (is_array($comboIds) && count($comboIds)) {
                $comboProducts = Product::with(['images', 'category'])
                    ->whereIn('id', $comboIds)
                    ->where('status', 'Active')
                    ->get();
            }
        }

        // Random active recommendations, excluding current product
        $recommendedProducts = Product::with(['category', 'images'])
            ->where('status', 'Active')
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Product details view
        return view('pages.view-product', compact(
            'product',
            'comboProducts',
            'recommendedProducts'
        ));
    }
}