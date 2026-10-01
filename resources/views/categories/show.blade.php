@extends('layouts.dash-layout')

@section('title', 'View Category')

@section('content')

    <div class="container-fluid py-4">

        {{-- =========================
        PAGE HEADER
    ========================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">Category Details</h4>

                <p class="text-muted mb-0">
                    View complete category information
                </p>
            </div>

            <div class="d-flex gap-2">

                {{-- EDIT --}}
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">

                    <i class="bi bi-pencil me-1"></i>
                    Edit Category

                </a>

                {{-- BACK --}}
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-1"></i>
                    Back

                </a>

            </div>

        </div>


        {{-- =========================
        CATEGORY DETAILS
    ========================== --}}
        <div class="row g-4">

            {{-- =========================
            LEFT SIDE - IMAGE
        ========================== --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title mb-3">
                            Category Image
                        </h5>


                        @if ($category->image)
                            <div class="border rounded p-2 bg-white">

                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                    class="img-fluid rounded" style="width:100%; height:320px; object-fit:cover;"
                                    onerror="this.style.display='none';">

                            </div>
                        @else
                            <div class="border rounded d-flex flex-column justify-content-center align-items-center"
                                style="height:320px;">

                                <i class="bi bi-image fs-1 text-muted"></i>

                                <p class="text-muted mt-2 mb-0">
                                    No category image available.
                                </p>

                            </div>
                        @endif

                    </div>

                </div>

            </div>


            {{-- =========================
            RIGHT SIDE - DETAILS
        ========================== --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        {{-- CATEGORY TITLE --}}
                        <div class="d-flex justify-content-between align-items-start mb-4">

                            <div>

                                <h3 class="mb-1">
                                    {{ $category->name }}
                                </h3>

                                <small class="text-muted">

                                    Slug:

                                    {{ $category->slug ?? '-' }}

                                </small>

                            </div>


                            {{-- STATUS --}}
                            @if ($category->status === 'active')
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Inactive
                                </span>
                            @endif

                        </div>


                        {{-- =========================
                        BASIC INFORMATION
                    ========================== --}}
                        <div class="row g-4">

                            {{-- CATEGORY ID --}}
                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Category ID
                                    </small>

                                    <strong>
                                        #{{ $category->id }}
                                    </strong>

                                </div>

                            </div>


                            {{-- STATUS --}}
                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Status
                                    </small>

                                    <strong>

                                        {{ ucfirst($category->status) }}

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

                                        {{ $category->created_at ? $category->created_at->format('d M Y, h:i A') : '-' }}

                                    </strong>

                                </div>

                            </div>


                            {{-- UPDATED --}}
                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Last Updated
                                    </small>

                                    <strong>

                                        {{ $category->updated_at ? $category->updated_at->format('d M Y, h:i A') : '-' }}

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- =========================
                        SHORT DESCRIPTION
                    ========================== --}}
                        @if ($category->short_description)
                            <div class="mt-4">

                                <h6 class="fw-bold">
                                    Short Description
                                </h6>

                                <div class="border rounded p-3 bg-light">

                                    {{ $category->short_description }}

                                </div>

                            </div>
                        @endif


                        {{-- =========================
                        DESCRIPTION
                    ========================== --}}
                        @if ($category->description)
                            <div class="mt-4">

                                <h6 class="fw-bold">
                                    Description
                                </h6>

                                <div class="border rounded p-3">

                                    {!! nl2br(e($category->description)) !!}

                                </div>

                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
