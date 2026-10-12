@extends('layouts.site-layout')

@section('title', 'Order Details | Food Website')

@section('content')
<style>
    .order-details-page {
        padding: 60px 15px;
        background: #f7f8fc;
        min-height: 70vh;
    }

    .order-details-wrap {
        max-width: 1100px;
        margin: auto;
    }

    .order-details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .order-details-header h1 {
        margin: 0 0 8px;
        color: #071b2c;
        font-size: 31px;
        font-weight: 800;
    }

    .order-details-header p {
        margin: 0;
        color: #788494;
        overflow-wrap: anywhere;
    }

    .order-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 17px;
        border-radius: 8px;
        background: #fff;
        border: 1px solid #dce2e9;
        color: #071b2c !important;
        text-decoration: none !important;
        font-size: 13px;
        font-weight: 700;
    }

    .order-details-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(270px, 1fr);
        gap: 22px;
        align-items: start;
    }

    .order-details-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 22px;
        box-shadow: 0 5px 22px rgba(7, 27, 44, .035);
        min-width: 0;
    }

    .order-details-card h3 {
        color: #071b2c;
        font-size: 19px;
        font-weight: 800;
        margin: 0 0 22px;
    }

    .order-detail-product {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 18px;
        padding: 18px 0;
        border-bottom: 1px solid #edf0f5;
    }

    .order-detail-product:first-of-type {
        padding-top: 0;
    }

    .order-detail-product:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .order-detail-product h4 {
        color: #071b2c;
        font-size: 15px;
        line-height: 1.5;
        font-weight: 700;
        margin: 0 0 7px;
        overflow-wrap: anywhere;
    }

    .order-detail-product p {
        color: #7a8594;
        font-size: 13px;
        margin: 0;
        line-height: 1.8;
    }

    .order-detail-product-price {
        color: #071b2c;
        font-size: 15px;
        font-weight: 800;
        white-space: nowrap;
    }

    .order-total-line {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 9px 0;
        color: #667385;
        font-size: 14px;
    }

    .order-total-line strong {
        color: #071b2c;
        font-weight: 700;
        text-align: right;
    }

    .order-total-final {
        border-top: 1px solid #e9edf3;
        margin-top: 10px;
        padding-top: 18px;
        color: #071b2c;
        font-size: 17px;
        font-weight: 800;
    }

    .order-total-final strong {
        color: #ff8c1a;
        font-size: 23px;
    }

    .order-address-name {
        color: #071b2c;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    .order-address-text {
        color: #667385;
        font-size: 14px;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .order-payment-method {
        display: inline-block;
        background: #eef5ff;
        color: #245ba8;
        border-radius: 7px;
        padding: 7px 11px;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .order-payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        font-size: 13px;
        color: #778292;
    }

    .order-payment-row strong {
        color: #071b2c;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .order-payment-status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 30px;
        background: #fff3dc;
        color: #99600a !important;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .order-history-item {
        position: relative;
        padding: 0 0 22px 24px;
        border-left: 2px solid #e8edf3;
        margin-left: 5px;
    }

    .order-history-item:last-child {
        padding-bottom: 0;
        border-left-color: transparent;
    }

    .order-history-item:before {
        content: '';
        position: absolute;
        left: -7px;
        top: 2px;
        width: 12px;
        height: 12px;
        background: #ff8c1a;
        border-radius: 50%;
        box-shadow: 0 0 0 4px #fff0df;
    }

    .order-history-item strong {
        display: block;
        color: #071b2c;
        font-size: 14px;
        margin-bottom: 5px;
        text-transform: capitalize;
    }

    .order-history-item p {
        margin: 0;
        color: #788494;
        font-size: 13px;
        line-height: 1.7;
    }

    .order-history-item small {
        display: block;
        color: #98a1ad;
        margin-top: 6px;
    }

    .order-details-empty {
        color: #788494;
        font-size: 14px;
        line-height: 1.7;
    }

    @media (max-width: 767px) {
        .order-details-page {
            padding: 35px 12px;
        }

        .order-details-header h1 {
            font-size: 26px;
        }

        .order-details-grid {
            grid-template-columns: 1fr;
        }

        .order-details-card {
            padding: 19px 16px;
        }

        .order-detail-product {
            gap: 10px;
        }

        .order-detail-product-price {
            font-size: 14px;
        }
    }
</style>

@php
$payment = $order->payment;
$paymentStatus = $payment->status ?? 'Pending';
$paymentMethod = $payment->method ?? 'cash';


$currentStatus = $statusHistory->last()->status ?? 'pending';

$statusLabels = [
'pending' => 'Pending',
'packed' => 'Packed',
'picked' => 'Picked Up',
'shipped' => 'Shipped',
'out_for_delivery' => 'Out for Delivery',
'complete' => 'Completed',
'cancelled' => 'Cancelled',
'return_requested' => 'Return Requested',
'returned' => 'Returned',
'failed' => 'Failed',
];

$currentStatusLabel = $statusLabels[$currentStatus]
?? ucwords(str_replace('_', ' ', $currentStatus));

@endphp

<section class="order-details-page">
    <div class="order-details-wrap">

        <div class="order-details-header">
            <div>
                <h1>Order Details</h1>
                <p>
                    Order #{{ $order->order_no }}
                    &nbsp;·&nbsp;
                    {{ $order->created_at
                    ? \Illuminate\Support\Carbon::parse($order->created_at)->format('d M Y, h:i A')
                    : 'Date unavailable'
                    }}
                </p>

                <div style="margin-top:15px;">
                    <span style="color:#667385;font-size:13px;">
                        Current Order Status:
                    </span>

                    <span
                        style="display:inline-block;margin-left:6px;padding:7px 13px;border-radius:30px;background:#fff0df;color:#a95800;font-size:12px;font-weight:800;">
                        {{ $currentStatusLabel }}
                    </span>
                </div>

            </div>

            <a href="{{ route('orders.my') }}" class="order-back-btn">
                &larr; Back to My Orders
            </a>
        </div>

        <div class="order-details-grid">

            {{-- LEFT COLUMN --}}
            <div>

                {{-- PRODUCTS --}}
                <div class="order-details-card">
                    <h3>Products in Your Order</h3>

                    @forelse ($order->items as $item)
                    <div class="order-detail-product">
                        <div>
                            <h4>{{ $item->product_name }}</h4>

                            <p>
                                Quantity: {{ $item->quantity }}<br>
                                Unit Price:
                                ₹{{ number_format((float) $item->price, 2) }}
                            </p>
                        </div>

                        <div class="order-detail-product-price">
                            ₹{{ number_format((float) $item->subtotal, 2) }}
                        </div>
                    </div>
                    @empty
                    <p class="order-details-empty">
                        No product details are available for this order.
                    </p>
                    @endforelse
                </div>

                {{-- ORDER TOTAL --}}
                <div class="order-details-card">
                    <h3>Price Summary</h3>

                    <div class="order-total-line">
                        <span>Subtotal</span>
                        <strong>
                            ₹{{ number_format((float) $order->subtotal, 2) }}
                        </strong>
                    </div>

                    @if ((float) $order->discount > 0)
                    <div class="order-total-line">
                        <span>Discount</span>
                        <strong>
                            - ₹{{ number_format((float) $order->discount, 2) }}
                        </strong>
                    </div>
                    @endif

                    @if ((float) $order->shipping > 0)
                    <div class="order-total-line">
                        <span>Shipping</span>
                        <strong>
                            ₹{{ number_format((float) $order->shipping, 2) }}
                        </strong>
                    </div>
                    @endif

                    @if ((float) $order->cgst > 0)
                    <div class="order-total-line">
                        <span>CGST</span>
                        <strong>
                            ₹{{ number_format((float) $order->cgst, 2) }}
                        </strong>
                    </div>
                    @endif

                    @if ((float) $order->sgst > 0)
                    <div class="order-total-line">
                        <span>SGST</span>
                        <strong>
                            ₹{{ number_format((float) $order->sgst, 2) }}
                        </strong>
                    </div>
                    @endif

                    @if ((float) $order->igst > 0)
                    <div class="order-total-line">
                        <span>IGST</span>
                        <strong>
                            ₹{{ number_format((float) $order->igst, 2) }}
                        </strong>
                    </div>
                    @endif

                    <div class="order-total-line order-total-final">
                        <span>Total Amount</span>
                        <strong>
                            ₹{{ number_format((float) $order->total, 2) }}
                        </strong>
                    </div>
                </div>

                {{-- ORDER HISTORY --}}
                <div class="order-details-card">
                    <h3>Order Updates</h3>

                    @forelse ($statusHistory as $history)
                    <div class="order-history-item">
                        <strong>
                            {{ $history->title ?: ($statusLabels[$history->status] ?? ucwords(str_replace('_', ' ',
                            $history->status))) }}
                        </strong>

                        @if ($history->description)
                        <p>{{ $history->description }}</p>
                        @endif

                        @if ($history->location)
                        <p>Location: {{ $history->location }}</p>
                        @endif

                        <small>
                            {{ \Illuminate\Support\Carbon::parse($history->created_at)->format('d M Y, h:i A') }}
                        </small>
                    </div>
                    @empty
                    <p class="order-details-empty">
                        Your order has been placed. Further updates will
                        appear here when available.
                    </p>
                    @endforelse
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div>

                {{-- DELIVERY ADDRESS --}}
                <div class="order-details-card">
                    <h3>Delivery Address</h3>

                    @if ($address)
                    <div class="order-address-name">
                        {{ $address->name }}
                    </div>

                    <div class="order-address-text">
                        <div>
                            <strong>Mobile:</strong>
                            {{ $address->mobile }}
                        </div>

                        <div>
                            {{ $address->address }}
                        </div>

                        @if ($address->city)
                        <div>{{ $address->city }}</div>
                        @endif

                        @if ($address->state)
                        <div>{{ $address->state }}</div>
                        @endif

                        @if ($address->pincode)
                        <div>PIN: {{ $address->pincode }}</div>
                        @endif

                        @if ($address->country)
                        <div>{{ $address->country }}</div>
                        @endif
                    </div>
                    @else
                    <p class="order-details-empty">
                        Delivery address is not available for this order.
                    </p>
                    @endif
                </div>

                {{-- PAYMENT DETAILS --}}
                <div class="order-details-card">
                    <h3>Payment Details</h3>

                    <div class="order-payment-method">
                        {{ strtoupper(str_replace('_', ' ', $paymentMethod)) }}
                    </div>

                    <div class="order-payment-row">
                        <span>Payment Status</span>
                        <strong>
                            <span class="order-payment-status">
                                {{ $paymentStatus }}
                            </span>
                        </strong>
                    </div>

                    <div class="order-payment-row">
                        <span>Payment Amount</span>
                        <strong>
                            ₹{{ number_format((float) ($payment->amount ?? $order->total), 2) }}
                        </strong>
                    </div>

                    @if ($payment && $payment->gateway)
                    <div class="order-payment-row">
                        <span>Payment Gateway</span>
                        <strong>{{ $payment->gateway }}</strong>
                    </div>
                    @endif

                    <div class="order-payment-row">
                        <span>Order Number</span>
                        <strong>{{ $order->order_no }}</strong>
                    </div>
                </div>

                @if ($order->notes)
                <div class="order-details-card">
                    <h3>Order Notes</h3>
                    <p class="order-details-empty">
                        {{ $order->notes }}
                    </p>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection