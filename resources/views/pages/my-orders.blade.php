
@extends('layouts.site-layout')

@section('title', 'My Orders | Food Website')

@section('content')
<style>
    .my-orders-page {
        padding: 65px 15px;
        background: #f7f8fc;
        min-height: 70vh;
    }

    .my-orders-wrap {
        max-width: 1100px;
        margin: auto;
    }

    .my-orders-heading {
        margin-bottom: 30px;
    }

    .my-orders-heading h1 {
        color: #071b2c;
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .my-orders-heading p {
        color: #778292;
        margin: 0;
    }

    .my-order-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 15px;
        padding: 24px;
        margin-bottom: 18px;
        box-shadow: 0 5px 22px rgba(7, 27, 44, .04);
    }

    .my-order-top,
    .my-order-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .my-order-top {
        padding-bottom: 18px;
        border-bottom: 1px solid #edf0f5;
    }

    .my-order-label {
        color: #7b8794;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .my-order-number {
        color: #071b2c;
        font-size: 16px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .my-order-date {
        color: #667385;
        font-size: 13px;
        margin-top: 5px;
    }

    .my-order-middle {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 20px 0;
    }

    .my-order-products {
        color: #374151;
        font-size: 14px;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .my-order-total {
        color: #071b2c;
        font-size: 21px;
        font-weight: 800;
        white-space: nowrap;
    }

    .my-order-status {
        display: inline-block;
        border-radius: 30px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        background: #fff3dc;
        color: #99600a;
        text-transform: capitalize;
    }

    .my-order-status.success {
        background: #e5f8ed;
        color: #16814a;
    }

    .my-order-status.failed {
        background: #ffe9e9;
        color: #c22c2c;
    }

    .my-order-bottom {
        padding-top: 17px;
        border-top: 1px solid #edf0f5;
    }

    .my-order-payment {
        color: #667385;
        font-size: 13px;
        line-height: 1.8;
    }

    .my-order-details-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ff8c1a;
        color: #fff !important;
        text-decoration: none !important;
        padding: 11px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        transition: .2s;
    }

    .my-order-details-btn:hover {
        background: #e87508;
        transform: translateY(-1px);
    }

    .my-orders-empty {
        padding: 55px 20px;
        text-align: center;
        background: #fff;
        border-radius: 15px;
        border: 1px solid #e9edf3;
    }

    .my-orders-empty .empty-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .my-orders-empty h3 {
        color: #071b2c;
        font-weight: 800;
    }

    .my-orders-empty p {
        color: #778292;
    }

    .my-orders-pagination {
        margin-top: 25px;
    }

    @media (max-width: 600px) {
        .my-orders-page {
            padding: 35px 12px;
        }

        .my-orders-heading h1 {
            font-size: 27px;
        }

        .my-order-card {
            padding: 17px;
        }

        .my-order-middle {
            flex-direction: column;
            gap: 12px;
        }

        .my-order-bottom {
            align-items: stretch;
        }

        .my-order-details-btn {
            width: 100%;
        }
    }
</style>

<section class="my-orders-page">
    <div class="my-orders-wrap">

        <div class="my-orders-heading">
            <h1>My Orders</h1>
            <p>Track your orders and view your previous purchases.</p>
        </div>

        @forelse ($orders as $order)
            @php
                $paymentStatus = $order->payment->status ?? 'Pending';
                $paymentClass = strtolower((string) $paymentStatus);
                $currentStatus = $order->current_status ?? $order->status ?? 'pending';

$statusClass = match ($currentStatus) {
    'complete' => 'success',
    'cancelled', 'failed', 'returned' => 'failed',
    default => '',
};

$statusLabel = match ($currentStatus) {
    'complete' => 'Completed',
    'out_for_delivery' => 'Out for Delivery',
    'return_requested' => 'Return Requested',
    default => ucwords(str_replace('_', ' ', $currentStatus)),
};

                $productNames = $order->items
                    ->map(function ($item) {
                        return $item->product_name . ' × ' . $item->quantity;
                    })
                    ->take(3);

                $extraProducts = max($order->items->count() - 3, 0);
            @endphp

            <div class="my-order-card">
                <div class="my-order-top">
                    <div>
                        <div class="my-order-label">ORDER NUMBER</div>
                        <div class="my-order-number">
                            {{ $order->order_no }}
                        </div>
                        <div class="my-order-date">
                            Placed on
                            {{ $order->created_at
                                ? $order->created_at->format('d M Y, h:i A')
                                : 'Date unavailable' }}
                        </div>
                    </div>

                    <div>
                        <span class="my-order-status {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>

                <div class="my-order-middle">
                    <div class="my-order-products">
                        @forelse ($productNames as $productName)
                            <div>{{ $productName }}</div>
                        @empty
                            <div>Order items unavailable</div>
                        @endforelse

                        @if ($extraProducts > 0)
                            <div>+ {{ $extraProducts }} more product(s)</div>
                        @endif
                    </div>

                    <div class="my-order-total">
                        ₹{{ number_format((float) $order->total, 2) }}
                    </div>
                </div>

                <div class="my-order-bottom">
                    <div class="my-order-payment">
                        <div>
                            Payment:
                            <strong>{{ ucfirst($order->payment->method ?? 'Cash') }}</strong>
                        </div>
                        <div>
                            Payment Status:
                            <span class="my-order-status {{ in_array($paymentClass, ['success', 'paid', 'completed']) ? 'success' : (in_array($paymentClass, ['failed', 'refunded']) ? 'failed' : '') }}">
                                {{ $paymentStatus }}
                            </span>
                        </div>
                    </div>

                    <a
                        href="{{ route('orders.show', $order->order_no) }}"
                        class="my-order-details-btn"
                    >
                        View Order Details &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="my-orders-empty">
                <div class="empty-icon">🛍️</div>
                <h3>No Orders Yet</h3>
                <p>Your placed orders will appear here.</p>

                <a
                    href="{{ route('site.products') }}"
                    class="my-order-details-btn"
                >
                    Explore Menu
                </a>
            </div>
        @endforelse

        @if ($orders->hasPages())
            <div class="my-orders-pagination">
                {{ $orders->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
