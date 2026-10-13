<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Latest status row for each order
        |--------------------------------------------------------------------------
        */

        $latestIds = DB::table('order_status_history')
            ->selectRaw('MAX(id) as id')
            ->groupBy('order_id');

        $latestStatuses = DB::table('order_status_history')
            ->joinSub($latestIds, 'latest_statuses', function ($join) {
                $join->on(
                    'order_status_history.id',
                    '=',
                    'latest_statuses.id'
                );
            })
            ->select(
                'order_status_history.order_id',
                'order_status_history.status'
            );

        /*
        |--------------------------------------------------------------------------
        | 1. Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        // Current month order revenue, including COD orders
        $revenue = (float) Order::where(
            'created_at',
            '>=',
            now()->startOfMonth()
        )
            ->where('created_at', '<=', now())
            ->sum('total');

        $stats = [
            // All orders
            'total_orders' => Order::count(),

            // Only orders whose latest history status is pending
            'pending' => (clone $latestStatuses)
                ->where('status', 'pending')
                ->count(),

            // Revenue from orders, including COD
            'revenue' => $this->money($revenue),

            // All active customer accounts
            'customers' => User::where('role', 'user')
                ->where('status', 'active')
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | 2. Sales Chart: Last 7 and 30 Days
        |--------------------------------------------------------------------------
        */

        $daily = Order::where(
            'created_at',
            '>=',
            now()->subDays(29)->startOfDay()
        )
            ->where('created_at', '<=', now())
            ->selectRaw('DATE(created_at) as day, SUM(total) as sales')
            ->groupBy('day')
            ->pluck('sales', 'day');

        $chart = [
            '7' => $this->series($daily, 7, 'D'),
            '30' => $this->series($daily, 30, 'd M'),
        ];

        /*
        |--------------------------------------------------------------------------
        | 3. Top Selling Items
        |--------------------------------------------------------------------------
        */

        $itemTable = (new Order)->items()->getRelated()->getTable();

        $topItems = DB::table($itemTable)
            ->selectRaw('product_name as name, SUM(quantity) as qty')
            ->groupBy('product_name')
            ->orderByDesc('qty')
            ->limit(4)
            ->get()
            ->map(fn ($row) => [
                'name' => $row->name ?? 'Product',
                'qty' => (int) $row->qty,
            ])
            ->all();

        /*
        |--------------------------------------------------------------------------
        | 4. Recent Orders
        |--------------------------------------------------------------------------
        */

        $orders = Order::with('items')
            ->latest()
            ->limit(5)
            ->get();

        $users = User::whereIn(
            'id',
            $orders->pluck('user_id')->filter()->unique()
        )
            ->get()
            ->keyBy('id');

        $statuses = DB::table('order_status_history')
            ->whereIn('order_id', $orders->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('order_id')
            ->keyBy('order_id');

        $recentOrders = $orders->map(function ($order) use (
            $users,
            $statuses
        ) {
            $first = $order->items->first();
            $extra = $order->items->count() - 1;

            $itemText = 'No items';

            if ($first) {
                $itemText = $first->product_name ?? 'Product';

                if (($first->quantity ?? 1) > 1) {
                    $itemText .= ' × ' . $first->quantity;
                }

                if ($extra > 0) {
                    $itemText .= ' + ' . $extra . ' more';
                }
            }

            $customer = $users->get($order->user_id);

            $latestStatus = $statuses->get($order->id);

            return [
                'id' => $order->id,
                'no' => $order->order_no ?: ('#' . $order->id),
                'customer' => $customer?->name ?? 'Customer',
                'item' => $itemText,
                'status' => $latestStatus?->status ?? 'pending',
                'amount' => (float) $order->total,
            ];
        })->all();

        /*
        |--------------------------------------------------------------------------
        | Return Existing Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('dash.home', compact(
            'stats',
            'chart',
            'topItems',
            'recentOrders'
        ));
    }

    /**
     * Build chart labels and values for the last N days.
     */
    private function series(
        $daily,
        int $days,
        string $labelFormat
    ): array {
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);

            $labels[] = $date->format($labelFormat);

            $data[] = round(
                (float) ($daily[$date->toDateString()] ?? 0),
                2
            );
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Format amounts using Indian currency notation.
     */
    private function money(float $value): string
    {
        if ($value >= 10000000) {
            return '₹' . round($value / 10000000, 2) . 'Cr';
        }

        if ($value >= 100000) {
            return '₹' . round($value / 100000, 1) . 'L';
        }

        return '₹' . number_format($value, 2);
    }
}
