@extends('layouts.dash-layout')

@section('title', 'Orders')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="page-title mb-0">Orders</h4>
            <div class="page-sub">Track and manage all food orders</div>
        </div>
        <button class="btn btn-lp-gold px-3"><i class="bi bi-plus-lg me-1"></i> New Order</button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3"><div class="stat-card green py-3"><small>Total</small><h3 class="mt-1">862</h3></div></div>
        <div class="col-6 col-xl-3"><div class="stat-card gold py-3"><small>Pending</small><h3 class="mt-1">37</h3></div></div>
        <div class="col-6 col-xl-3"><div class="stat-card brown py-3"><small>Preparing</small><h3 class="mt-1">19</h3></div></div>
        <div class="col-6 col-xl-3"><div class="stat-card dark py-3"><small>Delivered</small><h3 class="mt-1">781</h3></div></div>
    </div>

    <div class="ok-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span>All Orders</span>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm">
                    <option>All Status</option>
                    <option>Delivered</option>
                    <option>Preparing</option>
                    <option>Pending</option>
                    <option>Cancelled</option>
                </select>
                <input type="text" class="form-control form-control-sm" placeholder="Search order...">
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $orders = [
                                ['#LP-2041','Ananya Rawat','Hazelnut Cold Brew','29 Sep 2026','Delivered','₹320'],
                                ['#LP-2040','Kabir Mehta','Maple Oat Latte + Croissant','29 Sep 2026','Preparing','₹540'],
                                ['#LP-2039','Ritika Nair','Blueberry Muffin x2','28 Sep 2026','Pending','₹260'],
                                ['#LP-2038','Devansh Kohli','Cinnamon Croissant','28 Sep 2026','Cancelled','₹180'],
                                ['#LP-2037','Meher Kapoor','Dark Roast Pour Over','27 Sep 2026','Delivered','₹210'],
                                ['#LP-2036','Ishaan Bhatt','Avocado Toast + Chai','27 Sep 2026','Preparing','₹390'],
                            ];
                            $badge = ['Delivered'=>'badge-delivered','Preparing'=>'badge-preparing','Pending'=>'badge-pending','Cancelled'=>'badge-cancelled'];
                        @endphp
                        @foreach($orders as $o)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td class="fw-semibold">{{ $o[0] }}</td>
                            <td>{{ $o[1] }}</td>
                            <td class="text-muted">{{ $o[2] }}</td>
                            <td class="text-muted">{{ $o[3] }}</td>
                            <td><span class="badge-status {{ $badge[$o[4]] }}">{{ $o[4] }}</span></td>
                            <td class="text-end fw-semibold">{{ $o[5] }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav class="mt-3">
                <ul class="pagination pagination-sm justify-content-end mb-0">
                    <li class="page-item disabled"><a class="page-link">Prev</a></li>
                    <li class="page-item active"><a class="page-link">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
