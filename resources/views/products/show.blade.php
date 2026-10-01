@extends('layouts.dash-layout')

@section('title', 'View Product')

@section('content')

    <div class="container-fluid py-4">

        {{-- =========================
        PAGE HEADER
    ========================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">Product Details</h4>
                <p class="text-muted mb-0">
                    View complete product information
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">

                    <i class="bi bi-pencil me-1"></i>
                    Edit Product

                </a>

                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-1"></i>
                    Back

                </a>

            </div>

        </div>


        {{-- =========================
        PRODUCT DETAILS
    ========================== --}}
        <div class="row g-4">

            {{-- LEFT SIDE --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title mb-3">
                            Product Images
                        </h5>


                        @if ($product->images->count())

                            <div class="row g-3">

                                @foreach ($product->images as $image)
                                    <div class="col-6">

                                        <div class="border rounded p-2">

                                            <img src="{{ asset($image->image_path) }}"
                                                alt="{{ $image->alt_text ?? $product->name }}" class="img-fluid rounded"
                                                style="width:100%; height:180px; object-fit:cover;"
                                                onerror="this.style.display='none';">

                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="text-center py-5">

                                <i class="bi bi-image fs-1 text-muted"></i>

                                <p class="text-muted mt-2 mb-0">
                                    No product images available.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- RIGHT SIDE --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start mb-4">

                            <div>

                                <h4 class="mb-1">
                                    {{ $product->name }}
                                </h4>

                                <small class="text-muted">
                                    Slug: {{ $product->slug ?? '-' }}
                                </small>

                            </div>


                            @if ($product->status === 'Active')
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Inactive
                                </span>
                            @endif

                        </div>


                        <div class="row g-4">

                            {{-- CATEGORY --}}
                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Category
                                    </small>

                                    <strong>

                                        @if ($product->category)
                                            {{ $product->category->name }}
                                        @else
                                            -
                                        @endif

                                    </strong>

                                </div>

                            </div>


                            {{-- PRODUCT TYPE --}}
                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Product Type
                                    </small>

                                    <strong>

                                        @if ($product->product_type === 'combo')
                                            Combo
                                        @else
                                            Single
                                        @endif

                                    </strong>

                                </div>

                            </div>


                            {{-- PRICE --}}
                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Price
                                    </small>

                                    <strong class="fs-5 text-success">

                                        ₹{{ number_format((float) $product->price, 2) }}

                                    </strong>

                                </div>

                            </div>


                            {{-- CREATED --}}
                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Created At
                                    </small>

                                    <strong>

                                        {{ $product->created_at ? $product->created_at->format('d M Y, h:i A') : '-' }}

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- =========================
                        SHORT DESCRIPTION
                    ========================== --}}

                        @if ($product->short_description)
                            <div class="mt-4">

                                <h6 class="fw-bold">
                                    Short Description
                                </h6>

                                <div class="border rounded p-3 bg-light">

                                    {{ $product->short_description }}

                                </div>

                            </div>
                        @endif


                        {{-- =========================
                        DESCRIPTION
                    ========================== --}}

                        @if ($product->description)
                            <div class="mt-4">

                                <h6 class="fw-bold">
                                    Description
                                </h6>

                                <div class="border rounded p-3">

                                    {!! nl2br(e($product->description)) !!}

                                </div>

                            </div>
                        @endif


                        {{-- =========================
                        COMBO PRODUCTS
                    ========================== --}}

                        @if ($product->product_type === 'combo' && is_array($product->combo_product_ids) && count($product->combo_product_ids))

                            <div class="mt-4">

                                <h6 class="fw-bold">
                                    Combo Products
                                </h6>

                                <div class="border rounded p-3">

                                    @foreach ($product->combo_product_ids as $comboId)
                                        @php
                                            $comboProduct = \App\Models\Product::find($comboId);
                                        @endphp

                                        @if ($comboProduct)
                                            <span class="badge bg-light text-dark border me-1 mb-1">

                                                {{ $comboProduct->name }}

                                            </span>
                                        @endif
                                    @endforeach

                                </div>

                            </div>

                        @endif


                        {{-- =========================
                        UPDATED AT
                    ========================== --}}

                        <div class="mt-4 pt-3 border-top">

                            <small class="text-muted">

                                Last Updated:

                                {{ $product->updated_at ? $product->updated_at->format('d M Y, h:i A') : '-' }}

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
