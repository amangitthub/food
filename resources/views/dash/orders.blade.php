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

$statusTones = [
'pending' => 'warn', 'packed' => 'info', 'picked' => 'info',
'shipped' => 'blue', 'out_for_delivery' => 'blue',
'complete' => 'ok', 'cancelled' => 'bad',
'return_requested' => 'warn', 'returned' => 'gray', 'failed' => 'bad',
];

// Must match the enum values of payments.status
$paymentStatuses = $paymentStatuses ?? ['Pending', 'Success', 'Failed', 'Refunded'];

$payTones = ['success' => 'ok', 'paid' => 'ok', 'pending' => 'warn', 'failed' => 'bad', 'refunded' => 'gray'];

$tabs = [
'' => 'All', 'pending' => 'Pending', 'progress' => 'In progress',
'complete' => 'Completed', 'cancelled' => 'Cancelled',
];
$activeTab = (string) request('status', '');
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .ol .fas,
    .ol .far {
        font-family: "Font Awesome 6 Free" !important;
        font-style: normal
    }

    .ol .fas {
        font-weight: 900 !important
    }

    .ol .far {
        font-weight: 400 !important
    }

    /* ---------- Theme (change the accent here) ---------- */
    .ol {
        --ink: #111827;
        --mute: #6B7280;
        --line: #E5E7EB;
        --bg: #F9FAFB;
        --card: #fff;
        --g: #00813D;
        --gs: #E6F4EC;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 14px;
        color: var(--ink);
        line-height: 1.5;
        max-width: 1400px;
        margin: 0 auto;
        
    }

    .ol * {
        box-sizing: border-box
    }

    .ol a:focus-visible,
    .ol button:focus-visible,
    .ol input:focus-visible,
    .ol select:focus-visible {
        outline: 2px solid var(--g);
        outline-offset: 2px
    }

    /* ---------- Header ---------- */
    .ol-top {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px
    }

    .ol-title {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -.3px
    }

    .ol-sub {
        color: var(--mute);
        margin-top: 2px
    }

    .ol-live {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--mute);
        font-size: 12.5px
    }

    .ol-live i {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--g);
        animation: ol-pulse 1.8s infinite
    }

    @keyframes ol-pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 129, 61, .45)
        }

        100% {
            box-shadow: 0 0 0 8px rgba(0, 129, 61, 0)
        }
    }

    @media(prefers-reduced-motion:reduce) {
        .ol-live i {
            animation: none
        }
    }

    /* ---------- Alerts ---------- */
    .ol-alert {
        display: flex;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 16px;
        font-size: 13.5px
    }

    .ol-alert.ok {
        background: #ECFDF3;
        color: #05603A;
        border: 1px solid #ABEFC6
    }

    .ol-alert.bad {
        background: #FEF3F2;
        color: #B42318;
        border: 1px solid #FECDCA
    }

    .ol-alert ul {
        margin: 0;
        padding-left: 18px
    }

    /* ---------- Stats ---------- */
    .ol-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 14px;
        margin-bottom: 20px
    }

    .ol-stat {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 16px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px
    }

    .ol-stat small {
        display: block;
        color: var(--mute);
        font-size: 12.5px;
        font-weight: 500
    }

    .ol-stat b {
        font-size: 28px;
        line-height: 1.2;
        font-weight: 700;
        letter-spacing: -.5px
    }

    .ol-stat-ico {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: var(--gs);
        color: var(--g);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex: none
    }

    /* ---------- Toolbar ---------- */
    .ol-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px
    }

    .ol-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        background: #F3F4F6;
        padding: 4px;
        border-radius: 10px
    }

    .ol-tab {
        padding: 7px 14px;
        border-radius: 7px;
        color: var(--mute);
        font-weight: 500;
        font-size: 13px;
        text-decoration: none
    }

    .ol-tab:hover {
        color: var(--ink)
    }

    .ol-tab.on {
        background: #fff;
        color: var(--ink);
        box-shadow: 0 1px 2px rgba(16, 24, 40, .1)
    }

    .ol-search {
        display: flex;
        gap: 8px;
        flex: 1 1 280px;
        justify-content: flex-end
    }

    .ol-field {
        position: relative;
        flex: 1 1 220px;
        max-width: 340px
    }

    .ol-field i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        font-size: 12px
    }

    .ol-input,
    .ol-select {
        font: inherit;
        font-size: 13.5px;
        color: var(--ink);
        background: #fff;
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 9px 12px;
    }

    .ol-field .ol-input {
        padding-left: 34px
    }

    .ol-input:focus,
    .ol-select:focus {
        border-color: var(--g);
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 129, 61, .12)
    }

    .ol-btn {
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 14px;
        border-radius: 8px;
        border: 1px solid var(--g);
        background: var(--g);
        color: #fff;
        transition: background .15s, border-color .15s;
    }

    .ol-btn:hover {
        background: #006a32;
        border-color: #006a32;
        color: #fff
    }

    .ol-btn.ghost {
        background: #fff;
        color: var(--ink);
        border-color: var(--line)
    }

    .ol-btn.ghost:hover {
        background: var(--bg);
        border-color: #D1D5DB;
        color: var(--ink)
    }

    .ol-btn.sm {
        padding: 6px 11px;
        font-size: 12.5px
    }

    /* ---------- Table ---------- */
    .ol-card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 12px;
        overflow: hidden
    }

    .ol-scroll {
        overflow-x: auto
    }

    .ol-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 980px
    }

    .ol-table th {
        background: var(--bg);
        color: var(--mute);
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        text-align: left;
        padding: 12px 16px;
        border-bottom: 1px solid var(--line);
        white-space: nowrap;
    }

    .ol-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--line);
        vertical-align: middle
    }

    .ol-table tbody tr:last-child td {
        border-bottom: 0
    }

    .ol-table tbody tr:hover {
        background: #FCFCFD
    }

    .ol-table .r {
        text-align: right
    }

    .ol-no {
        font-weight: 700
    }

    .ol-muted {
        color: var(--mute);
        font-size: 12.5px
    }

    .ol-cust {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0
    }

    .ol-av {
        width: 32px;
        height: 32px;
        flex: none;
        border-radius: 50%;
        background: var(--gs);
        color: var(--g);
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center
    }

    .ol-items {
        max-width: 230px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #374151
    }

    .ol-amount {
        font-weight: 700;
        white-space: nowrap
    }

    .ol-acts {
        display: flex;
        gap: 6px;
        justify-content: flex-end
    }

    .ol-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap
    }

    .ol-pill::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor
    }

    .t-ok {
        background: #ECFDF3;
        color: #05603A
    }

    .t-warn {
        background: #FFFAEB;
        color: #B54708
    }

    .t-info {
        background: #F0F9FF;
        color: #026AA2
    }

    .t-blue {
        background: #EFF4FF;
        color: #2970FF
    }

    .t-bad {
        background: #FEF3F2;
        color: #B42318
    }

    .t-gray {
        background: #F2F4F7;
        color: #475467
    }

    .ol-pay {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-weight: 500;
        white-space: nowrap
    }

    .ol-pay::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #9CA3AF
    }

    .ol-pay.t-ok::before {
        background: #12B76A
    }

    .ol-pay.t-warn::before {
        background: #F79009
    }

    .ol-pay.t-bad::before {
        background: #F04438
    }

    .ol-pay.t-gray::before {
        background: #98A2B3
    }

    .ol-pay.t-ok,
    .ol-pay.t-warn,
    .ol-pay.t-bad,
    .ol-pay.t-gray {
        background: none;
        color: var(--ink);
        padding: 0
    }

    .ol-empty {
        text-align: center;
        padding: 54px 16px !important;
        color: var(--mute)
    }

    .ol-empty i {
        display: block;
        font-size: 26px;
        color: #D1D5DB;
        margin-bottom: 10px
    }

    .ol-pager {
        padding: 14px 16px;
        border-top: 1px solid var(--line)
    }

    /* ---------- Manage dialog ---------- */
    .ol-dialog {
        border: 0;
        border-radius: 14px;
        padding: 0;
        width: min(440px, 92vw);
        box-shadow: 0 24px 60px rgba(16, 24, 40, .25);
        color: var(--ink)
    }

    .ol-dialog::backdrop {
        background: rgba(16, 24, 40, .5)
    }

    .ol-dbody {
        padding: 22px
    }

    .ol-dhead {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 16px
    }

    .ol-dtitle {
        font-size: 18px;
        font-weight: 700
    }

    .ol-x {
        border: 0;
        background: #F3F4F6;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
        color: var(--mute)
    }

    .ol-x:hover {
        background: var(--line)
    }

    .ol-dform {
        display: grid;
        gap: 8px;
        padding: 14px 0 0;
        margin-top: 14px;
        border-top: 1px solid var(--line)
    }

    .ol-dform:first-of-type {
        border-top: 0;
        margin-top: 0;
        padding-top: 0
    }

    .ol-dform label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--mute)
    }

    /* ---------- Mobile: table becomes cards ---------- */
    @media(max-width:900px) {
        .ol-table {
            min-width: 0
        }

        .ol-table thead {
            display: none
        }

        .ol-table,
        .ol-table tbody,
        .ol-table tr,
        .ol-table td {
            display: block;
            width: 100%
        }

        .ol-table tr {
            padding: 12px 16px;
            border-bottom: 8px solid var(--bg)
        }

        .ol-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            padding: 7px 0;
            border: 0;
            text-align: right
        }

        .ol-table td::before {
            content: attr(data-label);
            color: var(--mute);
            font-size: 12px;
            font-weight: 600;
            text-align: left;
            flex: none
        }

        .ol-items {
            max-width: none;
            white-space: normal
        }

        .ol-acts {
            justify-content: flex-end
        }

        .ol-table td.ol-empty {
            display: block;
            text-align: center
        }

        .ol-table td.ol-empty::before {
            display: none
        }

        .ol-search {
            justify-content: stretch
        }

        .ol-field {
            max-width: none
        }
    }
</style>

<div class="ol">

    {{-- Header --}}
    <div class="ol-top">
        <div>
            <h1 class="ol-title">Orders</h1>
            <div class="ol-sub">Track and manage all food orders</div>
        </div>
        <div class="ol-live"><i></i><span id="lastUpdated">Live · refreshing every 5 seconds</span></div>
    </div>

    @if(session('success'))
    <div class="ol-alert ok"><i class="fas fa-circle-check" style="margin-top:3px"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    @if($errors->any())
    <div class="ol-alert bad">
        <i class="fas fa-circle-exclamation" style="margin-top:3px"></i>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- Stats --}}
    <div class="ol-stats" id="order-stats">
        <div class="ol-stat">
            <div><small>Total orders</small><b>{{ $stats['total'] }}</b></div>
            <div class="ol-stat-ico"><i class="fas fa-receipt"></i></div>
        </div>
        <div class="ol-stat">
            <div><small>Pending</small><b>{{ $stats['pending'] }}</b></div>
            <div class="ol-stat-ico"><i class="fas fa-hourglass-half"></i></div>
        </div>
        <div class="ol-stat">
            <div><small>Packed / Picked</small><b>{{ $stats['preparing'] }}</b></div>
            <div class="ol-stat-ico"><i class="fas fa-box-open"></i></div>
        </div>
        <div class="ol-stat">
            <div><small>Completed</small><b>{{ $stats['delivered'] }}</b></div>
            <div class="ol-stat-ico"><i class="fas fa-circle-check"></i></div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="ol-bar">
        <nav class="ol-tabs" aria-label="Filter orders">
            @foreach($tabs as $key => $label)
            <a href="{{ route('orders.index', array_filter(['status' => $key, 'search' => request('search')])) }}"
                class="ol-tab {{ $activeTab === (string) $key ? 'on' : '' }}">{{ $label }}</a>
            @endforeach
        </nav>

        <form method="GET" action="{{ route('orders.index') }}" class="ol-search">
            @if($activeTab !== '')<input type="hidden" name="status" value="{{ $activeTab }}">@endif
            <div class="ol-field">
                <i class="fas fa-magnifying-glass"></i>
                <input type="search" name="search" value="{{ request('search') }}" class="ol-input"
                    placeholder="Search order number or ID" aria-label="Search orders">
            </div>
            <button class="ol-btn" type="submit">Search</button>
            @if(request('search'))
            <a href="{{ route('orders.index', array_filter(['status' => $activeTab])) }}" class="ol-btn ghost">Clear</a>
            @endif
        </form>
    </div>

    {{-- Orders table --}}
    <div class="ol-card">
        <div class="ol-scroll">
            <table class="ol-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Placed</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th class="r">Amount</th>
                        <th class="r">Actions</th>
                    </tr>
                </thead>

                <tbody id="orders-table-body">
                    @forelse($orders as $order)
                    @php
                    $cur = $order->current_status ?? 'pending';
                    $tone = $statusTones[$cur] ?? 'gray';
                    $payStatus = strtolower((string) ($order->payment_status ?? $order->payment->status ?? 'Pending'));
                    $payLabel = ['success' => 'Paid', 'paid' => 'Paid'][$payStatus] ?? ucfirst($payStatus);
                    $initial = mb_strtoupper(mb_substr((string) $order->customer_name, 0, 1)) ?: '?';
                    @endphp
                    <tr>
                        <td data-label="Order">
                            <div class="ol-no">{{ $order->order_no }}</div>
                            <div class="ol-muted">ID: {{ $order->id }}</div>
                        </td>

                        <td data-label="Customer">
                            <div class="ol-cust"><span class="ol-av">{{ $initial }}</span>{{ $order->customer_name }}
                            </div>
                        </td>

                        <td data-label="Items">
                            <div class="ol-items" title="{{ $order->items_summary }}">{{ $order->items_summary ?: 'No
                                items' }}</div>
                        </td>

                        <td data-label="Placed">
                            <div>
                                {{ $order->created_at?->format('d M Y') }}
                                <span class="ol-muted">· {{ $order->created_at?->format('h:i:s A') }}</span>
                            </div>
                            <div class="ol-muted">{{ $order->created_at?->diffForHumans() }}</div>
                        </td>

                        <td data-label="Status">
                            <span class="ol-pill t-{{ $tone }}">{{ $statusLabels[$cur] ?? ucfirst($cur) }}</span>
                        </td>

                        <td data-label="Payment">
                            <span class="ol-pay t-{{ $payTones[$payStatus] ?? 'gray' }}">{{ $payLabel }}</span>
                        </td>

                        <td class="r ol-amount" data-label="Amount">₹{{ number_format((float) $order->total, 2) }}</td>

                        <td data-label="Actions">
                            <div class="ol-acts">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="ol-btn ghost sm"
                                    title="View details">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button type="button" class="ol-btn sm" data-manage data-id="{{ $order->id }}"
                                    data-no="{{ $order->order_no }}" data-status="{{ $cur }}"
                                    data-pay="{{ $payStatus }}">
                                    <i class="fas fa-sliders"></i> Manage
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="ol-empty"><i class="fas fa-bag-shopping"></i>No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="ol-pager" id="orders-pagination">{{ $orders->links() }}</div>
    </div>

    {{-- Manage dialog (one shared dialog for all rows) --}}
    <dialog id="manageDialog" class="ol-dialog" data-status-url="{{ route('orders.status.update', '__ID__') }}"
        data-pay-url="{{ route('orders.payment.update', '__ID__') }}">
        <div class="ol-dbody">
            <div class="ol-dhead">
                <div>
                    <div class="ol-dtitle">Manage order</div>
                    <div class="ol-muted" id="mdNo"></div>
                </div>
                <button type="button" class="ol-x" data-close aria-label="Close">&times;</button>
            </div>

            <form method="POST" id="mdStatusForm" class="ol-dform">
                @csrf @method('PATCH')
                <label for="mdStatus">Order status</label>
                <select name="status" id="mdStatus" class="ol-select" required>
                    @foreach($statuses as $s)
                    <option value="{{ $s }}">{{ $statusLabels[$s] ?? ucfirst($s) }}</option>
                    @endforeach
                </select>
                <input type="text" name="description" id="mdNote" class="ol-input"
                    placeholder="Tracking note (optional)" maxlength="2000">
                <button type="submit" class="ol-btn">Update order status</button>
            </form>

            <form method="POST" id="mdPayForm" class="ol-dform">
                @csrf @method('PATCH')
                <label for="mdPay">Payment status</label>
                <select name="payment_status" id="mdPay" class="ol-select" required>
                    @foreach($paymentStatuses as $p)
                    <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
                <button type="submit" class="ol-btn ghost">Update payment status</button>
            </form>
        </div>
    </dialog>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const dlg = document.getElementById('manageDialog');

    // Open the shared dialog for the clicked row (works after auto-refresh too)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-manage]');

        if (btn) {
            document.getElementById('mdNo').textContent = btn.dataset.no;
            document.getElementById('mdStatusForm').action = dlg.dataset.statusUrl.replace('__ID__', btn.dataset.id);
            document.getElementById('mdPayForm').action = dlg.dataset.payUrl.replace('__ID__', btn.dataset.id);
            document.getElementById('mdStatus').value = btn.dataset.status;
            document.getElementById('mdNote').value = '';

            const pay = document.getElementById('mdPay');
            Array.from(pay.options).forEach(function (o) {
                if (o.value.toLowerCase() === btn.dataset.pay) { pay.value = o.value; }
            });

            dlg.showModal();
            return;
        }

        if (e.target.closest('[data-close]') || e.target === dlg) {
            dlg.close();
        }
    });

    // Auto refresh (paused while the dialog is open)
    let refreshing = false;

    async function refreshOrders() {
        if (refreshing || document.hidden || dlg.open) {
            return;
        }

        refreshing = true;

        try {
            const response = await fetch(window.location.href, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                cache: 'no-store'
            });

            if (!response.ok) {
                return;
            }

            const html = await response.text();
            const fresh = new DOMParser().parseFromString(html, 'text/html');

            ['orders-table-body', 'order-stats', 'orders-pagination'].forEach(function (id) {
                const current = document.getElementById(id);
                const next = fresh.getElementById(id);

                if (current && next) {
                    current.innerHTML = next.innerHTML;
                }
            });

            document.getElementById('lastUpdated').textContent = 'Live · updated ' + new Date().toLocaleTimeString([], {
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        } catch (error) {
            console.error('Orders auto-refresh failed:', error);
        } finally {
            refreshing = false;
        }
    }

    setInterval(refreshOrders, 5000);
});
</script>
@endsection