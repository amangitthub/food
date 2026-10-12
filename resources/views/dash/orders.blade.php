@extends('layouts.dash-layout')

@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="page-title mb-0">Orders</h4>
        <div class="page-sub">Track and manage all food orders</div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="badge text-bg-success">
            <span class="d-inline-block rounded-circle bg-white me-1" style="width:7px;height:7px"></span>
            Live Updates
        </span>
        <small class="text-muted" id="lastUpdated">Refreshing every 5 seconds</small>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3 mb-4" id="order-stats">
    <div class="col-6 col-xl-3">
        <div class="stat-card green py-3">
            <small>Total Orders</small>
            <h3 class="mt-1">{{ $stats['total'] }}</h3>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card gold py-3">
            <small>Pending</small>
            <h3 class="mt-1">{{ $stats['pending'] }}</h3>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card brown py-3">
            <small>Packed / Picked</small>
            <h3 class="mt-1">{{ $stats['preparing'] }}</h3>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card dark py-3">
            <small>Completed</small>
            <h3 class="mt-1">{{ $stats['delivered'] }}</h3>
        </div>
    </div>
</div>

<div class="ok-card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>All Orders</span>

        <form method="GET" action="{{ route('orders.index') }}" class="d-flex gap-2" style="max-width:100%">

            <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                placeholder="Search order number or ID..." aria-label="Search orders">

            <button class="btn btn-sm btn-dark" type="submit">
                Search
            </button>

            @if(request('search'))
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">
                Clear
            </a>
            @endif
        </form>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Date</th>
                        <th>Current Status</th>
                        <th>Update Status</th>
                        <th class="text-end">Amount / Details</th>
                    </tr>
                </thead>

                <tbody id="orders-table-body">
                    @forelse($orders as $order)
                    @php
                    $statusLabels = [
                    'pending' => 'Pending',
                    'packed' => 'Packed',
                    'picked' => 'Picked',
                    'shipped' => 'Shipped',
                    'out_for_delivery' => 'Out for Delivery',
                    'complete' => 'Completed',
                    'cancelled' => 'Cancelled',
                    'return_requested' => 'Return Requested',
                    'returned' => 'Returned',
                    'failed' => 'Failed',
                    ];

                    $statusColors = [
                    'pending' => 'warning',
                    'packed' => 'info',
                    'picked' => 'info',
                    'shipped' => 'primary',
                    'out_for_delivery' => 'primary',
                    'complete' => 'success',
                    'cancelled' => 'danger',
                    'return_requested' => 'warning',
                    'returned' => 'secondary',
                    'failed' => 'danger',
                    ];

                    $currentStatus = $order->current_status ?? 'pending';
                    @endphp

                    <tr>
                        <td class="fw-semibold">
                            {{ $order->order_no }}
                            <div class="text-muted small">
                                ID: {{ $order->id }}
                            </div>
                        </td>

                        <td>{{ $order->customer_name }}</td>

                        <td style="min-width:180px;max-width:260px;white-space:normal">
                            {{ $order->items_summary ?: 'No items' }}
                        </td>

                        <td class="text-muted">
                            {{ $order->created_at?->format('d M Y') }}
                            <div class="small">
                                {{ $order->created_at?->format('h:i A') }}
                            </div>
                        </td>

                        <td>
                            <span class="badge text-bg-{{ $statusColors[$currentStatus] ?? 'secondary' }}">
                                {{ $statusLabels[$currentStatus] ?? ucfirst($currentStatus) }}
                            </span>
                        </td>

                        <td style="min-width:230px">
                            <form method="POST" action="{{ route('orders.status.update', $order->id) }}">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="form-select form-select-sm mb-2" required>
                                    @foreach($statuses as $status)
                                    <option value="{{ $status }}" @selected($currentStatus===$status)>
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </option>
                                    @endforeach
                                </select>

                                <input type="text" name="description" class="form-control form-control-sm mb-2"
                                    placeholder="Tracking note (optional)" maxlength="2000">

                                <button type="submit" class="btn btn-sm btn-dark w-100">
                                    Update Status
                                </button>
                            </form>
                        </td>

                        <td class="text-end">
                            <div class="fw-semibold mb-2">
                                ₹{{ number_format((float) $order->total, 2) }}
                            </div>

                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark">
                                <i class="fas fa-eye me-1"></i>
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            No orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3" id="orders-pagination">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    let refreshing = false;

    async function refreshOrders() {
        if (refreshing || document.hidden) {
            return;
        }

        // Do not replace the table while admin is editing a form.
        const activeElement = document.activeElement;

        if (
            activeElement &&
            activeElement.closest('#orders-table-body form')
        ) {
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
            const newDocument = new DOMParser().parseFromString(
                html,
                'text/html'
            );

            const currentBody = document.getElementById('orders-table-body');
            const newBody = newDocument.getElementById('orders-table-body');

            if (currentBody && newBody) {
                currentBody.innerHTML = newBody.innerHTML;
            }

            const currentStats = document.getElementById('order-stats');
            const newStats = newDocument.getElementById('order-stats');

            if (currentStats && newStats) {
                currentStats.innerHTML = newStats.innerHTML;
            }

            const currentPagination = document.getElementById('orders-pagination');
            const newPagination = newDocument.getElementById('orders-pagination');

            if (currentPagination && newPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
            }

            const lastUpdated = document.getElementById('lastUpdated');

            if (lastUpdated) {
                lastUpdated.textContent =
                    'Updated at ' +
                    new Date().toLocaleTimeString([], {
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