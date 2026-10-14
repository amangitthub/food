@extends('layouts.site-layout')

@section('title', 'My Orders | Food Website')

@section('content')
<style>
    .mo {
        --g: var(--theme, #00813d);
        --r: var(--theme2, #d12525);
        --dark: var(--header, #212121);
        --txt: var(--text, #5c5c5b);
        --ln: var(--border, #d9d9d9);
        --cream: var(--bg, #f4f1ea);
        padding: 60px 15px;
        background: var(--cream);
        min-height: 70vh
    }

    .mo * {
        box-sizing: border-box
    }

    .mo-wrap {
        max-width: 920px;
        margin: 0 auto
    }

    .mo h1 {
        margin: 0 0 6px;
        color: var(--dark);
        font-size: clamp(28px, 5vw, 36px);
        font-weight: 800
    }

    .mo-sub {
        margin: 0 0 28px;
        color: var(--txt)
    }

    .mo-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        margin-bottom: 18px;
        box-shadow: 0 8px 28px rgba(33, 33, 33, .06);
        transition: transform .2s, box-shadow .2s
    }

    .mo-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(33, 33, 33, .1)
    }

    .mo-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 12px 16px
    }

    .mo-head {
        gap: 14px
    }

    .mo-who {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0
    }

    .mo-ico {
        width: 46px;
        height: 46px;
        flex: none;
        border-radius: 14px;
        background: var(--g);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px
    }

    .mo-no {
        color: var(--dark);
        font-size: 17px;
        font-weight: 800;
        overflow-wrap: anywhere;
        line-height: 1.3
    }

    .mo-date {
        color: #8a8a86;
        font-size: 13px
    }

    .mo-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-radius: 99px;
        background: var(--cream);
        color: var(--dark);
        font-size: 13px;
        font-weight: 700
    }

    .mo-status::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--g)
    }

    .mo-status.bad {
        background: #fbeaea;
        color: var(--r)
    }

    .mo-status.bad::before {
        background: var(--r)
    }

    .mo-bar {
        height: 6px;
        border-radius: 99px;
        background: #ece8de;
        margin: 20px 0 4px;
        overflow: hidden
    }

    .mo-bar span {
        display: block;
        height: 100%;
        border-radius: 99px;
        background: var(--g)
    }

    .mo-barlabels {
        display: flex;
        justify-content: space-between;
        font-size: 11.5px;
        color: #9a9a96
    }

    .mo-items {
        margin: 16px 0 0;
        padding: 0;
        list-style: none
    }

    .mo-items li {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 9px 0;
        border-bottom: 1px dashed var(--ln);
        color: var(--dark);
        font-size: 14.5px;
        font-weight: 600
    }

    .mo-items li:last-child {
        border: 0
    }

    .mo-items small {
        color: #8a8a86;
        font-weight: 600;
        white-space: nowrap
    }

    .mo-more {
        color: #8a8a86;
        font-size: 13px;
        margin-top: 4px
    }

    .mo-foot {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #eee9de
    }

    .mo-tl {
        font-size: 12px;
        color: #8a8a86
    }

    .mo-total {
        color: var(--dark);
        font-size: 24px;
        font-weight: 800;
        line-height: 1.1
    }

    .mo-pay {
        color: var(--txt);
        font-size: 13px;
        margin-top: 3px
    }

    .mo-pay .ok {
        color: var(--g);
        font-weight: 700
    }

    .mo-pay .bad {
        color: var(--r);
        font-weight: 700
    }

    .mo-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--g);
        color: #fff !important;
        text-decoration: none !important;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        transition: .2s
    }

    .mo-btn:hover {
        background: var(--dark)
    }

    .mo-empty {
        background: #fff;
        border-radius: 18px;
        padding: 60px 20px;
        text-align: center;
        box-shadow: 0 8px 28px rgba(33, 33, 33, .06)
    }

    .mo-empty .mo-ico {
        margin: 0 auto 16px;
        width: 64px;
        height: 64px;
        font-size: 26px;
        border-radius: 50%
    }

    .mo-empty h3 {
        color: var(--dark);
        font-weight: 800
    }

    .mo-empty p {
        color: var(--txt)
    }

    @media(max-width:600px) {
        .mo {
            padding: 35px 12px
        }

        .mo-card {
            padding: 18px 16px
        }

        .mo-btn {
            width: 100%;
            justify-content: center
        }
    }
</style>

<section class="mo">
    <div class="mo-wrap">

        <h1>My Orders</h1>
        <p class="mo-sub">Track your orders and view your previous purchases.</p>

        @forelse ($orders as $order)
        @php
        $cur = $order->current_status ?? $order->status ?? 'pending';
        $label = match ($cur) {
        'complete' => 'Completed',
        'out_for_delivery' => 'Out for Delivery',
        'return_requested' => 'Return Requested',
        default => ucwords(str_replace('_', ' ', $cur)),
        };
        $bad = in_array($cur, ['cancelled', 'failed', 'returned'], true);

        $flow = ['pending', 'packed', 'picked', 'shipped', 'out_for_delivery', 'complete'];
        $idx = array_search($cur, $flow, true);
        $percent = $idx === false ? 0 : round((($idx + 1) / count($flow)) * 100);

        $payRaw = strtolower((string) ($order->payment->status ?? 'pending'));
        $payLabel = ['success' => 'Paid', 'paid' => 'Paid'][$payRaw] ?? ucfirst($payRaw);
        $payTone = ['success' => 'ok', 'paid' => 'ok', 'failed' => 'bad'][$payRaw] ?? '';

        $shown = $order->items->take(3);
        $extra = max($order->items->count() - 3, 0);
        @endphp

        <div class="mo-card">
            <div class="mo-row mo-head">
                <div class="mo-who">
                    <div class="mo-ico"><i class="fas fa-shopping-bag"></i></div>
                    <div>
                        <div class="mo-no">{{ $order->order_no }}</div>
                        <div class="mo-date">{{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : 'Date
                            unavailable' }}</div>
                    </div>
                </div>
                <span @class(['mo-status', 'bad'=> $bad])>{{ $label }}</span>
            </div>

            @if ($idx !== false)
            <div class="mo-bar"><span style="width:{{ $percent }}%"></span></div>
            <div class="mo-barlabels"><span>Placed</span><span>Delivered</span></div>
            @endif

            <ul class="mo-items">
                @forelse ($shown as $item)
                <li><span>{{ $item->product_name }}</span><small>× {{ $item->quantity }}</small></li>
                @empty
                <li><span>Order items unavailable</span></li>
                @endforelse
            </ul>
            @if ($extra > 0)
            <div class="mo-more">+ {{ $extra }} more item(s)</div>
            @endif

            <div class="mo-row mo-foot">
                <div>
                    <div class="mo-tl">TOTAL</div>
                    <div class="mo-total">₹{{ number_format((float) $order->total, 2) }}</div>
                    <div class="mo-pay">{{ ucfirst($order->payment->method ?? 'Cash') }} · <span
                            class="{{ $payTone }}">{{ $payLabel }}</span></div>
                </div>
                <a href="{{ route('orders.show', $order->order_no) }}" class="mo-btn">View Details &rarr;</a>
            </div>
        </div>
        @empty
        <div class="mo-empty">
            <div class="mo-ico"><i class="fas fa-shopping-bag"></i></div>
            <h3>No Orders Yet</h3>
            <p>Your placed orders will appear here.</p>
            <a href="{{ route('site.products') }}" class="mo-btn">Explore Menu</a>
        </div>
        @endforelse

        @if ($orders->hasPages())
        <div style="margin-top:25px">{{ $orders->links() }}</div>
        @endif

    </div>
</section>
@endsection