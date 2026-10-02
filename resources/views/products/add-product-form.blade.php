```blade
@extends('layouts.dash-layout')

@section('title', 'Add Product')
<style>
    /* =====================================================================
   Add Product page - Black and rose gold
   Uses the variables from admin.css (--lp-ink, --lp-rose, --lp-page ...)
   Paste at the END of admin.css and delete the inline <style> block
   from the Add Product blade file.
   ===================================================================== */

    /* ---------- Bootstrap cards used on this page ---------- */
    .card {
        background: var(--lp-card);
        border: 1px solid var(--lp-line) !important;
        border-radius: 6px;
        box-shadow: none !important;
    }

    .card h5 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 400;
        color: var(--lp-text);
        padding-bottom: .7rem;
        border-bottom: 1px solid var(--lp-line);
    }

    .container-fluid h3 {
        font-size: 2.1rem;
        color: var(--lp-text);
    }

    /* ---------- Labels, helper text, required star ---------- */
    .form-label,
    .form-label.fw-semibold,
    .form-label.fw-bold {
        font-size: .88rem;
        font-weight: 400 !important;
        color: var(--lp-text);
    }

    .text-muted {
        color: var(--lp-muted) !important;
    }

    .text-danger {
        color: var(--lp-danger) !important;
    }

    /* ---------- File input ---------- */
    input[type="file"].form-control::file-selector-button {
        background: var(--lp-rose-soft);
        color: var(--lp-ink);
        border: none;
        border-right: 1px solid var(--lp-line);
        padding: .45rem .9rem;
        margin-right: .8rem;
        font-family: inherit;
    }

    input[type="file"].form-control:hover::file-selector-button {
        background: var(--lp-rose);
    }

    textarea.form-control {
        line-height: 1.6;
    }

    input[readonly].form-control {
        background: var(--lp-page);
        color: var(--lp-muted);
    }

    /* ---------- Checkbox ---------- */
    .form-check-input {
        border-color: var(--lp-muted);
    }

    .form-check-input:checked {
        background-color: var(--lp-ink);
        border-color: var(--lp-ink);
    }

    .form-check-input:focus {
        border-color: var(--lp-rose);
        box-shadow: 0 0 0 .2rem rgba(217, 165, 160, .3);
    }

    /* ---------- Alerts ---------- */
    .alert {
        border-radius: 6px;
        font-size: .9rem;
    }

    .alert-danger {
        background: var(--lp-danger-bg);
        border-color: #EFC9C4;
        color: var(--lp-danger);
    }

    .alert-warning {
        background: var(--lp-warning-bg);
        border-color: #EBD6A8;
        color: var(--lp-warning);
    }

    .alert-success {
        background: var(--lp-success-bg);
        border-color: #C5DECC;
        color: var(--lp-success);
    }

    .alert-light {
        background: var(--lp-page);
        border-color: var(--lp-line);
        color: var(--lp-text);
    }

    .alert-light strong {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.15rem;
        font-weight: 500;
    }

    /* ---------- Buttons (Cancel / Back) ---------- */
    .btn-light {
        background: transparent;
        border: 1px solid var(--lp-line);
        color: var(--lp-text);
    }

    .btn-light:hover {
        background: var(--lp-rose-soft);
        border-color: var(--lp-rose);
        color: var(--lp-text);
    }

    /* =====================================================================
   COMBO PRODUCTS
   ===================================================================== */
    .combo-products-box {
        border: 1px solid var(--lp-line);
        border-radius: 6px;
        padding: 18px;
        background: var(--lp-page);
    }

    .combo-product-item {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        min-height: 65px;
        padding: 12px 15px;
        background: var(--lp-card);
        border: 1px solid var(--lp-line);
        border-radius: 4px;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease;
    }

    .combo-product-item:hover {
        border-color: var(--lp-rose);
        background: var(--lp-card);
    }

    .combo-product-item:has(.combo-product-checkbox:checked) {
        border-color: var(--lp-rose-deep);
        background: var(--lp-rose-soft);
    }

    .combo-product-checkbox {
        width: 19px;
        height: 19px;
        flex-shrink: 0;
        cursor: pointer;
    }

    .combo-product-content {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .combo-product-content strong {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.1rem;
        font-weight: 500;
        line-height: 1.2;
        color: var(--lp-text);
    }

    .combo-product-content span {
        font-size: .82rem;
        color: var(--lp-muted);
    }

    /* =====================================================================
   IMAGE PREVIEW
   ===================================================================== */
    .image-preview-card {
        position: relative;
        width: 100%;
        height: 160px;
        overflow: hidden;
        border-radius: 6px;
        border: 1px solid var(--lp-line);
        background: var(--lp-page);
    }

    .image-preview-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Delete button */
    .remove-image-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 50%;
        background: var(--lp-ink);
        color: var(--lp-rose);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: background .2s ease, color .2s ease;
    }

    .remove-image-btn:hover {
        background: var(--lp-rose);
        color: var(--lp-ink);
    }

    /* Image number */
    .image-number {
        position: absolute;
        left: 8px;
        bottom: 8px;
        min-width: 26px;
        height: 26px;
        padding: 0 8px;
        border-radius: 20px;
        background: var(--lp-ink);
        color: var(--lp-rose);
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: .95rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@section('content')

    <div class="container-fluid py-4">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-1">Add Product</h3>

                <p class="text-muted mb-0">
                    Create a new single or combo product
                </p>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Back
            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ========================================================= --}}

        @if ($errors->any())

            <div class="alert alert-danger">

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

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- FORM --}}
        {{-- ========================================================= --}}

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">

            @csrf


            <div class="row g-4">


                {{-- ===================================================== --}}
                {{-- LEFT SIDE --}}
                {{-- ===================================================== --}}

                <div class="col-lg-8">

                    <div class="card shadow-sm border-0">

                        <div class="card-body p-4">

                            <h5 class="mb-4">
                                Product Information
                            </h5>


                            {{-- ================================================= --}}
                            {{-- CATEGORY --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Category

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select name="category_id" class="form-select" required>

                                    <option value="">
                                        Select Category
                                    </option>


                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>


                                @error('category_id')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- ================================================= --}}
                            {{-- PRODUCT TYPE --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Product Type

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select name="product_type" id="product_type" class="form-select" required>

                                    <option value="">
                                        Select Product Type
                                    </option>


                                    <option value="single"
                                        {{ old('product_type', 'single') == 'single' ? 'selected' : '' }}>
                                        Single
                                    </option>


                                    <option value="combo" {{ old('product_type') == 'combo' ? 'selected' : '' }}>
                                        Combo
                                    </option>

                                </select>


                                <small class="text-muted">

                                    Single = Normal individual product

                                    <br>

                                    Combo = Multiple existing Single Products
                                    combined into one product

                                </small>


                                @error('product_type')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- ================================================= --}}
                            {{-- COMBO PRODUCTS --}}
                            {{-- ================================================= --}}

                            <div id="comboProductsWrapper" class="mb-4" style="display:none;">

                                <label class="form-label fw-bold mb-1">

                                    Select Single Products

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <div class="text-muted small mb-3">

                                    Select one or more existing Single Products
                                    for this Combo.

                                </div>


                                <div class="combo-products-box">

                                    @if (isset($products) && $products->count() > 0)

                                        <div class="row g-3">

                                            @foreach ($products as $product)
                                                <div class="col-md-6">

                                                    <label class="combo-product-item"
                                                        for="combo_product_{{ $product->id }}">

                                                        <input type="checkbox" name="combo_product_ids[]"
                                                            value="{{ $product->id }}"
                                                            id="combo_product_{{ $product->id }}"
                                                            class="form-check-input combo-product-checkbox"
                                                            {{ in_array($product->id, old('combo_product_ids', [])) ? 'checked' : '' }}>


                                                        <div class="combo-product-content">

                                                            <strong>
                                                                {{ $product->name }}
                                                            </strong>


                                                            @if ($product->price !== null)
                                                                <span>
                                                                    ₹{{ number_format($product->price, 2) }}
                                                                </span>
                                                            @endif

                                                        </div>

                                                    </label>

                                                </div>
                                            @endforeach

                                        </div>
                                    @else
                                        <div class="alert alert-warning mb-0">

                                            <i class="bi bi-exclamation-triangle me-2"></i>

                                            No Single Products available.

                                            Please create at least one
                                            <strong>Single Product</strong>
                                            first.

                                        </div>

                                    @endif

                                </div>


                                @error('combo_product_ids')
                                    <div class="text-danger small mt-2">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>


                            {{-- ================================================= --}}
                            {{-- PRODUCT NAME --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Product Name

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" placeholder="Enter product name" required>


                                @error('name')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- ================================================= --}}
                            {{-- SLUG --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Product Slug
                                </label>


                                <input type="text" name="slug" id="slug" class="form-control"
                                    value="{{ old('slug') }}" readonly>


                                <small class="text-muted">
                                    Slug will be generated automatically.
                                </small>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PRICE --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Price

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                    step="0.01" min="0" placeholder="Enter price" required>


                                @error('price')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- ================================================= --}}
                            {{-- SHORT DESCRIPTION --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Short Description
                                </label>


                                <textarea name="short_description" class="form-control" rows="3" placeholder="Enter short description">{{ old('short_description') }}</textarea>

                            </div>


                            {{-- ================================================= --}}
                            {{-- DESCRIPTION --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Description
                                </label>


                                <textarea name="description" class="form-control" rows="6" placeholder="Enter product description">{{ old('description') }}</textarea>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PRODUCT IMAGES --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Product Images
                                </label>


                                <input type="file" id="images" class="form-control" accept="image/*">


                                <small class="text-muted d-block mt-2">

                                    Select images one by one.
                                    You do not need to press Ctrl.

                                </small>


                                {{-- IMAGE PREVIEW --}}

                                <div id="imagePreview" class="row g-3 mt-2"></div>


                                {{-- REAL FILE INPUTS --}}

                                <div id="imageInputs"></div>


                                @error('images')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- ================================================= --}}
                            {{-- BUTTONS --}}
                            {{-- ================================================= --}}

                            <div class="d-flex gap-2 mt-4">

                                <button type="submit" class="btn btn-primary">

                                    <i class="bi bi-check-lg me-1"></i>

                                    Save Product

                                </button>


                                <a href="{{ route('products.index') }}" class="btn btn-light">
                                    Cancel
                                </a>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- RIGHT SIDE --}}
                {{-- ===================================================== --}}

                <div class="col-lg-4">

                    <div class="card shadow-sm border-0">

                        <div class="card-body p-4">

                            <h5 class="mb-3">
                                Product Details
                            </h5>


                            {{-- PRODUCT TYPE INFO --}}

                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Product Type
                                </label>


                                <div id="productTypeInfo" class="alert alert-light border mb-0">

                                    <strong>
                                        Single
                                    </strong>


                                    <div class="small text-muted mt-1">

                                        Normal individual product.

                                    </div>

                                </div>

                            </div>


                            {{-- STATUS --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Status
                                </label>


                                <select name="status" class="form-select">

                                    <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>
                                        Active
                                    </option>


                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>


    {{-- =============================================================== --}}
    {{-- CSS --}}
    {{-- =============================================================== --}}

    <style>
        /* ================================================================
                   COMBO PRODUCTS
                   ================================================================ */

        .combo-products-box {

            border: 1px solid #dee2e6;

            border-radius: 10px;

            padding: 18px;

            background: #f8f9fa;

        }


        .combo-product-item {

            display: flex;

            align-items: center;

            gap: 12px;

            width: 100%;

            min-height: 65px;

            padding: 12px 15px;

            background: #ffffff;

            border: 1px solid #dee2e6;

            border-radius: 8px;

            cursor: pointer;

            transition: all 0.2s ease;

        }


        .combo-product-item:hover {

            border-color: #0d6efd;

            background: #f5f9ff;

        }


        .combo-product-checkbox {

            width: 19px;

            height: 19px;

            flex-shrink: 0;

            cursor: pointer;

        }


        .combo-product-item:has(.combo-product-checkbox:checked) {

            border-color: #0d6efd;

            background: #eaf3ff;

        }


        .combo-product-content {

            display: flex;

            flex-direction: column;

            gap: 3px;

        }


        .combo-product-content strong {

            font-size: 14px;

        }


        .combo-product-content span {

            font-size: 13px;

            color: #6c757d;

        }


        /* ================================================================
                   IMAGE PREVIEW
                   ================================================================ */

        .image-preview-card {

            position: relative;

            width: 100%;

            height: 160px;

            overflow: hidden;

            border-radius: 10px;

            border: 1px solid #dee2e6;

            background: #f8f9fa;

        }


        .image-preview-card img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

        }


        /* ================================================================
                   IMAGE DELETE BUTTON
                   ================================================================ */

        .remove-image-btn {

            position: absolute;

            top: 8px;

            right: 8px;

            width: 32px;

            height: 32px;

            border: none;

            border-radius: 50%;

            background: #dc3545;

            color: #ffffff;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            z-index: 10;

            transition: all 0.2s ease;

        }


        .remove-image-btn:hover {

            background: #bb2d3b;

            transform: scale(1.08);

        }


        /* ================================================================
                   IMAGE NUMBER
                   ================================================================ */

        .image-number {

            position: absolute;

            left: 8px;

            bottom: 8px;

            min-width: 26px;

            height: 26px;

            padding: 0 7px;

            border-radius: 20px;

            background: rgba(0, 0, 0, 0.7);

            color: #ffffff;

            font-size: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

        }
    </style>


    {{-- =============================================================== --}}
    {{-- JAVASCRIPT --}}
    {{-- =============================================================== --}}

@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            /* ============================================================
               PRODUCT TYPE
               ============================================================ */

            const productType =
                document.getElementById('product_type');

            const comboWrapper =
                document.getElementById('comboProductsWrapper');

            const productTypeInfo =
                document.getElementById('productTypeInfo');


            function updateProductType() {

                if (!productType) {
                    return;
                }


                if (productType.value === 'combo') {

                    comboWrapper.style.display = 'block';


                    productTypeInfo.innerHTML = `

                <strong>
                    Combo
                </strong>

                <div class="small text-muted mt-1">

                    Multiple existing Single Products
                    combined into one product.

                </div>

            `;

                } else {

                    comboWrapper.style.display = 'none';


                    productTypeInfo.innerHTML = `

                <strong>
                    Single
                </strong>

                <div class="small text-muted mt-1">

                    Normal individual product.

                </div>

            `;

                }

            }


            if (productType) {

                productType.addEventListener(
                    'change', updateProductType
                );


                updateProductType();

            }


            /* ============================================================
               SLUG
               ============================================================ */

            const nameInput =
                document.getElementById('name');

            const slugInput =
                document.getElementById('slug');


            if (nameInput && slugInput) {

                nameInput.addEventListener(
                    'input',
                    function() {

                        let slug =
                            this.value
                            .toLowerCase()
                            .trim()
                            .replace(
                                /[^a-z0-9\s-]/g, ''
                            )
                            .replace(
                                /\s+/g, '-'
                            )
                            .replace(
                                /-+/g, '-'
                            );


                        slugInput.value = slug;

                    }
                );

            }


            /* ============================================================
               IMAGE ELEMENTS
               ============================================================ */

            const imageInput =
                document.getElementById('images');

            const imagePreview =
                document.getElementById('imagePreview');

            const imageInputs =
                document.getElementById('imageInputs');


            /*
            |--------------------------------------------------------------------------
            | ALL SELECTED FILES
            |--------------------------------------------------------------------------
            */

            let selectedFiles = [];


            /* ============================================================
               ADD IMAGES
               ============================================================ */

            if (imageInput) {

                imageInput.addEventListener(
                    'change',
                    function() {


                        const files =
                            Array.from(
                                this.files
                            );


                        files.forEach(
                            function(file) {


                                /*
                                |--------------------------------------------------------------------------
                                | IMAGE ONLY
                                |--------------------------------------------------------------------------
                                */

                                if (
                                    !file.type.startsWith(
                                        'image/'
                                    )
                                ) {

                                    return;

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | DUPLICATE CHECK
                                |--------------------------------------------------------------------------
                                */

                                const duplicate =
                                    selectedFiles.some(
                                        function(oldFile) {

                                            return (

                                                oldFile.name ===
                                                file.name

                                                &&

                                                oldFile.size ===
                                                file.size

                                                &&

                                                oldFile.lastModified ===
                                                file.lastModified

                                            );

                                        }
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | ADD FILE
                                |--------------------------------------------------------------------------
                                */

                                if (!duplicate) {

                                    selectedFiles.push(
                                        file
                                    );

                                }

                            }
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | RESET FILE INPUT
                        |--------------------------------------------------------------------------
                        */

                        this.value = '';


                        /*
                        |--------------------------------------------------------------------------
                        | RENDER
                        |--------------------------------------------------------------------------
                        */

                        renderImages();

                    }
                );

            }


            /* ============================================================
               RENDER IMAGE PREVIEW
               ============================================================ */

            function renderImages() {


                imagePreview.innerHTML = '';

                imageInputs.innerHTML = '';


                selectedFiles.forEach(
                    function(file, index) {


                        /*
                        |--------------------------------------------------------------------------
                        | IMAGE PREVIEW
                        |--------------------------------------------------------------------------
                        */

                        const reader =
                            new FileReader();


                        reader.onload =
                            function(event) {


                                const col =
                                    document.createElement(
                                        'div'
                                    );


                                col.className =
                                    'col-6 col-md-4 col-lg-3';


                                col.innerHTML = `

                            <div class="image-preview-card">

                                <img
                                    src="${event.target.result}"
                                    alt="${file.name}"
                                >


                                <button
                                    type="button"
                                    class="remove-image-btn"
                                    data-index="${index}"
                                    title="Remove Image"
                                >

                                    <i class="bi bi-x-lg"></i>

                                </button>


                                <div class="image-number">

                                    ${index + 1}

                                </div>

                            </div>

                        `;


                                imagePreview.appendChild(
                                    col
                                );

                            };


                        reader.readAsDataURL(
                            file
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | CREATE HIDDEN FILE INPUT
                        |--------------------------------------------------------------------------
                        */

                        const dataTransfer =
                            new DataTransfer();


                        dataTransfer.items.add(
                            file
                        );


                        const hiddenInput =
                            document.createElement(
                                'input'
                            );


                        hiddenInput.type =
                            'file';


                        hiddenInput.name =
                            'images[]';


                        hiddenInput.hidden =
                            true;


                        hiddenInput.files =
                            dataTransfer.files;


                        imageInputs.appendChild(
                            hiddenInput
                        );

                    }
                );

            }


            /* ============================================================
               DELETE IMAGE
               ============================================================ */

            if (imagePreview) {

                imagePreview.addEventListener(
                    'click',
                    function(event) {


                        const button =
                            event.target.closest(
                                '.remove-image-btn'
                            );


                        if (!button) {

                            return;

                        }


                        const index =
                            Number(
                                button.dataset.index
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | REMOVE FROM ARRAY
                        |--------------------------------------------------------------------------
                        */

                        selectedFiles.splice(
                            index, 1
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | RENDER AGAIN
                        |--------------------------------------------------------------------------
                        */

                        renderImages();

                    }
                );

            }


            /* ============================================================
               FORM VALIDATION
               ============================================================ */

            const form =
                document.getElementById(
                    'productForm'
                );


            if (form) {

                form.addEventListener(
                    'submit',
                    function(event) {


                        if (
                            productType &&
                            productType.value === 'combo'
                        ) {


                            const checked =
                                document.querySelectorAll(
                                    '.combo-product-checkbox:checked'
                                );


                            if (
                                checked.length === 0
                            ) {


                                event.preventDefault();


                                alert(
                                    'Please select at least one Single Product for Combo.'
                                );


                                comboWrapper.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });


                                return;

                            }

                        }

                    }
                );

            }

        });
    </script>

@endsection

@endsection
