@extends('layouts.dash-layout')
@section('title', 'Categories')
@section('content')

    <div class="container-fluid py-4">

        {{-- =====================================================
        PAGE HEADER
    ====================================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Categories
                </h4>

                <p class="text-muted mb-0">
                    Manage your product categories
                </p>
            </div>

            <a href="{{ route('categories.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-lg me-1"></i>
                Add Category

            </a>

        </div>


        {{-- =====================================================
        SUCCESS MESSAGE
    ====================================================== --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">

                <i class="bi bi-check-circle me-2"></i>

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif


        {{-- =====================================================
        VALIDATION ERRORS
    ====================================================== --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif


        {{-- =====================================================
        CATEGORY CARD
    ====================================================== --}}
        <div class="card border-0 shadow-sm">

            {{-- CARD HEADER --}}
            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-1 fw-semibold">
                            Category List
                        </h5>

                        <small class="text-muted">
                            All available categories
                        </small>

                    </div>

                    <span class="badge bg-primary rounded-pill px-3 py-2">

                        {{ $categories->count() }}

                        {{ $categories->count() == 1 ? 'Category' : 'Categories' }}

                    </span>

                </div>

            </div>


            {{-- CARD BODY --}}
            <div class="card-body p-0">

                {{-- =================================================
                CATEGORY EXISTS
            ================================================== --}}
                @if ($categories->count() > 0)
                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            {{-- TABLE HEADER --}}
                            <thead class="table-light">

                                <tr>

                                    <th class="px-3" style="width:70px;">
                                        #
                                    </th>

                                    <th style="width:100px;">
                                        Image
                                    </th>

                                    <th>
                                        Name
                                    </th>

                                    <th>
                                        Slug
                                    </th>

                                    <th>
                                        Short Description
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Created At
                                    </th>

                                    <th class="text-center" style="width:100px;">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            {{-- TABLE BODY --}}
                            <tbody>

                                @foreach ($categories as $category)
                                    <tr>

                                        {{-- =========================
                                        ID
                                    ========================== --}}
                                        <td class="px-3">

                                            <span class="fw-semibold">
                                                {{ $category->id }}
                                            </span>

                                        </td>


                                        {{-- =========================
                                        IMAGE
                                    ========================== --}}
                                        <td>

                                            @if ($category->image)
                                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                                    width="60" height="60" class="rounded"
                                                    style="
                                                    object-fit: cover;
                                                    border: 1px solid #e9ecef;
                                                "
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                                {{-- IMAGE FALLBACK --}}
                                                <div class="align-items-center justify-content-center bg-light rounded"
                                                    style="
                                                    width:60px;
                                                    height:60px;
                                                    display:none;
                                                ">

                                                    <i class="bi bi-image text-muted fs-4"></i>

                                                </div>
                                            @else
                                                {{-- NO IMAGE --}}
                                                <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                                    style="
                                                    width:60px;
                                                    height:60px;
                                                ">

                                                    <i class="bi bi-image text-muted fs-4"></i>

                                                </div>
                                            @endif

                                        </td>


                                        {{-- =========================
                                        NAME
                                    ========================== --}}
                                        <td>

                                            <div class="fw-semibold">
                                                {{ $category->name }}
                                            </div>

                                        </td>


                                        {{-- =========================
                                        SLUG
                                    ========================== --}}
                                        <td>

                                            <span class="text-muted">
                                                {{ $category->slug ?: '—' }}
                                            </span>

                                        </td>


                                        {{-- =========================
                                        SHORT DESCRIPTION
                                    ========================== --}}
                                        <td>

                                            @if ($category->short_description)
                                                <span title="{{ $category->short_description }}">

                                                    {{ \Illuminate\Support\Str::limit($category->short_description, 60) }}

                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    —
                                                </span>
                                            @endif

                                        </td>


                                        {{-- =========================
                                        STATUS
                                    ========================== --}}
                                        <td>

                                            @if ($category->status === 'active')
                                                <span class="badge bg-success">

                                                    <i class="bi bi-check-circle me-1"></i>

                                                    Active

                                                </span>
                                            @else
                                                <span class="badge bg-danger">

                                                    <i class="bi bi-x-circle me-1"></i>

                                                    Inactive

                                                </span>
                                            @endif

                                        </td>


                                        {{-- =========================
                                        CREATED AT
                                    ========================== --}}
                                        <td>

                                            @if ($category->created_at)
                                                <span class="text-muted">

                                                    {{ $category->created_at->format('d M Y') }}

                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    —
                                                </span>
                                            @endif

                                        </td>


                                        {{-- =========================
                                        ACTION
                                    ========================== --}}
                                        <td class="text-center">

                                            <div class="dropdown">

                                                <button class="btn btn-sm btn-light border" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false" title="Actions">

                                                    <i class="bi bi-three-dots-vertical"></i>

                                                </button>


                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                                                    {{-- VIEW --}}
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('categories.show', $category->id) }}">

                                                            <i class="bi bi-eye me-2"></i>
                                                            View

                                                        </a>
                                                    </li>


                                                    {{-- EDIT --}}
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('categories.edit', $category->id) }}">

                                                            <i class="bi bi-pencil me-2"></i>
                                                            Edit

                                                        </a>
                                                    </li>


                                                    <li>

                                                        <hr class="dropdown-divider">

                                                    </li>


                                                    {{-- DELETE --}}
                                                    <li>

                                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                                            method="POST" class="m-0"
                                                            onsubmit="return confirm('Are you sure you want to delete this category?');">

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
                    {{-- =================================================
                    EMPTY STATE
                ================================================== --}}

                    <div class="text-center py-5 px-3">

                        <div class="mb-3">

                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle"
                                style="
                                width:90px;
                                height:90px;
                            ">

                                <i class="bi bi-folder2-open text-muted" style="font-size:45px;"></i>

                            </div>

                        </div>


                        <h5 class="fw-semibold mb-2">
                            No Categories Found
                        </h5>


                        <p class="text-muted mb-4">
                            You haven't added any category yet.
                        </p>


                        <a href="{{ route('categories.create') }}" class="btn btn-primary">

                            <i class="bi bi-plus-lg me-1"></i>

                            Add Your First Category

                        </a>

                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
