<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with(['product.category', 'product.images'])
            ->latest()
            ->paginate(12);

        return view('pages.my-favorites', compact('favorites'));
    }

public function toggle(\Illuminate\Http\Request $request)
{
    $request->validate([
        'product_id' => ['required', 'integer', 'exists:products,id'],
    ]);

    $product = \App\Models\Product::where('id', $request->product_id)
        ->where('status', 'Active')
        ->firstOrFail();

    $favorite = \App\Models\Favorite::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->first();

    if ($favorite) {
        $favorite->delete();
        $isFavorite = false;
        $message = 'Removed from favorites';
    } else {
        \App\Models\Favorite::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $isFavorite = true;
        $message = 'Added to favorites';
    }

    if ($request->ajax() || $request->expectsJson()) {
        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
            'message' => $message,
        ]);
    }

    return back()->with('success', $message);
}


    public function destroy($id)
    {
        $favorite = Favorite::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $favorite->delete();

        return back()->with('success', 'Product remove Successfully .');
    }
}