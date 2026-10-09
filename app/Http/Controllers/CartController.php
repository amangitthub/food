<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * ADD PRODUCT TO CART
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $productId = (int) $validated['product_id'];
        $quantity = (int) ($validated['quantity'] ?? 1);

        $product = Product::where('id', $productId)
            ->where('status', 'Active')
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available.',
            ], 404);
        }

        // Logged-in user
        if (Auth::check()) {
            $this->mergeGuestCartIntoDatabase();

            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $productId,
                    'quantity'   => $quantity,
                ]);
            }

            return response()->json([
                'success'    => true,
                'message'    => 'Product added to cart.',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        // Guest user
        $cart = session()->get('food_cart', []);
        $found = false;

        foreach ($cart as &$item) {
            if ((int) ($item['product_id'] ?? 0) === $productId) {
                $item['quantity'] = (int) ($item['quantity'] ?? 0) + $quantity;
                $found = true;
                break;
            }
        }

        unset($item);

        if (!$found) {
            $cart[] = [
                'product_id' => $productId,
                'quantity'   => $quantity,
            ];
        }

        session()->put('food_cart', $cart);

        return response()->json([
            'success'    => true,
            'message'    => 'Product added to cart.',
            'cart_count' => $this->getCartCount(),
        ]);
    }

    /**
     * CART PAGE
     */
    public function index()
    {
        if (Auth::check()) {
            $this->mergeGuestCartIntoDatabase();

            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product.images')
                ->get();

            $user = Auth::user();

            // Load only the logged-in user's saved addresses.
            $addresses = Address::where('user_id', Auth::id())
                ->orderByDesc('is_default')
                ->latest()
                ->get();

            return view('pages.cart', compact(
                'cartItems',
                'user',
                'addresses'
            ));
        }

        // Guest cart
        $guestCart = session()->get('food_cart', []);

        $productIds = collect($guestCart)
            ->pluck('product_id')
            ->filter()
            ->values();

        $products = Product::with('images')
            ->where('status', 'Active')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $cartItems = collect($guestCart)
            ->map(function ($item) use ($products) {
                $product = $products->get($item['product_id'] ?? null);

                if (!$product) {
                    return null;
                }

                return [
                    'id'         => null,
                    'product_id' => $product->id,
                    'quantity'   => (int) ($item['quantity'] ?? 1),
                    'product'    => $product,
                ];
            })
            ->filter()
            ->values();

        $user = null;
        $addresses = collect();

        return view('pages.cart', compact(
            'cartItems',
            'user',
            'addresses'
        ));
    }

    /**
     * UPDATE CART QUANTITY
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $productId = (int) $validated['product_id'];
        $quantity = (int) $validated['quantity'];

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found.',
                ], 404);
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();

            return response()->json([
                'success'    => true,
                'message'    => 'Cart updated.',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        $cart = session()->get('food_cart', []);
        $found = false;

        foreach ($cart as &$item) {
            if ((int) ($item['product_id'] ?? 0) === $productId) {
                $item['quantity'] = $quantity;
                $found = true;
                break;
            }
        }

        unset($item);

        if (!$found) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }

        session()->put('food_cart', $cart);

        return response()->json([
            'success'    => true,
            'message'    => 'Cart updated.',
            'cart_count' => $this->getCartCount(),
        ]);
    }

    /**
     * REMOVE PRODUCT FROM CART
     */
    public function remove(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $productId = (int) $validated['product_id'];

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

            return response()->json([
                'success'    => true,
                'message'    => 'Product removed from cart.',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        $cart = session()->get('food_cart', []);

        $cart = array_values(array_filter(
            $cart,
            fn ($item) => (int) ($item['product_id'] ?? 0) !== $productId
        ));

        session()->put('food_cart', $cart);

        return response()->json([
            'success'    => true,
            'message'    => 'Product removed from cart.',
            'cart_count' => $this->getCartCount(),
        ]);
    }

    /**
     * CLEAR CART
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        }

        session()->forget('food_cart');

        return response()->json([
            'success'    => true,
            'message'    => 'Cart cleared.',
            'cart_count' => 0,
        ]);
    }

    /**
     * MERGE GUEST CART INTO DATABASE
     */
    private function mergeGuestCartIntoDatabase()
    {
        if (!Auth::check()) {
            return;
        }

        $sessionCart = session()->get('food_cart', []);

        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $item) {
            $productId = (int) ($item['product_id'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 0);

            if (!$productId || $quantity < 1) {
                continue;
            }

            $productExists = Product::where('id', $productId)
                ->where('status', 'Active')
                ->exists();

            if (!$productExists) {
                continue;
            }

            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $productId,
                    'quantity'   => $quantity,
                ]);
            }
        }

        session()->forget('food_cart');
    }

    /**
     * CART COUNT
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return (int) Cart::where('user_id', Auth::id())
                ->sum('quantity');
        }

        $cart = session()->get('food_cart', []);

        return (int) collect($cart)->sum(
            fn ($item) => (int) ($item['quantity'] ?? 0)
        );
    }
}

