<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
     * PLACE CASH ON DELIVERY ORDER
     */
    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login before placing your order.',
            ], 401);
        }

        $validated = $request->validate([
            'address_id' => ['required', 'integer'],
            'payment_method' => ['required', 'in:cash'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $userId = Auth::id();

        // Verify that the selected address belongs to this user.
        $address = Address::where('id', $validated['address_id'])
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a valid delivery address.',
            ], 422);
        }

        try {
            $order = DB::transaction(function () use (
                $userId,
                $address,
                $validated
            ) {
                $cartItems = Cart::where('user_id', $userId)
                    ->with('product')
                    ->lockForUpdate()
                    ->get();

                if ($cartItems->isEmpty()) {
                    throw new \RuntimeException(
                        'Your cart is empty. Please add products first.'
                    );
                }

                $subtotal = 0;
                $itemsToSave = [];

                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    $quantity = (int) $cartItem->quantity;

                    if (
                        !$product ||
                        $product->status !== 'Active' ||
                        $quantity < 1
                    ) {
                        throw new \RuntimeException(
                            'A product in your cart is no longer available. Please review your cart.'
                        );
                    }

                    // Always calculate the price using the database.
                    $price = round((float) $product->price, 2);
                    $lineTotal = round($price * $quantity, 2);

                    $subtotal += $lineTotal;

                    $itemsToSave[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'original_price' => $price,
                        'discount' => 0,
                        'price' => $price,
                        'quantity' => $quantity,
                        'subtotal' => $lineTotal,
                    ];
                }

                $subtotal = round($subtotal, 2);
                $discount = 0;
                $shipping = 0;
                $total = round($subtotal - $discount + $shipping, 2);

                $order = Order::create([
                    'order_no' => 'ORD-' . strtoupper(Str::random(12)),
                    'user_id' => $userId,
                    'address_id' => $address->id,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'shipping' => $shipping,
                    'total' => $total,
                    'notes' => $validated['notes'] ?? null,
                    'discount_percentage' => 0,
                    'cgst_percentage' => 0,
                    'cgst' => 0,
                    'sgst_percentage' => 0,
                    'sgst' => 0,
                    'igst_percentage' => 0,
                    'igst' => 0,
                ]);

                foreach ($itemsToSave as $item) {
                    $item['order_id'] = $order->id;

                    OrderItem::create($item);
                }

                Payment::create([
                    'order_id' => $order->id,
                    'user_id' => $userId,
                    'method' => 'cash',
                    'amount' => $total,
                    'status' => 'Pending',
                ]);

                DB::table('order_status_history')->insert([
                    'order_id' => $order->id,
                    'status' => 'pending',
                    'title' => 'Order placed',
                    'description' =>
                        'Order placed successfully. Payment method: Cash on Delivery.',
                    'created_by' => $userId,
                    'created_at' => now(),
                ]);

                // Clear the database cart only after order records are saved.
                Cart::where('user_id', $userId)->delete();

                return $order;
            });

            session()->forget('food_cart');

            // Return JSON in the format expected by the checkout JavaScript.
            return response()->json([
                'success' => true,
                'message' => 'Your order has been placed successfully.',
                'order_no' => $order->order_no,
                'redirect_url' => route(
                    'checkout.confirmation',
                    ['orderNo' => $order->order_no]
                ),
            ]);

        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Unable to place your order right now. Please try again.',
            ], 500);
        }
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
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $quantity,
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

