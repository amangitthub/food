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

    // Delivery progress (only for the normal flow)
    $flow = ['pending', 'packed', 'picked', 'shipped', 'out_for_delivery', 'complete'];
    $flowIndex = array_search($currentStatus, $flow, true);
    $onFlow = $flowIndex !== false;
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Jost:wght@300;400;500&display=swap');

/* Make sure icons always render, whatever the layout loads */
.od .fas{font-family:"Font Awesome 6 Free" !important; font-weight:900 !important; font-style:normal}

/* ---------- Theme (change colours here) ---------- */
.od{
    --ink:#151515; --rose:#D9A5A0; --rose-deep:#B9807A; --page:#FBF7F6;
    --card:#ffffff; --line:#F0E5E2; --muted:#8C807D; --soft:#FDF9F8;
    font-family:'Jost',system-ui,sans-serif; font-weight:300; font-size:14px;
    color:var(--ink); line-height:1.55; max-width:1200px; margin:0 auto;
}
.od *{box-sizing:border-box}
.od a{color:inherit}
.od-serif{font-family:'Cormorant Garamond',Georgia,serif}

/* ---------- Top bar ---------- */
.od-back{
    display:inline-flex; align-items:center; gap:8px; margin-bottom:14px;
    padding:8px 16px; border:1px solid var(--line); border-radius:999px;
    background:var(--card); color:var(--ink); text-decoration:none; font-weight:400; font-size:13px;
    transition:border-color .2s, background .2s;
}
.od-back:hover{border-color:var(--rose); background:var(--soft)}
.od-back:focus-visible,.od a:focus-visible{outline:2px solid var(--rose-deep); outline-offset:2px}

/* ---------- Hero ---------- */
.od-hero{
    background:var(--ink); color:#fff; border-radius:18px; padding:clamp(20px,4vw,34px);
    display:flex; flex-wrap:wrap; gap:24px; justify-content:space-between; align-items:flex-end;
    position:relative; overflow:hidden;
}
.od-hero::after{
    content:""; position:absolute; right:-60px; top:-60px; width:220px; height:220px;
    border-radius:50%; border:1px solid rgba(217,165,160,.28); pointer-events:none;
}
.od-hero-label{color:var(--rose); font-size:13px; letter-spacing:.04em; margin-bottom:4px}
.od-hero-no{font-size:clamp(30px,6vw,48px); line-height:1.05; margin:0; font-weight:500; word-break:break-word}
.od-hero-date{color:#c9c0be; margin-top:8px; font-size:13px}
.od-hero-right{text-align:right; position:relative; z-index:1}
.od-hero-total{font-size:clamp(30px,6vw,46px); line-height:1.05; color:var(--rose); font-weight:500}
.od-hero-meta{color:#c9c0be; font-size:13px; margin-top:6px}
@media(max-width:640px){.od-hero-right{text-align:left; width:100%}}

/* ---------- Status pill ---------- */
.od-pill{display:inline-flex; align-items:center; gap:6px; padding:5px 13px; border-radius:999px; font-size:12px; font-weight:500; margin-top:12px}
.od-pill::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor}
.st-warning{background:#FFF3CD; color:#7A5B00}
.st-info{background:#D5F1F8; color:#055160}
.st-primary{background:#DCE8FE; color:#1D4ED8}
.st-success{background:#D6EEDF; color:#0F5132}
.st-danger{background:#F9DADD; color:#842029}
.st-secondary{background:#E7E5E4; color:#41464B}

/* ---------- Progress ---------- */
.od-card{background:var(--card); border:1px solid var(--line); border-radius:16px; padding:clamp(16px,3vw,24px)}
.od-progress{margin-top:16px; overflow-x:auto}
.od-steps{display:flex; min-width:560px; list-style:none; margin:0; padding:0}
.od-step{flex:1; text-align:center; position:relative; color:var(--muted); font-size:12px}
.od-step::before{
    content:""; position:absolute; top:11px; left:-50%; width:100%; height:2px; background:var(--line);
}
.od-step:first-child::before{display:none}
.od-dot{
    width:24px; height:24px; border-radius:50%; margin:0 auto 8px; position:relative; z-index:1;
    background:var(--card); border:2px solid var(--line); display:flex; align-items:center; justify-content:center;
    font-size:10px; color:#fff;
}
.od-step.done{color:var(--ink)}
.od-step.done::before{background:var(--rose)}
.od-step.done .od-dot{background:var(--rose); border-color:var(--rose)}
.od-step.now .od-dot{background:var(--ink); border-color:var(--ink); box-shadow:0 0 0 4px rgba(217,165,160,.35)}
.od-step.now{font-weight:500}
.od-alert{margin-top:16px; padding:12px 16px; border-radius:12px; font-size:13px}

/* ---------- Layout ---------- */
.od-grid{display:grid; grid-template-columns:minmax(0,1fr) 340px; gap:20px; margin-top:20px; align-items:start}
.od-col{display:grid; gap:20px; min-width:0}
@media(max-width:1020px){.od-grid{grid-template-columns:minmax(0,1fr)}}

.od-h{display:flex; align-items:center; gap:10px; margin:0 0 16px; font-size:22px; font-weight:600}
.od-h i{font-size:13px; color:var(--rose-deep); width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background:var(--soft); border:1px solid var(--line)}

/* ---------- Detail rows ---------- */
.od-field{padding:11px 0; border-bottom:1px dashed var(--line)}
.od-field:last-child{border-bottom:0; padding-bottom:0}
.od-field:first-of-type{padding-top:0}
.od-label{color:var(--muted); font-size:12px; margin-bottom:2px}
.od-value{font-weight:400; font-size:14px; overflow-wrap:anywhere}
.od-tag{display:inline-block; padding:3px 11px; border-radius:999px; background:#D6EEDF; color:#0F5132; font-size:11px; font-weight:500; margin-bottom:12px}
.od-recipient{background:var(--soft); border:1px solid var(--line); border-radius:12px; padding:12px 14px; margin-bottom:12px}
.od-empty{background:var(--soft); border:1px dashed var(--line); border-radius:12px; padding:14px; color:var(--muted); font-size:13px}
.od-phone{text-decoration:none}
.od-phone i{color:var(--rose-deep); margin-right:6px}

/* ---------- Products table ---------- */
.od-table-wrap{overflow-x:auto}
.od-table{width:100%; border-collapse:collapse}
.od-table th{
    text-align:left; font-weight:500; font-size:12px; color:var(--muted);
    padding:0 12px 12px; border-bottom:1px solid var(--line); white-space:nowrap;
}
.od-table td{padding:14px 12px; border-bottom:1px solid var(--line); vertical-align:middle}
.od-table tbody tr:last-child td{border-bottom:0}
.od-table tbody tr:hover{background:var(--soft)}
.od-table .r{text-align:right}
.od-pname{font-weight:500}
.od-pid{color:var(--muted); font-size:12px}
.od-qty{display:inline-block; min-width:32px; text-align:center; padding:2px 10px; border-radius:999px; background:var(--soft); border:1px solid var(--line)}

@media(max-width:640px){
    .od-table thead{display:none}
    .od-table, .od-table tbody, .od-table tr, .od-table td{display:block; width:100%}
    .od-table tr{border:1px solid var(--line); border-radius:12px; padding:10px 12px; margin-bottom:10px}
    .od-table td{display:flex; justify-content:space-between; gap:12px; padding:6px 0; border:0; text-align:right}
    .od-table td::before{content:attr(data-label); color:var(--muted); font-size:12px; text-align:left}
    .od-table td.od-first{display:block; text-align:left}
    .od-table td.od-first::before{display:none}
    .od-table .r{text-align:right}
}

/* ---------- Summary ---------- */
.od-row{display:flex; justify-content:space-between; gap:12px; padding:8px 0}
.od-row span:first-child{color:var(--muted)}
.od-grand{border-top:1px solid var(--line); margin-top:8px; padding-top:14px; align-items:baseline}
.od-grand span:first-child{color:var(--ink); font-weight:500}
.od-grand span:last-child{font-size:26px; font-weight:600; color:var(--rose-deep)}
</style>

<div class="od">

    <a href="{{ route('orders.index') }}" class="od-back">
        <i class="fas fa-arrow-left"></i> Back to orders
    </a>

    {{-- Hero --}}
    <section class="od-hero">
        <div style="position:relative;z-index:1">
            <div class="od-hero-label">Order</div>
            <h1 class="od-hero-no od-serif">{{ $order->order_no ?? '#'.$order->id }}</h1>
            <div class="od-hero-date">Placed on {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</div>
            <span class="od-pill st-{{ $statusColor }}">{{ $statusLabel }}</span>
            @if(!empty($status?->title))
                <div class="od-hero-date mt-2">{{ $status->title }}</div>
            @endif
        </div>
        <div class="od-hero-right">
            <div class="od-hero-meta">Order total</div>
            <div class="od-hero-total od-serif">₹{{ number_format($total, 2) }}</div>
            <div class="od-hero-meta">{{ $items->count() }} {{ \Illuminate\Support\Str::plural('item', $items->count()) }}</div>
        </div>
    </section>

    {{-- Progress --}}
    <section class="od-card" style="margin-top:20px">
        @if($onFlow)
            <div class="od-progress">
                <ol class="od-steps">
                    @foreach($flow as $i => $step)
                        <li class="od-step {{ $i < $flowIndex ? 'done' : '' }} {{ $i === $flowIndex ? 'now' : '' }}">
                            <div class="od-dot">
                                @if($i < $flowIndex)<i class="fas fa-check"></i>@endif
                            </div>
                            {{ $statusLabels[$step] }}
                        </li>
                    @endforeach
                </ol>
            </div>
        @else
            <div class="od-alert st-{{ $statusColor }}" style="margin-top:0">
                This order is <strong>{{ $statusLabel }}</strong>.
                @if(!empty($status?->title)) {{ $status->title }} @endif
            </div>
        @endif
    </section>

    <div class="od-grid">

        {{-- Left column --}}
        <div class="od-col">

            {{-- Products --}}
            <section class="od-card">
                <h2 class="od-h od-serif"><i class="fas fa-shopping-bag"></i>Ordered products</h2>
                <div class="od-table-wrap">
                    <table class="od-table">
                        <thead>
                            <tr><th>Product</th><th>Price</th><th>Qty</th><th class="r">Subtotal</th></tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                @php
                                    $itemPrice = (float) ($item->price ?? 0);
                                    $itemQty = (int) ($item->quantity ?? 1);
                                    $itemSubtotal = (float) ($item->subtotal ?? ($itemPrice * $itemQty));
                                @endphp
                                <tr>
                                    <td class="od-first">
                                        <div class="od-pname">{{ $item->product_name ?? $item->name ?? 'Product' }}</div>
                                        @if(!empty($item->product_id))
                                            <div class="od-pid">ID: {{ $item->product_id }}</div>
                                        @endif
                                    </td>
                                    <td data-label="Price">₹{{ number_format($itemPrice, 2) }}</td>
                                    <td data-label="Qty"><span class="od-qty">{{ $itemQty }}</span></td>
                                    <td data-label="Subtotal" class="r" style="font-weight:500">₹{{ number_format($itemSubtotal, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="od-empty" style="text-align:center">No order items found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Status note --}}
            @if(!empty($status?->description))
                <section class="od-card">
                    <h2 class="od-h od-serif"><i class="fas fa-clipboard-list"></i>Status note</h2>
                    <p style="margin:0;color:var(--muted)">{{ $status->description }}</p>
                </section>
            @endif

            {{-- Summary --}}
            <section class="od-card">
                <h2 class="od-h od-serif"><i class="fas fa-receipt"></i>Order summary</h2>
                <div class="od-row"><span>Subtotal</span><span>₹{{ number_format($subtotal, 2) }}</span></div>
                <div class="od-row"><span>Discount</span><span>- ₹{{ number_format($discount, 2) }}</span></div>
                <div class="od-row"><span>Shipping</span><span>₹{{ number_format($shipping, 2) }}</span></div>
                <div class="od-row od-grand"><span>Total</span><span class="od-serif">₹{{ number_format($total, 2) }}</span></div>
            </section>
        </div>

        {{-- Right column --}}
        <div class="od-col">

            {{-- Customer --}}
            <section class="od-card">
                <h2 class="od-h od-serif"><i class="fas fa-user"></i>Customer</h2>
                <div class="od-field">
                    <div class="od-label">Name</div>
                    <div class="od-value">{{ $customer->name ?? 'N/A' }}</div>
                </div>
                <div class="od-field">
                    <div class="od-label">Email</div>
                    <div class="od-value">{{ $customer->email ?? 'N/A' }}</div>
                </div>
                @if(!empty($customer?->phone))
                    <div class="od-field">
                        <div class="od-label">Phone</div>
                        <div class="od-value">{{ $customer->phone }}</div>
                    </div>
                @endif
            </section>

            {{-- Delivery address --}}
            <section class="od-card">
                <h2 class="od-h od-serif"><i class="fas fa-map-marker-alt"></i>Delivery address</h2>

                @if($address)
                    @if(($address->is_default ?? 'No') === 'Yes')
                        <span class="od-tag">Default address</span>
                    @endif

                    <div class="od-recipient">
                        <div class="od-label">Recipient</div>
                        <div class="od-value">{{ $address->name ?? 'N/A' }}</div>
                    </div>

                    <div class="od-field">
                        <div class="od-label">Mobile</div>
                        <div class="od-value">
                            @if(!empty($address->mobile))
                                <a href="tel:{{ $address->mobile }}" class="od-phone"><i class="fas fa-phone-alt"></i>{{ $address->mobile }}</a>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="od-field">
                        <div class="od-label">Address</div>
                        <div class="od-value">{{ $address->address ?? 'N/A' }}</div>
                    </div>

                    <div class="od-field">
                        <div class="od-label">Country</div>
                        <div class="od-value">{{ $address->country ?? 'India' }}</div>
                    </div>
                @else
                    <div class="od-empty">No saved address found for this customer.</div>
                @endif
            </section>

            {{-- Payment --}}
            {{-- <section class="od-card">
                <h2 class="od-h od-serif"><i class="fas fa-credit-card"></i>Payment</h2>
                @if($order->payment)
                    <div class="od-field">
                        <div class="od-label">Status</div>
                        <div class="od-value">{{ $order->payment->status ?? 'N/A' }}</div>
                    </div>
                    <div class="od-field">
                        <div class="od-label">Method</div>
                        <div class="od-value">{{ $order->payment->payment_method ?? $order->payment->method ?? 'N/A' }}</div>
                    </div>
                    <div class="od-field">
                        <div class="od-label">Transaction ID</div>
                        <div class="od-value">{{ $order->payment->transaction_id ?? 'N/A' }}</div>
                    </div>
                @else
                    <div class="od-empty">No payment record found.</div>
                @endif
            </section> --}}
            
{{-- Payment --}}
<section class="od-card">
    <h2 class="od-h od-serif">
        <i class="fas fa-credit-card"></i>Payment Details
    </h2>

    @if($order->payment)
        @php
            $payment = $order->payment;
            $paymentStatus = $payment->status ?? 'Pending';

            $paymentBadge = match (strtolower($paymentStatus)) {
                'success' => 'st-success',
                'failed' => 'st-danger',
                'refunded' => 'st-secondary',
                default => 'st-warning',
            };

            $proofPath = $payment->proof_document ?? null;
        @endphp

        <div class="od-field">
            <div class="od-label">Payment Status</div>
            <div class="od-value">
                <span class="od-pill {{ $paymentBadge }}">
                    {{ $paymentStatus }}
                </span>
            </div>
        </div>

        <div class="od-field">
            <div class="od-label">Payment Method</div>
            <div class="od-value">
                {{ strtoupper($payment->method ?? $payment->payment_method ?? 'N/A') }}
            </div>
        </div>

        <div class="od-field">
            <div class="od-label">Amount</div>
            <div class="od-value">
                ₹{{ number_format((float) ($payment->amount ?? $order->total ?? 0), 2) }}
            </div>
        </div>

        <div class="od-field">
            <div class="od-label">Transaction ID</div>
            <div class="od-value">
                {{ $payment->transaction_id ?? 'Not available' }}
            </div>
        </div>

        {{-- User uploaded payment screenshot --}}
        @if(($payment->method ?? '') === 'online' && $proofPath)
            <div class="od-field">
                <div class="od-label">User Payment Screenshot</div>

                @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($proofPath))
                    <a href="{{ asset('storage/' . $proofPath) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       title="View full payment screenshot">

                        <img
                            src="{{ asset('storage/' . $proofPath) }}"
                            alt="User uploaded payment screenshot"
                            loading="lazy"
                            style="display:block;width:100%;max-width:280px;max-height:350px;object-fit:contain;margin:12px 0;padding:8px;background:#fff;border:1px solid var(--line);border-radius:12px;"
                        >
                    </a>

                    <a href="{{ asset('storage/' . $proofPath) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="od-back"
                       style="margin:8px 0 12px;">
                        <i class="fas fa-up-right-from-square"></i>
                        View Full Screenshot
                    </a>
                @else
                    <div class="od-empty">
                        Screenshot path database mein hai, lekin file public storage mein nahi mili.
                        <br>
                        <small>{{ $proofPath }}</small>
                    </div>
                @endif
            </div>
        @elseif(($payment->method ?? '') === 'online')
            <div class="od-empty" style="margin-top:12px;">
                User ne payment screenshot upload nahi kiya hai.
            </div>
        @endif

        {{-- Update payment status --}}
        <form action="{{ route('orders.payment.update', $order->id) }}"
              method="POST"
              style="margin-top:18px;">
            @csrf
            @method('PATCH')

            <label for="payment_status" class="od-label"
                   style="display:block;margin-bottom:8px;">
                Update Payment Status
            </label>

            <select name="payment_status"
                    id="payment_status"
                    required
                    class="form-select"
                    style="width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;margin-bottom:12px;">
                @foreach(['Pending', 'Success', 'Failed', 'Refunded'] as $option)
                    <option value="{{ $option }}"
                        {{ strcasecmp($paymentStatus, $option) === 0 ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="btn"
                    style="width:100%;background:var(--ink);color:#fff;border:1px solid var(--rose);border-radius:10px;padding:11px 16px;">
                <i class="fas fa-save"></i> Update Payment Status
            </button>
        </form>
    @else
        <div class="od-empty">No payment record found.</div>
    @endif
</section>

        </div>
    </div>

</div>
@endsection