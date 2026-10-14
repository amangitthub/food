@extends('layouts.site-layout')

@section('title', 'Order Details | Food Website')

@section('content')
@php
    $payment = $order->payment;
    $paymentStatus = $payment->status ?? 'Pending';
    $paymentMethod = $payment->method ?? 'cash';

    // Payment badge (values come from payments.status enum)
    $payRaw = strtolower((string) $paymentStatus);
    $payLabel = [
        'success' => 'Paid', 'paid' => 'Paid', 'pending' => 'Pending',
        'failed' => 'Failed', 'refunded' => 'Refunded',
    ][$payRaw] ?? ucfirst($payRaw);
    $payTone = [
        'success' => 'ok', 'paid' => 'ok', 'pending' => 'wait',
        'failed' => 'bad', 'refunded' => 'gray',
    ][$payRaw] ?? 'gray';

    // Order status
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

    $statusTones = [
        'pending' => 'wait', 'packed' => 'info', 'picked' => 'info',
        'shipped' => 'blue', 'out_for_delivery' => 'blue',
        'complete' => 'ok', 'cancelled' => 'bad',
        'return_requested' => 'wait', 'returned' => 'gray', 'failed' => 'bad',
    ];

    $currentStatusLabel = $statusLabels[$currentStatus]
        ?? ucwords(str_replace('_', ' ', $currentStatus));
    $currentTone = $statusTones[$currentStatus] ?? 'gray';

    // Progress tracker (normal delivery flow only)
    $flow = ['pending', 'packed', 'picked', 'shipped', 'out_for_delivery', 'complete'];
    $flowIndex = array_search($currentStatus, $flow, true);
    $onFlow = $flowIndex !== false;

    // Latest update first
    $history = $statusHistory->reverse()->values();
@endphp

<style>
    /* Uses your website variables (--theme, --theme3, --bg ...) with safe fallbacks */
    .ods {
        --g: var(--theme, #00813d);
        --y: var(--theme3, #ffb936);
        --r: var(--theme2, #d12525);
        --dark: var(--header, #212121);
        --txt: var(--text, #5c5c5b);
        --ln: var(--border, #d9d9d9);
        --cream: var(--bg, #f4f1ea);
        padding: 60px 15px 70px;
        background: var(--cream);
        min-height: 70vh;
    }
    .ods *, .ods *::before, .ods *::after { box-sizing: border-box; }
    .ods-wrap { max-width: 1100px; margin: 0 auto; }

    /* ---------- Header ---------- */
    .ods-head {
        display: flex; flex-wrap: wrap; gap: 18px; justify-content: space-between; align-items: flex-end;
        margin-bottom: 22px;
    }
    .ods-eyebrow { color: var(--g); font-size: 13px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px; }
    .ods-head h1 { margin: 0 0 8px; color: var(--dark); font-size: clamp(28px, 5vw, 38px); font-weight: 800; line-height: 1.15; }
    .ods-sub { margin: 0; color: var(--txt); overflow-wrap: anywhere; }
    .ods-actions { display: flex; flex-wrap: wrap; gap: 10px; }

    .ods-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; line-height: 1.2;
        text-decoration: none !important; border: 2px solid var(--g);
        background: var(--g); color: #fff !important; transition: background .2s, color .2s, border-color .2s;
    }
    .ods-btn:hover { background: var(--dark); border-color: var(--dark); color: #fff !important; }
    .ods-btn.ghost { background: #fff; color: var(--dark) !important; border-color: var(--ln); }
    .ods-btn.ghost:hover { background: #fff; border-color: var(--g); color: var(--g) !important; }

    /* ---------- Status pill ---------- */
    .ods-pill {
        display: inline-flex; align-items: center; gap: 7px; padding: 6px 14px; border-radius: 999px;
        font-size: 12.5px; font-weight: 700; white-space: nowrap;
    }
    .ods-pill::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .tone-ok   { background: #dff3e8; color: #00642f; }
    .tone-wait { background: #fff0cc; color: #8a5a00; }
    .tone-info { background: #d9f1f6; color: #0b5566; }
    .tone-blue { background: #dde8fd; color: #1d4ed8; }
    .tone-bad  { background: #f9dada; color: #b01c1c; }
    .tone-gray { background: #ececec; color: #444; }

    /* ---------- Cards ---------- */
    .ods-card {
        background: #fff; border: 1px solid #ebe6da; border-radius: 16px;
        padding: 26px; margin-bottom: 22px; min-width: 0;
        box-shadow: 0 6px 24px rgba(33, 33, 33, .04);
    }
    .ods-card h3 {
        display: flex; align-items: center; gap: 10px;
        margin: 0 0 20px; color: var(--dark); font-size: 19px; font-weight: 800;
    }
    .ods-card h3 i {
        width: 32px; height: 32px; border-radius: 50%; background: #e8f4ed; color: var(--g);
        display: inline-flex; align-items: center; justify-content: center; font-size: 13px;
    }

    /* ---------- Progress ---------- */
    .ods-track { overflow-x: auto; padding-bottom: 4px; }
    .ods-steps { display: flex; min-width: 560px; list-style: none; margin: 0; padding: 0; }
    .ods-step { flex: 1; text-align: center; position: relative; color: #9a9a96; font-size: 12.5px; font-weight: 600; }
    .ods-step::before { content: ""; position: absolute; top: 13px; left: -50%; width: 100%; height: 3px; background: #e6e2d8; }
    .ods-step:first-child::before { display: none; }
    .ods-dot {
        width: 28px; height: 28px; border-radius: 50%; margin: 0 auto 9px; position: relative; z-index: 1;
        background: #fff; border: 3px solid #e6e2d8; color: #fff; font-size: 11px;
        display: flex; align-items: center; justify-content: center;
    }
    .ods-step.done { color: var(--dark); }
    .ods-step.done::before { background: var(--g); }
    .ods-step.done .ods-dot { background: var(--g); border-color: var(--g); }
    .ods-step.now { color: var(--g); }
    .ods-step.now::before { background: var(--g); }
    .ods-step.now .ods-dot { background: var(--y); border-color: var(--y); box-shadow: 0 0 0 5px rgba(255, 185, 54, .3); }
    .ods-alert { padding: 14px 16px; border-radius: 12px; font-size: 14px; font-weight: 600; }

    /* ---------- Layout ---------- */
    .ods-grid { display: grid; grid-template-columns: minmax(0, 1.6fr) minmax(280px, 1fr); gap: 22px; align-items: start; }
    .ods-col { min-width: 0; }

    /* ---------- Products ---------- */
    .ods-item { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; padding: 16px 0; border-bottom: 1px dashed var(--ln); }
    .ods-item:first-of-type { padding-top: 0; }
    .ods-item:last-child { border-bottom: 0; padding-bottom: 0; }
    .ods-item h4 { margin: 0 0 6px; color: var(--dark); font-size: 15.5px; font-weight: 700; line-height: 1.4; overflow-wrap: anywhere; }
    .ods-item p { margin: 0; color: var(--txt); font-size: 13.5px; }
    .ods-qty { display: inline-block; background: var(--cream); border-radius: 6px; padding: 1px 9px; font-weight: 700; color: var(--dark); margin-left: 4px; }
    .ods-amt { color: var(--dark); font-size: 16px; font-weight: 800; white-space: nowrap; }

    /* ---------- Summary ---------- */
    .ods-line { display: flex; justify-content: space-between; gap: 14px; padding: 8px 0; color: var(--txt); font-size: 14.5px; }
    .ods-line strong { color: var(--dark); font-weight: 700; text-align: right; }
    .ods-line .minus { color: var(--r); }
    .ods-total {
        display: flex; justify-content: space-between; align-items: center; gap: 14px;
        margin-top: 12px; padding: 16px 18px; border-radius: 12px;
        background: var(--g); color: #fff; border-bottom: 4px solid var(--y);
    }
    .ods-total span { font-size: 15px; font-weight: 700; }
    .ods-total strong { font-size: 26px; font-weight: 800; color: #fff; }

    /* ---------- Timeline ---------- */
    .ods-tl { position: relative; padding: 0 0 24px 28px; border-left: 3px solid #e6e2d8; margin-left: 7px; }
    .ods-tl:last-child { padding-bottom: 0; border-left-color: transparent; }
    .ods-tl::before {
        content: ""; position: absolute; left: -10px; top: 1px; width: 17px; height: 17px; border-radius: 50%;
        background: #fff; border: 3px solid #cfcabd;
    }
    .ods-tl.latest::before { background: var(--g); border-color: var(--g); box-shadow: 0 0 0 5px rgba(0, 129, 61, .16); }
    .ods-tl strong { display: block; color: var(--dark); font-size: 15px; margin-bottom: 4px; text-transform: capitalize; }
    .ods-tl p { margin: 0 0 2px; color: var(--txt); font-size: 13.5px; line-height: 1.7; }
    .ods-tl small { display: block; color: #9a9a96; margin-top: 5px; font-size: 12.5px; }

    /* ---------- Right column ---------- */
    .ods-name { color: var(--dark); font-size: 17px; font-weight: 800; margin-bottom: 10px; }
    .ods-addr { color: var(--txt); font-size: 14.5px; line-height: 1.85; overflow-wrap: anywhere; }
    .ods-addr .ph { color: var(--dark); font-weight: 700; margin-bottom: 4px; }
    .ods-addr .ph i { color: var(--g); margin-right: 6px; }
    .ods-method { display: inline-block; background: #fff0cc; color: #8a5a00; border-radius: 8px; padding: 7px 12px; font-size: 12.5px; font-weight: 800; margin-bottom: 14px; }
    .ods-row { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 9px 0; font-size: 14px; color: var(--txt); border-bottom: 1px dashed var(--ln); }
    .ods-row:last-child { border-bottom: 0; }
    .ods-row strong { color: var(--dark); text-align: right; overflow-wrap: anywhere; }
    .ods-empty { margin: 0; color: var(--txt); font-size: 14px; line-height: 1.7; }

    @media (max-width: 767px) {
        .ods { padding: 35px 12px 50px; }
        .ods-grid { grid-template-columns: 1fr; }
        .ods-card { padding: 20px 16px; }
        .ods-actions { width: 100%; }
        .ods-actions .ods-btn { flex: 1 1 100%; }
        .ods-total strong { font-size: 22px; }
    }
</style>

<section class="ods">
    <div class="ods-wrap">

        {{-- ================= HEADER ================= --}}
        <div class="ods-head">
            <div>
                <div class="ods-eyebrow">Your order</div>
                <h1>Order Details</h1>
                <p class="ods-sub">
                    Order #{{ $order->order_no }}
                    &nbsp;·&nbsp;
                    {{ $order->created_at
                        ? \Illuminate\Support\Carbon::parse($order->created_at)->format('d M Y, h:i A')
                        : 'Date unavailable' }}
                </p>
                <div style="margin-top:14px">
                    <span class="ods-pill tone-{{ $currentTone }}">{{ $currentStatusLabel }}</span>
                </div>
            </div>

            <div class="ods-actions">
                <a href="{{ route('orders.receipt.download', $order->order_no) }}" class="ods-btn">
                    <i class="fas fa-file-pdf"></i> Download Receipt PDF
                </a>
                <a href="{{ route('orders.my') }}" class="ods-btn ghost">
                    &larr; Back to My Orders
                </a>
            </div>
        </div>

        {{-- ================= PROGRESS ================= --}}
        <div class="ods-card">
            <h3><i class="fas fa-route"></i>Order Progress</h3>

            @if ($onFlow)
                <div class="ods-track">
                    <ol class="ods-steps">
                        @foreach ($flow as $i => $step)
                            <li class="ods-step {{ $i < $flowIndex ? 'done' : '' }} {{ $i === $flowIndex ? 'now' : '' }}">
                                <div class="ods-dot">
                                    @if ($i < $flowIndex)<i class="fas fa-check"></i>@endif
                                </div>
                                {{ $statusLabels[$step] }}
                            </li>
                        @endforeach
                    </ol>
                </div>
            @else
                <div class="ods-alert tone-{{ $currentTone }}">
                    This order is {{ $currentStatusLabel }}.
                </div>
            @endif
        </div>

        <div class="ods-grid">

            {{-- ================= LEFT COLUMN ================= --}}
            <div class="ods-col">

                {{-- PRODUCTS --}}
                <div class="ods-card">
                    <h3><i class="fas fa-shopping-bag"></i>Products in Your Order</h3>

                    @forelse ($order->items as $item)
                        <div class="ods-item">
                            <div>
                                <h4>{{ $item->product_name }}</h4>
                                <p>
                                    ₹{{ number_format((float) $item->price, 2) }} each
                                    <span class="ods-qty">× {{ $item->quantity }}</span>
                                </p>
                            </div>
                            <div class="ods-amt">₹{{ number_format((float) $item->subtotal, 2) }}</div>
                        </div>
                    @empty
                        <p class="ods-empty">No product details are available for this order.</p>
                    @endforelse
                </div>

                {{-- PRICE SUMMARY --}}
                <div class="ods-card">
                    <h3><i class="fas fa-receipt"></i>Price Summary</h3>

                    <div class="ods-line">
                        <span>Subtotal</span>
                        <strong>₹{{ number_format((float) $order->subtotal, 2) }}</strong>
                    </div>

                    @if ((float) $order->discount > 0)
                        <div class="ods-line">
                            <span>Discount</span>
                            <strong class="minus">- ₹{{ number_format((float) $order->discount, 2) }}</strong>
                        </div>
                    @endif

                    @if ((float) $order->shipping > 0)
                        <div class="ods-line">
                            <span>Shipping</span>
                            <strong>₹{{ number_format((float) $order->shipping, 2) }}</strong>
                        </div>
                    @endif

                    @if ((float) $order->cgst > 0)
                        <div class="ods-line">
                            <span>CGST</span>
                            <strong>₹{{ number_format((float) $order->cgst, 2) }}</strong>
                        </div>
                    @endif

                    @if ((float) $order->sgst > 0)
                        <div class="ods-line">
                            <span>SGST</span>
                            <strong>₹{{ number_format((float) $order->sgst, 2) }}</strong>
                        </div>
                    @endif

                    @if ((float) $order->igst > 0)
                        <div class="ods-line">
                            <span>IGST</span>
                            <strong>₹{{ number_format((float) $order->igst, 2) }}</strong>
                        </div>
                    @endif

                    <div class="ods-total">
                        <span>Total Amount</span>
                        <strong>₹{{ number_format((float) $order->total, 2) }}</strong>
                    </div>
                </div>

                {{-- ORDER UPDATES --}}
                <div class="ods-card">
                    <h3><i class="fas fa-history"></i>Order Updates</h3>

                    @forelse ($history as $row)
                        <div class="ods-tl {{ $loop->first ? 'latest' : '' }}">
                            <strong>
                                {{ $row->title ?: ($statusLabels[$row->status] ?? ucwords(str_replace('_', ' ', $row->status))) }}
                            </strong>

                            @if ($row->description)
                                <p>{{ $row->description }}</p>
                            @endif

                            @if ($row->location)
                                <p>Location: {{ $row->location }}</p>
                            @endif

                            <small>{{ \Illuminate\Support\Carbon::parse($row->created_at)->format('d M Y, h:i A') }}</small>
                        </div>
                    @empty
                        <p class="ods-empty">
                            Your order has been placed. Further updates will appear here when available.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- ================= RIGHT COLUMN ================= --}}
            <div class="ods-col">

                {{-- DELIVERY ADDRESS --}}
                <div class="ods-card">
                    <h3><i class="fas fa-map-marker-alt"></i>Delivery Address</h3>

                    @if ($address)
                        <div class="ods-name">{{ $address->name }}</div>

                        <div class="ods-addr">
                            <div class="ph"><i class="fas fa-phone"></i>{{ $address->mobile }}</div>
                            <div>{{ $address->address }}</div>

                            @if ($address->city)<div>{{ $address->city }}</div>@endif
                            @if ($address->state)<div>{{ $address->state }}</div>@endif
                            @if ($address->pincode)<div>PIN: {{ $address->pincode }}</div>@endif
                            @if ($address->country)<div>{{ $address->country }}</div>@endif
                        </div>
                    @else
                        <p class="ods-empty">Delivery address is not available for this order.</p>
                    @endif
                </div>

                {{-- PAYMENT DETAILS --}}
                <div class="ods-card">
                    <h3><i class="fas fa-credit-card"></i>Payment Details</h3>

                    <div class="ods-method">{{ strtoupper(str_replace('_', ' ', $paymentMethod)) }}</div>

                    <div class="ods-row">
                        <span>Payment Status</span>
                        <strong><span class="ods-pill tone-{{ $payTone }}">{{ $payLabel }}</span></strong>
                    </div>

                    <div class="ods-row">
                        <span>Payment Amount</span>
                        <strong>₹{{ number_format((float) ($payment->amount ?? $order->total), 2) }}</strong>
                    </div>

                    @if ($payment && $payment->gateway)
                        <div class="ods-row">
                            <span>Payment Gateway</span>
                            <strong>{{ ucfirst($payment->gateway) }}</strong>
                        </div>
                    @endif

                    @if ($payment && $payment->gateway_payment_id)
                        <div class="ods-row">
                            <span>Payment ID</span>
                            <strong>{{ $payment->gateway_payment_id }}</strong>
                        </div>
                    @endif

                    <div class="ods-row">
                        <span>Order Number</span>
                        <strong>{{ $order->order_no }}</strong>
                    </div>
                </div>

                @if ($order->notes)
                    <div class="ods-card">
                        <h3><i class="fas fa-sticky-note"></i>Order Notes</h3>
                        <p class="ods-empty">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection