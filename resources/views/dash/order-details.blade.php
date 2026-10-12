
@extends('layouts.dash-layout')

@section('title', 'Order Details')

@section('content')
@php
    $currentStatus = $status->status ?? 'pending';
    $items = $order->items ?? collect();

    $statusColors = [
        'pending' => 'warning', 'packed' => 'info', 'picked' => 'info',
        'shipped' => 'primary', 'out_for_delivery' => 'primary',
        'complete' => 'success', 'cancelled' => 'danger',
        'return_requested' => 'warning', 'returned' => 'secondary',
        'failed' => 'danger',
    ];

    $statusLabels = [
        'pending' => 'Pending', 'packed' => 'Packed', 'picked' => 'Picked',
        'shipped' => 'Shipped', 'out_for_delivery' => 'Out for Delivery',
        'complete' => 'Completed', 'cancelled' => 'Cancelled',
        'return_requested' => 'Return Requested', 'returned' => 'Returned',
        'failed' => 'Failed',
    ];

    $statusColor = $statusColors[$currentStatus] ?? 'secondary';
    $statusLabel = $statusLabels[$currentStatus] ?? ucwords(str_replace('_', ' ', $currentStatus));

    $subtotal = (float) ($order->subtotal ?? $items->sum(fn($item) => (float) ($item->subtotal ?? ((float) ($item->price ?? 0) * (int) ($item->quantity ?? 1)))));
    $discount = (float) ($order->discount ?? 0);
    $shipping = (float) ($order->shipping ?? $order->shipping_charge ?? 0);
    $total = (float) ($order->total ?? $order->total_amount ?? 0);
@endphp

<style>
.order-detail-page{color:#071b2c;font-size:13px}
.order-detail-page .detail-card{background:#fff;border:1px solid #e9edf2;border-radius:10px;padding:16px;height:100%;box-shadow:0 2px 10px rgba(7,27,44,.03)}
.order-detail-page .detail-heading{font-size:15px;font-weight:700;margin-bottom:14px;color:#071b2c}
.order-detail-page .detail-heading i{color:#ff8c1a;margin-right:7px}
.order-detail-page .detail-label{color:#77818d;font-size:11px;margin-bottom:4px}
.order-detail-page .detail-value{font-size:13px;font-weight:600;overflow-wrap:anywhere;line-height:1.5}
.order-detail-page .detail-item{margin-bottom:13px}
.order-detail-page .table th{background:#f7f9fb;color:#657180;font-size:11px;text-transform:uppercase;white-space:nowrap;padding:10px}
.order-detail-page .table td{padding:11px 10px;vertical-align:middle;font-size:13px}
.order-detail-page .status-badge{display:inline-block;padding:5px 10px;border-radius:20px;font-size:11px;font-weight:700}
.order-detail-page .status-warning{background:#fff3cd;color:#856404}
.order-detail-page .status-info{background:#cff4fc;color:#055160}
.order-detail-page .status-primary{background:#dbeafe;color:#1d4ed8}
.order-detail-page .status-success{background:#d1e7dd;color:#0f5132}
.order-detail-page .status-danger{background:#f8d7da;color:#842029}
.order-detail-page .status-secondary{background:#e2e3e5;color:#41464b}
.order-detail-page .back-btn{display:inline-block;border:1px solid #dce2e8;background:#fff;color:#071b2c;border-radius:7px;padding:8px 12px;text-decoration:none;font-size:12px;font-weight:600}
.order-detail-page .address-highlight{background:#fff8ef;border:1px solid #ffe2c0;padding:10px;border-radius:8px;margin-bottom:13px}
.order-detail-page .address-default{display:inline-block;background:#d1e7dd;color:#146c43;padding:4px 8px;border-radius:20px;font-size:10px;font-weight:700}
.order-detail-page .empty-info{color:#77818d;background:#f7f9fb;padding:10px;border-radius:7px;font-size:12px}
.order-detail-page .total-row{display:flex;justify-content:space-between;gap:12px;padding:8px 0;font-size:13px}
.order-detail-page .grand-total{border-top:1px solid #e9edf2;margin-top:5px;padding-top:12px;font-size:16px;font-weight:800}
@media(max-width:767px){.order-detail-page .detail-card{padding:13px}.order-detail-page .page-header{align-items:flex-start!important}}
</style>

<div class="order-detail-page">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h4 class="page-title mb-1">Order Details</h4>
            <div class="text-muted small">Order #{{ $order->order_no ?? $order->id }}</div>
        </div>
        <a href="{{ route('orders.index') }}" class="back-btn">
            <i class="fas fa-arrow-left me-1"></i> Back to Orders
        </a>
    </div>

    {{-- Overview --}}
    <div class="row g-2 mb-3">
        <div class="col-12 col-md-4">
            <div class="detail-card">
                <div class="detail-label">Order Number</div>
                <div class="detail-value">{{ $order->order_no ?? '#'.$order->id }}</div>
                <div class="detail-label mt-2">Order Date</div>
                <div class="detail-value">{{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="detail-card">
                <div class="detail-label mb-2">Current Status</div>
                <span class="status-badge status-{{ $statusColor }}">{{ $statusLabel }}</span>
                @if(!empty($status?->title))
                    <div class="detail-label mt-2">Status Title</div>
                    <div class="detail-value">{{ $status->title }}</div>
                @endif
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="detail-card">
                <div class="detail-label">Order Total</div>
                <div class="fw-bold fs-4">₹{{ number_format($total, 2) }}</div>
                <div class="text-muted small">{{ $items->count() }} order line(s)</div>
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Products --}}
        <div class="col-12 col-xl-8">
            <div class="detail-card">
                <h5 class="detail-heading"><i class="fas fa-shopping-bag"></i>Ordered Products</h5>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>Product</th><th>Price</th><th>Qty</th><th class="text-end">Subtotal</th></tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                @php
                                    $itemPrice = (float) ($item->price ?? 0);
                                    $itemQty = (int) ($item->quantity ?? 1);
                                    $itemSubtotal = (float) ($item->subtotal ?? ($itemPrice * $itemQty));
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->product_name ?? $item->name ?? 'Product' }}</div>
                                        @if(!empty($item->product_id))
                                            <small class="text-muted">ID: {{ $item->product_id }}</small>
                                        @endif
                                    </td>
                                    <td>₹{{ number_format($itemPrice, 2) }}</td>
                                    <td>{{ $itemQty }}</td>
                                    <td class="text-end fw-semibold">₹{{ number_format($itemSubtotal, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No order items found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(!empty($status?->description))
                <div class="detail-card mt-3">
                    <h5 class="detail-heading"><i class="fas fa-clipboard-list"></i>Status Note</h5>
                    <p class="text-muted mb-0">{{ $status->description }}</p>
                </div>
            @endif
        </div>

        {{-- Customer, Address and Payment --}}
        <div class="col-12 col-xl-4">

            <div class="detail-card mb-3">
                <h5 class="detail-heading"><i class="fas fa-user"></i>Customer Information</h5>
                <div class="detail-item">
                    <div class="detail-label">Name</div>
                    <div class="detail-value">{{ $customer->name ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $customer->email ?? 'N/A' }}</div>
                </div>
                @if(!empty($customer?->phone))
                    <div class="detail-item mb-0">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value">{{ $customer->phone }}</div>
                    </div>
                @endif
            </div>

            {{-- Delivery Address --}}
            <div class="detail-card mb-3">
                <h5 class="detail-heading"><i class="fas fa-map-marker-alt"></i>Delivery Address</h5>

                @if($address)
                    @if(($address->is_default ?? 'No') === 'Yes')
                        <div class="mb-2"><span class="address-default">Default Address</span></div>
                    @endif

                    <div class="address-highlight">
                        <div class="detail-label">Recipient Name</div>
                        <div class="detail-value">{{ $address->name ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Mobile Number</div>
                        <div class="detail-value">
                            @if(!empty($address->mobile))
                                <a href="tel:{{ $address->mobile }}" class="text-decoration-none text-dark">
                                    <i class="fas fa-phone-alt text-warning me-1"></i>{{ $address->mobile }}
                                </a>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Complete Address</div>
                        <div class="detail-value">{{ $address->address ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Country</div>
                        <div class="detail-value">{{ $address->country ?? 'India' }}</div>
                    </div>

                    <div class="detail-item mb-0">
                        <div class="detail-label">Address Type</div>
                        <div class="detail-value">
                            {{ ($address->is_default ?? 'No') === 'Yes' ? 'Default Saved Address' : 'Saved Address' }}
                        </div>
                    </div>
                @else
                    <div class="empty-info">No saved address found for this customer.</div>
                @endif
            </div>

            {{-- Payment --}}
            <div class="detail-card">
                <h5 class="detail-heading"><i class="fas fa-credit-card"></i>Payment Information</h5>
                @if($order->payment)
                    <div class="detail-item">
                        <div class="detail-label">Payment Status</div>
                        <div class="detail-value">{{ $order->payment->status ?? 'N/A' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Payment Method</div>
                        <div class="detail-value">{{ $order->payment->payment_method ?? $order->payment->method ?? 'N/A' }}</div>
                    </div>
                    <div class="detail-item mb-0">
                        <div class="detail-label">Transaction ID</div>
                        <div class="detail-value">{{ $order->payment->transaction_id ?? 'N/A' }}</div>
                    </div>
                @else
                    <div class="empty-info">No payment record found.</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row justify-content-end mt-3">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="detail-card">
                <h5 class="detail-heading"><i class="fas fa-receipt"></i>Order Summary</h5>
                <div class="total-row"><span>Subtotal</span><span>₹{{ number_format($subtotal, 2) }}</span></div>
                <div class="total-row"><span>Discount</span><span>- ₹{{ number_format($discount, 2) }}</span></div>
                <div class="total-row"><span>Shipping</span><span>₹{{ number_format($shipping, 2) }}</span></div>
                <div class="total-row grand-total"><span>Total</span><span>₹{{ number_format($total, 2) }}</span></div>
            </div>
        </div>
    </div>

</div>
@endsection
