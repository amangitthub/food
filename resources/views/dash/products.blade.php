@extends('layouts.dash-layout')

@section('title', 'Products')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="page-title mb-0">Products</h4>
            <div class="page-sub">Manage your menu items</div>
        </div>
        <button class="btn btn-lp-gold px-3"><i class="bi bi-plus-lg me-1"></i> Add Product</button>
    </div>

    <div class="d-flex gap-2 mb-4">
        <select class="form-select form-select-sm w-auto">
            <option>All Categories</option>
            <option>Coffee</option>
            <option>Bakery</option>
            <option>Breakfast</option>
        </select>
        <input type="text" class="form-control form-control-sm w-auto" placeholder="Search products...">
    </div>

    <div class="row g-3">
        @php
            $products = [
                ['Hazelnut Cold Brew','Coffee','₹280','4.8','https://placehold.co/300x200/1F3D2E/F3ECDC?text=Cold+Brew','In Stock'],
                ['Cinnamon Croissant','Bakery','₹150','4.6','https://placehold.co/300x200/C9963E/ffffff?text=Croissant','In Stock'],
                ['Maple Oat Latte','Coffee','₹260','4.9','https://placehold.co/300x200/4A2E1E/ffffff?text=Latte','In Stock'],
                ['Blueberry Muffin','Bakery','₹130','4.5','https://placehold.co/300x200/2B241C/F3ECDC?text=Muffin','Low Stock'],
                ['Avocado Toast','Breakfast','₹240','4.7','https://placehold.co/300x200/1F3D2E/F3ECDC?text=Toast','In Stock'],
                ['Dark Roast Pour Over','Coffee','₹210','4.4','https://placehold.co/300x200/C9963E/ffffff?text=Pour+Over','Out of Stock'],
            ];
        @endphp
        @foreach($products as $p)
        <div class="col-md-6 col-xl-4">
            <div class="ok-card h-100 overflow-hidden">
                <img src="{{ $p[4] }}" class="w-100" style="height:160px; object-fit:cover;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div>
                            <div class="fw-semibold">{{ $p[0] }}</div>
                            <div class="text-muted" style="font-size:.78rem;">{{ $p[1] }}</div>
                        </div>
                        <span class="rating-pill"><i class="bi bi-star-fill"></i> {{ $p[3] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-bold" style="color: var(--lp-green-dark);">{{ $p[2] }}</span>
                        <span class="badge-status {{ $p[5] == 'In Stock' ? 'badge-delivered' : ($p[5] == 'Low Stock' ? 'badge-pending' : 'badge-cancelled') }}">
                            {{ $p[5] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
