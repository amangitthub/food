@extends('layouts.dash-layout')

@section('title', 'Dashboard')

@section('content')
@php
    $stats = $stats ?? [];
    $topItems = $topItems ?? [];
    $recentOrders = $recentOrders ?? [];
    $chart = $chart ?? ['7' => ['labels' => [], 'data' => []], '30' => ['labels' => [], 'data' => []]];

    $topMax = max(1, (int) collect($topItems)->max('qty'));

    $statusLabels = [
        'pending' => 'Pending', 'packed' => 'Packed', 'picked' => 'Picked',
        'shipped' => 'Shipped', 'out_for_delivery' => 'Out for Delivery',
        'complete' => 'Completed', 'cancelled' => 'Cancelled',
        'return_requested' => 'Return Requested', 'returned' => 'Returned',
        'failed' => 'Failed',
    ];

    $statusTones = [
        'pending' => 'warning', 'packed' => 'info', 'picked' => 'info',
        'shipped' => 'primary', 'out_for_delivery' => 'primary',
        'complete' => 'success', 'cancelled' => 'danger',
        'return_requested' => 'warning', 'returned' => 'secondary',
        'failed' => 'danger',
    ];
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500&display=swap');

.db .fas,.db .far{font-family:"Font Awesome 6 Free" !important; font-style:normal}
.db .fas{font-weight:900 !important}
.db .far{font-weight:400 !important}

/* ---------- Theme (change colours here) ---------- */
.db{
    --ink:#151515; --rose:#D9A5A0; --rose-deep:#B9807A; --page:#FBF7F6;
    --card:#ffffff; --line:#F0E5E2; --muted:#8C807D; --soft:#FDF9F8;
    font-family:'Jost',system-ui,sans-serif; font-weight:300; font-size:14px;
    color:var(--ink); line-height:1.55; max-width:1300px; margin:0 auto;
}
.db *{box-sizing:border-box}
.db a{color:inherit}
.db-serif{font-family:'Cormorant Garamond',Georgia,serif}
.db a:focus-visible,.db button:focus-visible,.db select:focus-visible{outline:2px solid var(--rose-deep); outline-offset:2px}

/* ---------- Header ---------- */
.db-top{display:flex; flex-wrap:wrap; gap:16px; justify-content:space-between; align-items:flex-end; margin-bottom:24px}
.db-date{color:var(--rose-deep); font-size:13px; font-weight:400; margin-bottom:4px}
.db-title{font-size:clamp(32px,5.5vw,50px); line-height:1.02; margin:0; font-weight:600}
.db-sub{color:var(--muted); font-style:italic; margin-top:8px; font-size:15px}
.db-btn{
    font:inherit; font-weight:400; font-size:13px; cursor:pointer; text-decoration:none;
    display:inline-flex; align-items:center; justify-content:center; gap:8px;
    padding:10px 18px; border-radius:10px; border:1px solid var(--ink); background:var(--ink); color:#fff;
    transition:background .2s, border-color .2s;
}
.db-btn:hover{background:#2b2b2b; color:#fff}
.db-btn.ghost{background:var(--card); color:var(--ink); border-color:var(--line)}
.db-btn.ghost:hover{border-color:var(--rose); background:var(--soft); color:var(--ink)}
.db-btn.sm{padding:7px 14px; font-size:12px}

/* ---------- Stats ---------- */
.db-stats{display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:16px; margin-bottom:22px}
.db-stat{background:var(--card); border:1px solid var(--line); border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:16px}
.db-ico{width:48px; height:48px; flex:none; border-radius:50%; background:var(--soft); border:1px solid var(--line); color:var(--rose-deep); display:flex; align-items:center; justify-content:center; font-size:17px}
.db-stat small{color:var(--muted); font-size:12.5px; display:block}
.db-stat-n{font-size:36px; line-height:1.05; font-weight:700}
.db-stat.dark{background:var(--ink); border-color:var(--ink); color:#fff}
.db-stat.dark small{color:#c9c0be}
.db-stat.dark .db-stat-n{color:var(--rose)}
.db-stat.dark .db-ico{background:rgba(217,165,160,.14); border-color:rgba(217,165,160,.3); color:var(--rose)}

/* ---------- Layout ---------- */
.db-grid{display:grid; grid-template-columns:minmax(0,2fr) minmax(0,1fr); gap:20px; margin-bottom:20px}
@media(max-width:991px){.db-grid{grid-template-columns:minmax(0,1fr)}}
.db-card{background:var(--card); border:1px solid var(--line); border-radius:16px; padding:clamp(16px,3vw,24px); min-width:0}
.db-card-head{display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between; align-items:center; margin-bottom:18px}
.db-card-head h2{margin:0; font-size:26px; font-weight:600; line-height:1.1}
.db-select{
    font:inherit; font-weight:400; font-size:13px; color:var(--ink); background:var(--card);
    border:1px solid var(--line); border-radius:10px; padding:7px 12px;
}
.db-select:focus{border-color:var(--rose); outline:none; box-shadow:0 0 0 3px rgba(217,165,160,.2)}
.db-chart{position:relative; height:290px}
.db-empty{background:var(--soft); border:1px dashed var(--line); border-radius:12px; padding:22px 14px; text-align:center; color:var(--muted)}

/* ---------- Top items ---------- */
.db-top-list{display:grid; gap:18px}
.db-item{display:flex; align-items:center; gap:14px}
.db-rank{width:36px; height:36px; flex:none; border-radius:50%; background:var(--ink); color:var(--rose); display:flex; align-items:center; justify-content:center; font-size:19px; font-weight:700}
.db-item-body{flex:1; min-width:0}
.db-item-row{display:flex; justify-content:space-between; gap:10px; align-items:baseline}
.db-item-name{font-weight:500; font-size:14px; overflow-wrap:anywhere}
.db-item-count{color:var(--muted); font-size:12px; white-space:nowrap}
.db-bar{height:6px; border-radius:999px; background:var(--line); margin-top:7px; overflow:hidden}
.db-bar span{display:block; height:100%; border-radius:999px; background:var(--rose-deep)}

/* ---------- Recent orders ---------- */
.db-table-wrap{overflow-x:auto}
.db-table{width:100%; border-collapse:collapse}
.db-table th{text-align:left; font-weight:500; font-size:12px; color:var(--muted); padding:0 12px 12px; border-bottom:1px solid var(--line); white-space:nowrap}
.db-table td{padding:14px 12px; border-bottom:1px solid var(--line); vertical-align:middle}
.db-table tbody tr:last-child td{border-bottom:0}
.db-table tbody tr:hover{background:var(--soft)}
.db-table .r{text-align:right}
.db-oid{font-weight:500; text-decoration:none}
.db-oid:hover{color:var(--rose-deep)}
.db-muted{color:var(--muted)}
.db-pill{display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:500; white-space:nowrap}
.db-pill::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor}
.st-warning{background:#FFF3CD; color:#7A5B00}
.st-info{background:#D5F1F8; color:#055160}
.st-primary{background:#DCE8FE; color:#1D4ED8}
.st-success{background:#D6EEDF; color:#0F5132}
.st-danger{background:#F9DADD; color:#842029}
.st-secondary{background:#E7E5E4; color:#41464B}

@media(max-width:640px){
    .db-table thead{display:none}
    .db-table, .db-table tbody, .db-table tr, .db-table td{display:block; width:100%}
    .db-table tr{border:1px solid var(--line); border-radius:12px; padding:10px 12px; margin-bottom:10px}
    .db-table td{display:flex; justify-content:space-between; align-items:center; gap:12px; padding:6px 0; border:0; text-align:right}
    .db-table td::before{content:attr(data-label); color:var(--muted); font-size:12px; text-align:left}
}
</style>

<div class="db">

    {{-- Header --}}
<div class="db-top">
        <div>
            <div class="db-date">{{ now()->format('l, d M Y') }}</div>
            <h1 class="db-title db-serif">Welcome back, Admin</h1>
            <div class="db-sub">A moment worth pausing for — here's today's snapshot.</div>
        </div>
        <button type="button" class="db-btn">
            <a href="{{ route('products.create') }}" class="btn">
                <i class="bi bi-plus-circle me-1"></i>
                Add Product
            </a>
        </button>
    </div>

    {{-- Stats (live from database) --}}
    <div class="db-stats">
        <div class="db-stat">
            <div class="db-ico"><i class="fas fa-bag-shopping"></i></div>
            <div><small>Total orders</small><div class="db-stat-n db-serif">{{ $stats['total_orders'] ?? 0 }}</div></div>
        </div>
        <div class="db-stat">
            <div class="db-ico"><i class="fas fa-hourglass-half"></i></div>
            <div><small>Pending orders</small><div class="db-stat-n db-serif">{{ $stats['pending'] ?? 0 }}</div></div>
        </div>
        <div class="db-stat">
            <div class="db-ico"><i class="fas fa-wallet"></i></div>
            <div><small>Revenue this month</small><div class="db-stat-n db-serif">{{ $stats['revenue'] ?? '₹0' }}</div></div>
        </div>
        <div class="db-stat dark">
            <div class="db-ico"><i class="fas fa-users"></i></div>
            <div><small>Active customers</small><div class="db-stat-n db-serif">{{ $stats['customers'] ?? 0 }}</div></div>
        </div>
    </div>

    {{-- Chart + Top items --}}
    <div class="db-grid">
        <section class="db-card">
            <div class="db-card-head">
                <h2 class="db-serif">Sales overview</h2>
                <select class="db-select" id="salesRange" aria-label="Sales range">
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                </select>
            </div>
            <div class="db-chart">
                <canvas id="salesChart"></canvas>
            </div>
        </section>

        <section class="db-card">
            <div class="db-card-head">
                <h2 class="db-serif">Top selling items</h2>
            </div>

            @if(count($topItems))
                <div class="db-top-list">
                    @foreach($topItems as $index => $item)
                        <div class="db-item">
                            <div class="db-rank db-serif">{{ $index + 1 }}</div>
                            <div class="db-item-body">
                                <div class="db-item-row">
                                    <span class="db-item-name">{{ $item['name'] }}</span>
                                    <span class="db-item-count">{{ $item['qty'] }} sold</span>
                                </div>
                                <div class="db-bar"><span style="width:{{ round(($item['qty'] / $topMax) * 100) }}%"></span></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="db-empty">No sales yet. Top items will show here after the first orders.</div>
            @endif
        </section>
    </div>

    {{-- Recent orders --}}
    <section class="db-card">
        <div class="db-card-head">
            <h2 class="db-serif">Recent orders</h2>
            <a href="{{ route('orders.index') }}" class="db-btn ghost sm">View all orders</a>
        </div>

        @if(count($recentOrders))
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th class="r">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $r)
                            @php $tone = $statusTones[$r['status']] ?? 'secondary'; @endphp
                            <tr>
                                <td data-label="Order ID">
                                    <a class="db-oid" href="{{ route('admin.orders.show', $r['id']) }}">{{ $r['no'] }}</a>
                                </td>
                                <td data-label="Customer">{{ $r['customer'] }}</td>
                                <td class="db-muted" data-label="Item">{{ $r['item'] }}</td>
                                <td data-label="Status">
                                    <span class="db-pill st-{{ $tone }}">{{ $statusLabels[$r['status']] ?? ucfirst($r['status']) }}</span>
                                </td>
                                <td class="r" data-label="Amount" style="font-weight:500">₹{{ number_format($r['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="db-empty">No orders yet.</div>
        @endif
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('salesChart');
    const ctx = canvas.getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 290);
    gradient.addColorStop(0, 'rgba(217,165,160,0.45)');
    gradient.addColorStop(1, 'rgba(217,165,160,0)');

    Chart.defaults.font.family = "'Jost', system-ui, sans-serif";
    Chart.defaults.color = '#8C807D';

    // Real data from the database (sum of order totals per day)
    const ranges = @json($chart);

    const chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: ranges['7'].labels,
            datasets: [{
                label: 'Sales (₹)',
                data: ranges['7'].data,
                borderColor: '#B9807A',
                backgroundColor: gradient,
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#151515',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#151515',
                    titleColor: '#D9A5A0',
                    padding: 10,
                    displayColors: false,
                    callbacks: {
                        label: function (item) {
                            return '₹' + Number(item.parsed.y).toLocaleString('en-IN');
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { maxTicksLimit: 8 } },
                y: { beginAtZero: true, grid: { color: '#F0E5E2' }, border: { display: false } }
            }
        }
    });

    document.getElementById('salesRange').addEventListener('change', function () {
        const r = ranges[this.value];
        const small = this.value === '30';

        chart.data.labels = r.labels;
        chart.data.datasets[0].data = r.data;
        chart.data.datasets[0].pointRadius = small ? 3 : 5;
        chart.update();
    });
});
</script>
@endsection