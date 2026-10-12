<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    /**
     * Customer ke saare previous orders.
     * Har order ka latest status history table se load hota hai.
     */
    public function index()
    {
        $orders = Order::with(['items', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        // History table available hai to latest statuses load karo.
        if (Schema::hasTable('order_status_history')) {
            $orderIds = $orders->getCollection()->pluck('id');

            $latestStatuses = DB::table('order_status_history')
                ->whereIn('order_id', $orderIds)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get()
                ->unique('order_id')
                ->keyBy('order_id');

            foreach ($orders as $order) {
                $history = $latestStatuses->get($order->id);

                $order->current_status =
                    $history->status ?? $order->status ?? 'pending';
            }
        } else {
            // Purane orders ke liye fallback.
            foreach ($orders as $order) {
                $order->current_status = $order->status ?? 'pending';
            }
        }

        return view('pages.my-orders', compact('orders'));
    }

    /**
     * Customer ke single order ki details aur tracking history.
     */
    public function show($orderNo)
    {
        $order = Order::with(['items', 'payment'])
            ->where('order_no', $orderNo)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Sirf isi customer ka address fetch hoga.
        $address = Address::where('id', $order->address_id)
            ->where('user_id', Auth::id())
            ->first();

        $statusHistory = collect();

        if (Schema::hasTable('order_status_history')) {
            $statusHistory = DB::table('order_status_history')
                ->where('order_id', $order->id)
                ->orderBy('created_at')
                ->orderBy('id')
                ->get();
        }

        // History ka last record latest status hota hai.
        $latestHistory = $statusHistory->last();

        $order->current_status =
            $latestHistory->status ?? $order->status ?? 'pending';

        return view('pages.order-details', compact(
            'order',
            'address',
            'statusHistory'
        ));
    }
}
