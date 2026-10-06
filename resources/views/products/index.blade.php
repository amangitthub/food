```blade
@extends('layouts.dash-layout')

@section('title', 'Products')

@section('content')

    <div class="container-fluid py-4">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-1">Products</h3>
                <p class="text-muted mb-0">
                    Manage all your products.
                </p>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Add Product
            </a>

        </div>


        {{-- ================= SUCCESS MESSAGE ================= --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- ================= ERROR MESSAGE ================= --}}
        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>Please fix the following errors:</strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ================= PRODUCT CARD ================= --}}
        <div class="card border-0 shadow-sm">

            {{-- CARD HEADER --}}
            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-box-seam me-2"></i>
                            Product List
                        </h5>

                        <small class="text-muted">
                            Total Products:
                            <strong>{{ $products->count() }}</strong>
                        </small>
                    </div>

                </div>

            </div>


            {{-- CARD BODY --}}
            <div class="card-body p-0">

                @if ($products->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-3">
                                        #
                                    </th>

                                    <th>
                                        Image
                                    </th>

                                    <th>
                                        Product
                                    </th>

                                    <th>
                                        Category
                                    </th>

                                    <th>
                                        Type
                                    </th>

                                    <th>
                                        Price
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Created
                                    </th>

                                    <th class="text-center">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($products as $product)
                                    <tr>

                                        {{-- ID --}}
                                        <td class="px-3">
                                            {{ $product->id }}
                                        </td>


                                        {{-- IMAGE --}}
                                        <td>

                                            @php
                                                $productImage = $product->images->first();
                                            @endphp

                                            @if ($productImage && $productImage->image_path)
                                                <img src="{{ asset($productImage->image_path) }}"
                                                    alt="{{ $productImage->alt_text ?? $product->name }}" width="65"
                                                    height="65" class="rounded"
                                                    style="
                                                    object-fit: cover;
                                                    border: 1px solid #e9ecef;
                                                "
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                                <div class="bg-light rounded align-items-center justify-content-center"
                                                    style="
                                                    width:65px;
                                                    height:65px;
                                                    display:none;
                                                ">
                                                    <i class="bi bi-image text-muted fs-4"></i>
                                                </div>
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="
                                                    width:65px;
                                                    height:65px;
                                                ">
                                                    <i class="bi bi-image text-muted fs-4"></i>
                                                </div>
                                            @endif

                                        </td>


                                        {{-- PRODUCT --}}
                                        <td>

                                            <div class="fw-semibold">
                                                {{ $product->name }}
                                            </div>

                                            @if ($product->slug)
                                                <small class="text-muted">
                                                    {{ $product->slug }}
                                                </small>
                                            @endif

                                        </td>


                                        {{-- CATEGORY --}}
                                        <td>

                                            @if ($product->category)
                                                <span class="badge bg-light text-dark border">
                                                    {{ $product->category->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    —
                                                </span>
                                            @endif

                                        </td>


                                        {{-- PRODUCT TYPE --}}
                                        <td>

                                            @if ($product->product_type === 'combo')
                                                <span class="badge bg-info text-dark">
                                                    Combo
                                                </span>

                                                @if (is_array($product->combo_product_ids))
                                                    <small class="d-block text-muted mt-1">
                                                        {{ count($product->combo_product_ids) }}
                                                        product(s)
                                                    </small>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">
                                                    Single
                                                </span>
                                            @endif

                                        </td>


                                        {{-- PRICE --}}
                                        <td>

                                            <strong>
                                                ₹{{ number_format((float) $product->price, 2) }}
                                            </strong>

                                        </td>


                                        {{-- STATUS --}}
                                        <td>

                                            @if ($product->status === 'Active')
                                                <span class="badge bg-success">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Inactive
                                                </span>
                                            @endif

                                        </td>


                                        {{-- CREATED --}}
                                        <td>

                                            @if ($product->created_at)
                                                {{ $product->created_at->format('d M Y') }}

                                                <small class="d-block text-muted">
                                                    {{ $product->created_at->format('h:i A') }}
                                                </small>
                                            @else
                                                —
                                            @endif

                                        </td>


                                        {{-- ACTION --}}
                                        <td class="text-center">

                                            <div class="dropdown">

                                                <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                    Action
                                                </button>


                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    {{-- VIEW --}}
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.products.show', $product->id) }}">
                                                            <i class="bi bi-eye me-2"></i>
                                                            View
                                                        </a>
                                                    </li>


                                                    {{-- EDIT --}}
                                                    <li>

                                                        <a class="dropdown-item"
                                                            href="{{ route('products.edit', $product->id) }}">
                                                            <i class="bi bi-pencil me-2"></i>
                                                            Edit
                                                        </a>

                                                    </li>


                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>


                                                    {{-- DELETE --}}
                                                    <li>

                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                            method="POST" class="m-0"
                                                            onsubmit="return confirm('Are you sure you want to delete this product?');">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                                                <i class="bi bi-trash me-2"></i>
                                                                Delete
                                                            </button>

                                                        </form>

                                                    </li>

                                                </ul>

                                            </div>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                @else
                    {{-- ================= EMPTY STATE ================= --}}

                    <div class="text-center py-5">

                        <div class="mb-3">

                            <i class="bi bi-box-seam text-muted" style="font-size: 60px;"></i>

                        </div>

                        <h5 class="mb-2">
                            No Products Found
                        </h5>

                        <p class="text-muted mb-3">
                            You have not added any products yet.
                        </p>

                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Add First Product
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection
