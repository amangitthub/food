@extends('layouts.dash-layout')

@section('title', 'Orders')

@section('content')
@php
    $statusLabels = [
        'pending' => 'Pending', 'packed' => 'Packed', 'picked' => 'Picked',
        'shipped' => 'Shipped', 'out_for_delivery' => 'Out for Delivery',
        'complete' => 'Completed', 'cancelled' => 'Cancelled',
        'return_requested' => 'Return Requested', 'returned' => 'Returned',
        'failed' => 'Failed',
    ];

    $statusColors = [
        'pending' => 'warning', 'packed' => 'info', 'picked' => 'info',
        'shipped' => 'primary', 'out_for_delivery' => 'primary',
        'complete' => 'success', 'cancelled' => 'danger',
        'return_requested' => 'warning', 'returned' => 'secondary',
        'failed' => 'danger',
    ];

    // Must match the enum values of payments.status
    $paymentStatuses = $paymentStatuses ?? ['Pending', 'Success', 'Failed', 'Refunded'];

    $paymentColors = [
        'pending' => 'warning', 'paid' => 'success', 'success' => 'success',
        'failed' => 'danger', 'cancelled' => 'danger', 'refunded' => 'secondary',
    ];
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500&display=swap');

.ol .fas,.ol .far{font-family:"Font Awesome 6 Free" !important; font-style:normal}
.ol .fas{font-weight:900 !important}
.ol .far{font-weight:400 !important}

/* ---------- Theme (change colours here) ---------- */
.ol{
    --ink:#151515; --rose:#D9A5A0; --rose-deep:#B9807A; --page:#FBF7F6;
    --card:#ffffff; --line:#F0E5E2; --muted:#8C807D; --soft:#FDF9F8;
    font-family:'Jost',system-ui,sans-serif; font-weight:300; font-size:14px;
    color:var(--ink); line-height:1.55; max-width:1300px; margin:0 auto;
}
.ol *{box-sizing:border-box}
.ol-serif{font-family:'Cormorant Garamond',Georgia,serif}
.ol a:focus-visible,.ol button:focus-visible,.ol input:focus-visible,.ol select:focus-visible,.ol summary:focus-visible{outline:2px solid var(--rose-deep); outline-offset:2px}

/* ---------- Header ---------- */
.ol-top{display:flex; flex-wrap:wrap; gap:14px; justify-content:space-between; align-items:flex-end; margin-bottom:22px}
.ol-title{font-size:clamp(32px,5vw,46px); line-height:1.02; margin:0; font-weight:600}
.ol-sub{color:var(--muted); margin-top:6px}
.ol-live{display:flex; align-items:center; gap:10px; flex-wrap:wrap; background:var(--card); border:1px solid var(--line); border-radius:999px; padding:6px 8px 6px 6px}
.ol-live-badge{display:inline-flex; align-items:center; gap:7px; padding:5px 13px; border-radius:999px; background:#D6EEDF; color:#0F5132; font-size:12px; font-weight:500}
.ol-live-badge i{width:7px; height:7px; border-radius:50%; background:#198754; animation:ol-pulse 1.6s infinite}
@keyframes ol-pulse{0%{box-shadow:0 0 0 0 rgba(25,135,84,.5)}100%{box-shadow:0 0 0 8px rgba(25,135,84,0)}}
@media(prefers-reduced-motion:reduce){.ol-live-badge i{animation:none}}
.ol-updated{color:var(--muted); font-size:12px; padding-right:8px}

/* ---------- Alerts ---------- */
.ol-alert{padding:12px 16px; border-radius:12px; margin-bottom:16px; font-size:13px; display:flex; gap:10px; align-items:flex-start}
.ol-alert.ok{background:#D6EEDF; color:#0F5132}
.ol-alert.bad{background:#F9DADD; color:#842029}
.ol-alert ul{margin:0; padding-left:18px}

/* ---------- Stats ---------- */
.ol-stats{display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:14px; margin-bottom:26px}
.ol-stat{background:var(--card); border:1px solid var(--line); border-radius:16px; padding:16px 18px; display:flex; align-items:center; gap:14px}
.ol-stat-ico{width:44px; height:44px; flex:none; border-radius:50%; background:var(--soft); border:1px solid var(--line); color:var(--rose-deep); display:flex; align-items:center; justify-content:center; font-size:15px}
.ol-stat small{color:var(--muted); font-size:12px; display:block}
.ol-stat-n{font-size:34px; line-height:1; font-weight:600}
.ol-stat.dark{background:var(--ink); border-color:var(--ink); color:#fff}
.ol-stat.dark small{color:#c9c0be}
.ol-stat.dark .ol-stat-n{color:var(--rose)}
.ol-stat.dark .ol-stat-ico{background:rgba(217,165,160,.14); border-color:rgba(217,165,160,.3); color:var(--rose)}

/* ---------- Search bar ---------- */
.ol-bar{display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; align-items:center; margin-bottom:16px}
.ol-bar h2{margin:0; font-size:26px; font-weight:600}
.ol-search{display:flex; gap:8px; flex-wrap:wrap; flex:1 1 320px; justify-content:flex-end}
.ol-search-field{position:relative; flex:1 1 220px; max-width:360px}
.ol-search-field i{position:absolute; left:13px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:12px}
.ol-search-field .ol-input{padding-left:34px; width:100%}
.ol-input,.ol-select{
    font:inherit; font-weight:400; font-size:13px; color:var(--ink); background:var(--card);
    border:1px solid var(--line); border-radius:10px; padding:9px 12px; min-width:0;
}
.ol-input:focus,.ol-select:focus{border-color:var(--rose); outline:none; box-shadow:0 0 0 3px rgba(217,165,160,.2)}
.ol-btn{
    font:inherit; font-weight:400; font-size:13px; cursor:pointer; text-decoration:none; text-align:center;
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    padding:9px 16px; border-radius:10px; border:1px solid var(--ink); background:var(--ink); color:#fff;
    transition:background .2s, border-color .2s;
}
.ol-btn:hover{background:#2b2b2b; color:#fff}
.ol-btn.rose{background:var(--rose-deep); border-color:var(--rose-deep)}
.ol-btn.rose:hover{background:#a56d67}
.ol-btn.ghost{background:var(--card); color:var(--ink); border-color:var(--line)}
.ol-btn.ghost:hover{border-color:var(--rose); background:var(--soft); color:var(--ink)}
.ol-btn.sm{padding:6px 12px; font-size:12px}

/* ---------- Order cards ---------- */
.ol-list{display:grid; gap:14px}
.ol-order{
    --accent:#A39E9B;
    background:var(--card); border:1px solid var(--line); border-left:4px solid var(--accent);
    border-radius:16px; padding:clamp(14px,3vw,20px);
}
.tone-warning{--accent:#E8B93A}
.tone-info{--accent:#3BA7C4}
.tone-primary{--accent:#4C7DF0}
.tone-success{--accent:#3FA66B}
.tone-danger{--accent:#D9534F}
.tone-secondary{--accent:#A39E9B}

.ol-order-head{display:flex; flex-wrap:wrap; gap:10px 16px; justify-content:space-between; align-items:center}
.ol-no{font-size:28px; line-height:1.05; font-weight:700; margin:0}
.ol-id{color:var(--muted); font-size:12px}
.ol-head-right{display:flex; flex-wrap:wrap; gap:8px; align-items:center}
.ol-pill{display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:500; white-space:nowrap}
.ol-pill::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor}
.st-warning{background:#FFF3CD; color:#7A5B00}
.st-info{background:#D5F1F8; color:#055160}
.st-primary{background:#DCE8FE; color:#1D4ED8}
.st-success{background:#D6EEDF; color:#0F5132}
.st-danger{background:#F9DADD; color:#842029}
.st-secondary{background:#E7E5E4; color:#41464B}

.ol-meta{display:grid; grid-template-columns:repeat(auto-fit,minmax(210px,1fr)); gap:16px; margin-top:16px; padding-top:16px; border-top:1px dashed var(--line)}
.ol-cell{display:flex; gap:12px; align-items:center; min-width:0}
.ol-avatar{width:40px; height:40px; flex:none; border-radius:50%; background:var(--ink); color:var(--rose); display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:600}
.ol-clock{width:40px; height:40px; flex:none; border-radius:50%; background:var(--soft); border:1px solid var(--line); color:var(--rose-deep); display:flex; align-items:center; justify-content:center; font-size:14px}
.ol-label{color:var(--muted); font-size:12px; line-height:1.3}
.ol-value{font-weight:500; overflow-wrap:anywhere}
.ol-time{font-weight:500; font-size:14px; line-height:1.35}
.ol-ago{color:var(--rose-deep); font-size:12px; font-weight:400}
.ol-amount{font-size:30px; font-weight:700; line-height:1}

.ol-chips{display:flex; flex-wrap:wrap; gap:8px; margin-top:14px}
.ol-chip{background:var(--soft); border:1px solid var(--line); border-radius:999px; padding:4px 12px; font-size:12.5px; font-weight:400}
.ol-chip.none{color:var(--muted)}

/* ---------- Manage (collapsible) ---------- */
.ol-manage{margin-top:14px; border-top:1px dashed var(--line); padding-top:12px}
.ol-manage summary{
    list-style:none; cursor:pointer; display:flex; align-items:center; justify-content:space-between; gap:10px;
    font-weight:500; font-size:13px; padding:6px 2px; user-select:none;
}
.ol-manage summary::-webkit-details-marker{display:none}
.ol-manage summary .ol-sum-l{display:flex; align-items:center; gap:8px}
.ol-manage summary .ol-sum-l i{color:var(--rose-deep)}
.ol-manage summary .ol-caret{transition:transform .2s; color:var(--muted); font-size:12px}
.ol-manage[open] summary .ol-caret{transform:rotate(180deg)}
@media(prefers-reduced-motion:reduce){.ol-manage summary .ol-caret{transition:none}}
.ol-forms{display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:14px; margin-top:10px}
.ol-form{background:var(--soft); border:1px solid var(--line); border-radius:12px; padding:14px; display:grid; gap:8px; align-content:start}
.ol-form-title{font-weight:500; font-size:13px; display:flex; align-items:center; gap:8px}
.ol-form-title i{color:var(--rose-deep); font-size:12px}
.ol-form .ol-input,.ol-form .ol-select{width:100%}

.ol-empty{background:var(--card); border:1px dashed var(--line); border-radius:16px; padding:48px 16px; text-align:center; color:var(--muted)}
.ol-empty i{font-size:28px; color:var(--rose); display:block; margin-bottom:10px}
.ol-pager{margin-top:22px}

@media(max-width:575px){
    .ol-search{justify-content:stretch}
    .ol-search-field{max-width:none}
    .ol-head-right{width:100%}
    .ol-no{font-size:26px}
}
</style>

<div class="ol">

    {{-- Header --}}
    <div class="ol-top">
        <div>
            <h1 class="ol-title ol-serif">Orders</h1>
            <div class="ol-sub">Track and manage all food orders</div>
        </div>
        <div class="ol-live">
            <span class="ol-live-badge"><i></i>Live updates</span>
            <small class="ol-updated" id="lastUpdated">Refreshing every 5 seconds</small>
        </div>
    </div>

    @if(session('success'))
        <div class="ol-alert ok"><i class="fas fa-circle-check" style="margin-top:3px"></i><div>{{ session('success') }}</div></div>
    @endif

    @if($errors->any())
        <div class="ol-alert bad">
            <i class="fas fa-circle-exclamation" style="margin-top:3px"></i>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Stats --}}
    <div class="ol-stats" id="order-stats">
        <div class="ol-stat">
            <div class="ol-stat-ico"><i class="fas fa-receipt"></i></div>
            <div><small>Total orders</small><div class="ol-stat-n ol-serif">{{ $stats['total'] }}</div></div>
        </div>
        <div class="ol-stat">
            <div class="ol-stat-ico"><i class="fas fa-hourglass-half"></i></div>
            <div><small>Pending</small><div class="ol-stat-n ol-serif">{{ $stats['pending'] }}</div></div>
        </div>
        <div class="ol-stat">
            <div class="ol-stat-ico"><i class="fas fa-box-open"></i></div>
            <div><small>Packed / Picked</small><div class="ol-stat-n ol-serif">{{ $stats['preparing'] }}</div></div>
        </div>
        <div class="ol-stat dark">
            <div class="ol-stat-ico"><i class="fas fa-circle-check"></i></div>
            <div><small>Completed</small><div class="ol-stat-n ol-serif">{{ $stats['delivered'] }}</div></div>
        </div>
    </div>

    {{-- Search --}}
    <div class="ol-bar">
        <h2 class="ol-serif">All orders</h2>
        <form method="GET" action="{{ route('orders.index') }}" class="ol-search">
            <div class="ol-search-field">
                <i class="fas fa-magnifying-glass"></i>
                <input type="search" name="search" value="{{ request('search') }}" class="ol-input"
                    placeholder="Search order number or ID" aria-label="Search orders">
            </div>
            <button class="ol-btn" type="submit">Search</button>
            @if(request('search'))
                <a href="{{ route('orders.index') }}" class="ol-btn ghost">Clear</a>
            @endif
        </form>
    </div>

    {{-- Orders --}}
    <div class="ol-list" id="orders-table-body">
        @forelse($orders as $order)
            @php
                $currentStatus = $order->current_status ?? 'pending';
                $tone = $statusColors[$currentStatus] ?? 'secondary';
                $payStatus = strtolower((string) ($order->payment_status ?? $order->payment->status ?? 'Pending'));
                $payOptions = $paymentStatuses;
                $chips = array_filter(array_map('trim', explode(', ', (string) $order->items_summary)));
                $initial = mb_strtoupper(mb_substr((string) $order->customer_name, 0, 1)) ?: '?';
            @endphp

            <article class="ol-order tone-{{ $tone }}">

                <div class="ol-order-head">
                    <div>
                        <h3 class="ol-no ol-serif">{{ $order->order_no }}</h3>
                        <div class="ol-id">ID: {{ $order->id }}</div>
                    </div>
                    <div class="ol-head-right">
                        <span class="ol-pill st-{{ $tone }}" title="Order status">
                            {{ $statusLabels[$currentStatus] ?? ucfirst($currentStatus) }}
                        </span>
                        <span class="ol-pill st-{{ $paymentColors[$payStatus] ?? 'secondary' }}" title="Payment status">
                            Payment: {{ ucfirst($payStatus) }}
                        </span>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="ol-btn ghost sm">
                            <i class="fas fa-eye"></i> View details
                        </a>
                    </div>
                </div>

                <div class="ol-meta">
                    <div class="ol-cell">
                        <div class="ol-avatar ol-serif">{{ $initial }}</div>
                        <div>
                            <div class="ol-label">Customer</div>
                            <div class="ol-value">{{ $order->customer_name }}</div>
                        </div>
                    </div>

                    <div class="ol-cell">
                        <div class="ol-clock"><i class="far fa-clock"></i></div>
                        <div>
                            <div class="ol-label">Order placed</div>
                            <div class="ol-time">
                                {{ $order->created_at?->format('d M Y') }},
                                {{ $order->created_at?->format('h:i:s A') }}
                            </div>
                            <div class="ol-ago">{{ $order->created_at?->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="ol-cell">
                        <div>
                            <div class="ol-label">Amount</div>
                            <div class="ol-amount ol-serif">₹{{ number_format((float) $order->total, 2) }}</div>
                        </div>
                    </div>
                </div>

                <div class="ol-chips">
                    @forelse($chips as $chip)
                        <span class="ol-chip">{{ $chip }}</span>
                    @empty
                        <span class="ol-chip none">No items</span>
                    @endforelse
                </div>

                <details class="ol-manage">
                    <summary>
                        <span class="ol-sum-l"><i class="fas fa-sliders"></i>Manage order and payment</span>
                        <i class="fas fa-chevron-down ol-caret"></i>
                    </summary>

                    <div class="ol-forms">
                        {{-- Order status --}}
                        <form method="POST" action="{{ route('orders.status.update', $order->id) }}" class="ol-form">
                            @csrf
                            @method('PATCH')
                            <div class="ol-form-title"><i class="fas fa-truck"></i>Update order status</div>

                            <select name="status" class="ol-select" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" @selected($currentStatus === $status)>
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="text" name="description" class="ol-input"
                                placeholder="Tracking note (optional)" maxlength="2000">

                            <button type="submit" class="ol-btn">Update status</button>
                        </form>

                        {{-- Payment status --}}
                        <form method="POST" action="{{ route('orders.payment.update', $order->id) }}" class="ol-form">
                            @csrf
                            @method('PATCH')
                            <div class="ol-form-title"><i class="fas fa-credit-card"></i>Update payment status</div>

                            <select name="payment_status" class="ol-select" required>
                                @foreach($payOptions as $option)
                                    <option value="{{ $option }}" @selected($payStatus === strtolower($option))>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="ol-btn rose">Update payment</button>
                        </form>
                    </div>
                </details>
            </article>
        @empty
            <div class="ol-empty"><i class="fas fa-bag-shopping"></i>No orders found.</div>
        @endforelse
    </div>

    <div class="ol-pager" id="orders-pagination">
        {{ $orders->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let refreshing = false;

    async function refreshOrders() {
        if (refreshing || document.hidden) {
            return;
        }

        // Do not replace the list while the admin is editing or has a Manage panel open.
        const activeElement = document.activeElement;

        if (activeElement && activeElement.closest('#orders-table-body form')) {
            return;
        }

        if (document.querySelector('#orders-table-body details[open]')) {
            return;
        }

        refreshing = true;

        try {
            const response = await fetch(window.location.href, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                },
                cache: 'no-store'
            });

            if (!response.ok) {
                return;
            }

            const html = await response.text();
            const newDocument = new DOMParser().parseFromString(html, 'text/html');

            ['orders-table-body', 'order-stats', 'orders-pagination'].forEach(function (id) {
                const current = document.getElementById(id);
                const fresh = newDocument.getElementById(id);

                if (current && fresh) {
                    current.innerHTML = fresh.innerHTML;
                }
            });

            const lastUpdated = document.getElementById('lastUpdated');

            if (lastUpdated) {
                lastUpdated.textContent = 'Updated at ' + new Date().toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }
        } catch (error) {
            console.error('Orders auto-refresh failed:', error);
        } finally {
            refreshing = false;
        }
    }

    // Refresh admin orders every 5 seconds.
    setInterval(refreshOrders, 5000);
});
</script>
@endsection