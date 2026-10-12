<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    private array $statuses = [
        'pending',
        'packed',
        'picked',
        'shipped',
        'out_for_delivery',
        'complete',
        'cancelled',
        'return_requested',
        'returned',
        'failed',
    ];

    /**
     * Display all orders in admin panel.
     */
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        // Search by order number or ID
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('order_no', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $orderIds = $orders->getCollection()->pluck('id');
        $userIds = $orders->getCollection()
            ->pluck('user_id')
            ->filter()
            ->unique();

        // Latest status of each order
        $latestStatuses = DB::table('order_status_history')
            ->whereIn('order_id', $orderIds)
            ->orderByDesc('id')
            ->get()
            ->unique('order_id')
            ->keyBy('order_id');

        // Customers
        $customers = User::whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        foreach ($orders as $order) {
            $history = $latestStatuses->get($order->id);

            $order->current_status = $history->status ?? 'pending';

            $customer = $customers->get($order->user_id);

            $order->customer_name = $customer->name ?? 'Customer';

            $order->items_summary = $order->items
                ->map(
                    fn($item) =>
                        ($item->product_name ?? 'Product')
                        . ' × ' . ($item->quantity ?? 1)
                )
                ->implode(', ');
        }

        // Latest history row for every order
        $latestIds = DB::table('order_status_history')
            ->selectRaw('MAX(id) as id')
            ->groupBy('order_id');

        $statusQuery = DB::table('order_status_history')
            ->joinSub($latestIds, 'latest_statuses', function ($join) {
                $join->on(
                    'order_status_history.id',
                    '=',
                    'latest_statuses.id'
                );
            });

        $stats = [
            'total' => Order::count(),

            'pending' => (clone $statusQuery)
                ->where('status', 'pending')
                ->count(),

            'preparing' => (clone $statusQuery)
                ->whereIn('status', ['packed', 'picked'])
                ->count(),

            'delivered' => (clone $statusQuery)
                ->where('status', 'complete')
                ->count(),
        ];

        return view('dash.orders', [
            'orders' => $orders,
            'stats' => $stats,
            'statuses' => $this->statuses,
        ]);
    }

    /**
     * Display complete details of a particular order.
     */
    public function show(Order $order)
    {
        // Load order items and payment information
        $order->load(['items', 'payment']);

        // Customer information
        $customer = User::find($order->user_id);

        /*
         * Address priority:
         * 1. Address linked to the order
         * 2. User's default saved address
         * 3. User's latest saved address
         */
        $address = null;

        $addressQuery = Address::where('user_id', $order->user_id);

        // First try the address linked to this order
        if (!empty($order->address_id)) {
            $address = (clone $addressQuery)
                ->where('id', $order->address_id)
                ->first();
        }

        // If no linked address, find the user's default address
        if (!$address) {
            $address = (clone $addressQuery)
                ->where('is_default', 'Yes')
                ->first();
        }

        // If no default address exists, get the latest saved address
        if (!$address) {
            $address = (clone $addressQuery)
                ->latest('id')
                ->first();
        }

        // Latest order status
        $status = DB::table('order_status_history')
            ->where('order_id', $order->id)
            ->orderByDesc('id')
            ->first();

        return view('dash.order-details', compact(
            'order',
            'customer',
            'address',
            'status'
        ));
    }

    /**
     * Update order status without inserting duplicate history rows.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:' . implode(',', $this->statuses),
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $status = $validated['status'];

        $titles = [
            'pending' => 'Order pending',
            'packed' => 'Order packed',
            'picked' => 'Order picked up',
            'shipped' => 'Order shipped',
            'out_for_delivery' => 'Out for delivery',
            'complete' => 'Order completed',
            'cancelled' => 'Order cancelled',
            'return_requested' => 'Return requested',
            'returned' => 'Order returned',
            'failed' => 'Order failed',
        ];

        $historyData = [
            'status' => $status,
            'title' => $titles[$status],
            'description' => $validated['description'] ?? null,
            'created_by' => Auth::id(),
        ];

        // Find the latest existing status row for this order
        $existingHistory = DB::table('order_status_history')
            ->where('order_id', $order->id)
            ->orderByDesc('id')
            ->first();

        if ($existingHistory) {
            // Update the existing row
            DB::table('order_status_history')
                ->where('id', $existingHistory->id)
                ->update($historyData);
        } else {
            // Insert only when no history row exists
            DB::table('order_status_history')->insert([
                'order_id' => $order->id,
                'status' => $status,
                'title' => $titles[$status],
                'description' => $validated['description'] ?? null,
                'created_by' => Auth::id(),
                'created_at' => now(),
            ]);
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order status updated successfully.');
    }
}
