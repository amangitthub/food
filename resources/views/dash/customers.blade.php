@extends('layouts.dash-layout')

@section('title', 'Customers')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="page-title mb-0">Customers</h4>
            <div class="page-sub">All registered Little Pause customers</div>
        </div>
        <button class="btn btn-lp-gold px-3"><i class="bi bi-plus-lg me-1"></i> Add Customer</button>
    </div>

    <div class="ok-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Customer List</span>
            <input type="text" class="form-control form-control-sm w-auto" placeholder="Search customer...">
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
                        @php
                            $customers = [
                                ['Ananya Rawat','+91 98765 43210','Dehradun','32','Feb 2025','Active'],
                                ['Kabir Mehta','+91 91234 56780','Rishikesh','21','Apr 2025','Active'],
                                ['Ritika Nair','+91 99887 76655','Mussoorie','14','Jun 2025','Active'],
                                ['Devansh Kohli','+91 90000 11122','Haridwar','6','Aug 2025','Inactive'],
                                ['Meher Kapoor','+91 98111 22334','Dehradun','40','Dec 2024','Active'],
                            ];
                        @endphp
                        @foreach($customers as $c)
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <img src="https://placehold.co/64x64/1F3D2E/ffffff?text={{ substr($c[0],0,1) }}" class="rounded-circle" width="36" height="36">
                                <span class="fw-semibold">{{ $c[0] }}</span>
                            </td>
                            <td class="text-muted">{{ $c[1] }}</td>
                            <td class="text-muted">{{ $c[2] }}</td>
                            <td>{{ $c[3] }}</td>
                            <td class="text-muted">{{ $c[4] }}</td>
                            <td class="text-end">
                                <span class="badge-status {{ $c[5] == 'Active' ? 'badge-delivered' : 'badge-cancelled' }}">{{ $c[5] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
