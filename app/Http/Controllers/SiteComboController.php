<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteComboController extends Controller
{
    /**
     * Combo Listing
     */
    public function index(Request $request)
    {
        // Active categories
        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        // Active combo products
        $query = Product::with([
            'category',
            'images'
        ])
            ->where('product_type', 'combo')
            ->where('status', 'Active')
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $combos = $query->paginate(9)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | AJAX Request
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            $items = $combos->map(function ($combo) {

                $image = $combo->images->first();

                return [
                    'id' => $combo->id,

                    'name' => $combo->name,

                    'category' =>
                        $combo->category->name ?? 'Combo',

                    'short_description' =>
                        $combo->short_description
                        ?: $combo->description
                        ?: 'Delicious combo made for you.',

                    'price' => number_format(
                        (float) $combo->price,
                        2
                    ),

                    'image' =>
                        $image && $image->image_path
                        ? asset($image->image_path)
                        : null,

                    'image_alt' =>
                        $image
                        ? ($image->alt_text ?: $combo->name)
                        : $combo->name,

                    'url' => route(
                        'products.show',
                        $combo->id
                    ),
                ];
            });

            return response()->json([
                'combos' => $items,

                'current_page' =>
                    $combos->currentPage(),

                'last_page' =>
                    $combos->lastPage(),

                'has_more' =>
                    $combos->hasMorePages(),
            ]);
        }

        return view('pages.combo', compact(
            'categories',
            'combos'
        ));
    }
}