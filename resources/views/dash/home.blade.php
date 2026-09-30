@extends('layouts.dash-layout')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="page-title mb-0">Welcome back, Admin</h4>
            <div class="page-sub fst-italic">A moment worth pausing for — here's today's snapshot.</div>
        </div>
        <button class="btn btn-lp-gold px-3"><i class="bi bi-plus-lg me-1"></i> Add Product</button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card green">
                <div class="icon-wrap"><i class="bi bi-bag-check-fill"></i></div>
                <h3>{{ $stats['total_orders'] ?? '862' }}</h3>
                <small>Total Orders</small>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card gold">
                <div class="icon-wrap"><i class="bi bi-clock-history"></i></div>
                <h3>{{ $stats['pending'] ?? '37' }}</h3>
                <small>Pending Orders</small>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card brown">
                <div class="icon-wrap"><i class="bi bi-wallet2"></i></div>
                <h3>{{ $stats['revenue'] ?? '₹2.8L' }}</h3>
                <small>Revenue this month</small>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card dark">
                <div class="icon-wrap"><i class="bi bi-people-fill"></i></div>
                <h3>{{ $stats['customers'] ?? '419' }}</h3>
                <small>Active Customers</small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="ok-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Sales Overview
                    <select class="form-select form-select-sm w-auto">
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="ok-card h-100">
                <div class="card-header">Top Selling Items</div>
                <div class="card-body">
                    @php
                        $items = [
                            ['Hazelnut Cold Brew', '128 orders', 'https://placehold.co/80x80/1F3D2E/F3ECDC?text=☕'],
                            ['Cinnamon Croissant', '96 orders', 'https://placehold.co/80x80/C9963E/ffffff?text=🥐'],
                            ['Maple Oat Latte', '81 orders', 'https://placehold.co/80x80/4A2E1E/ffffff?text=☕'],
                            ['Blueberry Muffin', '64 orders', 'https://placehold.co/80x80/2B241C/F3ECDC?text=🧁'],
                        ];
                    @endphp
                    @foreach($items as $i)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $i[2] }}" class="food-thumb">
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:.88rem;">{{ $i[0] }}</div>
                            <div class="text-muted" style="font-size:.76rem;">{{ $i[1] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="ok-card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            Recent Orders
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-lp-primary">View all</a>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rows = [
                                ['#LP-2041','Ananya Rawat','Hazelnut Cold Brew','Delivered','₹320'],
                                ['#LP-2040','Kabir Mehta','Maple Oat Latte + Croissant','Preparing','₹540'],
                                ['#LP-2039','Ritika Nair','Blueberry Muffin x2','Pending','₹260'],
                                ['#LP-2038','Devansh Kohli','Cinnamon Croissant','Cancelled','₹180'],
                            ];
                            $badge = ['Delivered'=>'badge-delivered','Preparing'=>'badge-preparing','Pending'=>'badge-pending','Cancelled'=>'badge-cancelled'];
                        @endphp
                        @foreach($rows as $r)
                        <tr>
                            <td class="fw-semibold">{{ $r[0] }}</td>
                            <td>{{ $r[1] }}</td>
                            <td class="text-muted">{{ $r[2] }}</td>
                            <td><span class="badge-status {{ $badge[$r[3]] }}">{{ $r[3] }}</span></td>
                            <td class="text-end fw-semibold">{{ $r[4] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'Sales',
                data: [22, 35, 28, 40, 52, 38, 45],
                borderColor: '#1F3D2E',
                backgroundColor: 'rgba(201,150,62,0.15)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#C9963E',
                pointRadius: 4,
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection
