@extends('layouts.dash-layout')

@section('title', 'Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="page-title mb-0">Categories</h4>
            <div class="page-sub">Organize your menu into categories</div>
        </div>
        <button class="btn btn-lp-gold px-3"><i class="bi bi-plus-lg me-1"></i> Add Category</button>
    </div>

    <div class="row g-3">
        @php
            $cats = [
                ['Coffee', '24 items', 'bi-cup-hot-fill', 'green'],
                ['Bakery', '18 items', 'bi-egg-fried', 'gold'],
                ['Breakfast', '12 items', 'bi-sunrise-fill', 'brown'],
                ['Cold Beverages', '15 items', 'bi-cup-straw', 'dark'],
                ['Desserts', '9 items', 'bi-cake2-fill', 'green'],
                ['Sandwiches', '11 items', 'bi-basket2-fill', 'gold'],
            ];
        @endphp
        @foreach($cats as $c)
        <div class="col-md-6 col-xl-4">
            <div class="ok-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-card {{ $c[3] }} p-0 d-flex align-items-center justify-content-center" style="width:56px;height:56px;border-radius:14px;">
                        <i class="bi {{ $c[2] }} fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $c[0] }}</div>
                        <div class="text-muted" style="font-size:.8rem;">{{ $c[1] }}</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
