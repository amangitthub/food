@extends('layouts.dash-layout')

@section('title', 'Customers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="page-title mb-0">Customers</h4>
        <div class="page-sub">All registered Little Pause customers</div>
    </div>
</div>

<div class="ok-card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>Customer List ({{ $customers->total() }})</span>

        <form method="GET" action="{{ route('customers.index') }}">
            <input
                type="text"
                name="search"
                class="form-control form-control-sm"
                placeholder="Search customer..."
                value="{{ $search }}"
            >
        </form>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Total Orders</th>
                        <th>Joined</th>
                        <th class="text-end">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:36px;height:36px;background:#1F3D2E;color:white;font-weight:600;"
                                    >
                                        {{ strtoupper(substr($customer->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $customer->name ?? 'N/A' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $customer->email ?? 'N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-muted">
                                {{ $customer->customer_phone }}
                            </td>

                            <td class="text-muted">
                                {{ $customer->customer_city }}
                            </td>

                            <td>
                                {{ $customer->total_orders }}
                            </td>

                            <td class="text-muted">
                                {{ $customer->created_at
                                    ? \Illuminate\Support\Carbon::parse($customer->created_at)->format('d M Y')
                                    : 'N/A'
                                }}
                            </td>

                            <td class="text-end">
                                @php
                                    $isActive = strtolower((string) $customer->customer_status) === 'active';
                                @endphp

                                <span class="badge-status {{ $isActive ? 'badge-delivered' : 'badge-cancelled' }}">
                                    {{ ucfirst($customer->customer_status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No customers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
