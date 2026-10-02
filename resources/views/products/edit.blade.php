```blade
@extends('layouts.dash-layout')

@section('title', 'Edit Product')

@section('content')

    <div class="container-fluid py-4">

        {{-- ================= HEADER ================= --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">Edit Product</h4>
                <p class="text-muted mb-0">
                    Update product information
                </p>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Back
            </a>

        </div>

        {{-- ================= ERRORS ================= --}}
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


        @php

            $selectedComboProducts = old(
                'combo_product_ids',
                is_array($product->combo_product_ids) ? $product->combo_product_ids : [],
            );

        @endphp


        {{-- ================= CARD ================= --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                    id="productEditForm">

                    @csrf

                    @method('PUT')


                    <div class="row g-4">


                        {{-- ================= CATEGORY ================= --}}
                        <div class="col-md-6">

                            <label for="category_id" class="form-label fw-semibold">
                                Category
                                <span class="text-danger">*</span>
                            </label>


                            <select name="category_id" id="category_id" class="form-select" required>

                                <option value="">
                                    Select Category
                                </option>


                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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

                        {{-- ================= PRODUCT TYPE ================= --}}
                        <div class="col-md-6">

                            <label for="product_type" class="form-label fw-semibold">
                                Product Type
                                <span class="text-danger">*</span>
                            </label>

                            <select name="product_type" id="product_type" class="form-select" required>

                                <option value="single"
                                    {{ old('product_type', $product->product_type) === 'single' ? 'selected' : '' }}>
                                    Single
                                </option>

                                <option value="combo"
                                    {{ old('product_type', $product->product_type) === 'combo' ? 'selected' : '' }}>
                                    Combo
                                </option>

                            </select>

                        </div>

                        {{-- ================= NAME ================= --}}
                        <div class="col-md-6">

                            <label for="name" class="form-label fw-semibold">
                                Product Name
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $product->name) }}" placeholder="Enter product name" required>

                            @error('name')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- ================= SLUG ================= --}}
                        <div class="col-md-6">

                            <label for="slug" class="form-label fw-semibold">
                                Slug
                            </label>

                            <input type="text" id="slug" class="form-control"
                                value="{{ \Illuminate\Support\Str::slug(old('name', $product->name)) }}" readonly>

                        </div>


                        {{-- ================= COMBO PRODUCTS ================= --}}
                        <div class="col-md-12" id="comboProductsWrapper" style="display:none;">
                            <label class="form-label fw-bold mb-1">
                                Select Single Products
                                <span class="text-danger">
                                    *
                                </span>
                            </label>

                            <div class="text-muted small mb-3">
                                Select one or more existing Single
                                Products for this Combo.
                            </div>

                            <div class="combo-products-box">

                                @if (isset($products) && $products->count() > 0)
                                    <div class="row g-3">

                                        @foreach ($products as $comboProduct)
                                            <div class="col-md-6 col-lg-4">

                                                <label class="combo-product-item"
                                                    for="combo_product_{{ $comboProduct->id }}">

                                                    <input type="checkbox" name="combo_product_ids[]"
                                                        value="{{ $comboProduct->id }}"
                                                        id="combo_product_{{ $comboProduct->id }}"
                                                        class="form-check-input combo-product-checkbox"
                                                        {{ in_array($comboProduct->id, $selectedComboProducts) ? 'checked' : '' }}>


                                                    <div class="combo-product-content">

                                                        <strong>
                                                            {{ $comboProduct->name }}
                                                        </strong>


                                                        @if ($comboProduct->price !== null)
                                                            <span>
                                                                ₹{{ number_format($comboProduct->price, 2) }}
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
                                        Please create a Single Product first.

                                    </div>

                                @endif

                            </div>


                            @error('combo_product_ids')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- ================= SHORT DESCRIPTION ================= --}}
                        <div class="col-md-12">

                            <label for="short_description" class="form-label fw-semibold">
                                Short Description
                            </label>

                            <textarea name="short_description" id="short_description" rows="3" class="form-control"
                                placeholder="Enter short description">{{ old('short_description', $product->short_description) }}</textarea>

                        </div>


                        {{-- ================= DESCRIPTION ================= --}}
                        <div class="col-md-12">

                            <label for="description" class="form-label fw-semibold">
                                Description
                            </label>

                            <textarea name="description" id="description" rows="6" class="form-control"
                                placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>

                        </div>

                       
                        {{-- ===================EXISTING IMAGES ===================== --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Existing Images
                            </label>

                            @if ($product->images->count())

                                <div class="row g-3">

                                    @foreach ($product->images as $image)
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6"
                                            id="existing-image-{{ $image->id }}">

                                            <div class="existing-image-card">

                                                <img src="{{ asset($image->image_path) }}"
                                                    alt="{{ $image->alt_text ?? $product->name }}">

                                                {{-- DELETE BUTTON --}}
                                                <button type="button" class="delete-existing-image"
                                                    data-id="{{ $image->id }}" title="Delete Image">

                                                    <i class="bi bi-trash3"></i>

                                                </button>

                                                <div class="existing-image-label">
                                                    Existing
                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>


                                {{-- Hidden delete inputs will be added here --}}
                                <div id="deleteImagesContainer"></div>
                            @else
                                <p class="text-muted">
                                    No existing images.
                                </p>

                            @endif

                        </div>
                        {{-- =================== NEW IMAGES ========================== --}}
                        <div class="col-md-12">

                            <label for="images" class="form-label fw-semibold">
                                Add New Images
                            </label>

                            <input type="file" id="images" class="form-control"
                                accept="image/jpeg,image/png,image/webp">
                            <small class="text-muted d-block mt-2">
                                Select images one by one.
                                JPG, JPEG, PNG or WEBP.
                                Maximum 2MB per image.
                            </small>
                            <div id="imagePreview" class="row g-3 mt-2"></div>
                            <div id="imageInputs"></div>
                            @error('images')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- ================= PRICE ================= --}}
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">
                                Price
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input type="number" name="price" id="price" class="form-control"
                                    value="{{ old('price', $product->price) }}" min="0" step="0.01"
                                    placeholder="0.00" required>

                            </div>

                            @error('price')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- ================= STATUS ================= --}}
                        <div class="col-md-6">

                            <label for="status" class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status" id="status" class="form-select">

                                <option value="Active"
                                    {{ old('status', $product->status) === 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="Inactive"
                                    {{ old('status', $product->status) === 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                        </div>


                        {{-- ================= BUTTONS ================= --}}
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="updateBtn">
                                    <span id="updateText">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Update Product
                                    </span>
                                    <span id="updateLoader" style="display:none;">
                                        <span class="spinner-border spinner-border-sm me-1"></span>
                                        Updating...
                                    </span>

                                </button>

                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <style>
        /* =========================================================
           COMBO PRODUCTS
        ========================================================= */

        .combo-products-box {
            border: 1px solid #dee2e6;
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


        /* =========================================================
           EXISTING IMAGES
        ========================================================= */

        .existing-image-card {
            position: relative;
            height: 150px;
            overflow: hidden;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #ffffff;

        }


        .existing-image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }


        .existing-image-label {
            position: absolute;
            left: 7px;
            bottom: 7px;
            background: rgba(0, 0, 0, 0.65);
            color: #ffffff;
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 11px;

        }

        /* DELETE EXISTING IMAGE */
        .delete-existing-image {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 34px;
            height: 34px;
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


        .delete-existing-image:hover {
            background: #bb2d3b;
            transform: scale(1.08);
        }


        /* =========================================================
           NEW IMAGE PREVIEW
        ========================================================= */

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


@section('scripts')

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {


                /* =====================================================
                   BASIC ELEMENTS
                ===================================================== */

                const productType =
                    document.getElementById(
                        'product_type'
                    );


                const comboWrapper =
                    document.getElementById(
                        'comboProductsWrapper'
                    );


                const nameInput =
                    document.getElementById(
                        'name'
                    );


                const slugInput =
                    document.getElementById(
                        'slug'
                    );


                const form =
                    document.getElementById(
                        'productEditForm'
                    );


                /* =====================================================
                   COMBO TOGGLE
                ===================================================== */

                function toggleComboProducts() {

                    if (!productType) {
                        return;
                    }


                    if (
                        productType.value === 'combo'
                    ) {

                        comboWrapper.style.display =
                            'block';

                    } else {

                        comboWrapper.style.display =
                            'none';

                    }

                }


                if (productType) {

                    productType.addEventListener(
                        'change', toggleComboProducts
                    );


                    toggleComboProducts();

                }


                /* =====================================================
                   SLUG
                ===================================================== */

                if (
                    nameInput &&
                    slugInput
                ) {

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


                            slugInput.value =
                                slug;

                        }
                    );

                }


                /* =====================================================
                   DELETE EXISTING IMAGES
                ===================================================== */

                const deleteImagesContainer =
                    document.getElementById(
                        'deleteImagesContainer'
                    );


                if (
                    deleteImagesContainer
                ) {

                    document.addEventListener(
                        'click',
                        function(event) {

                            const button =
                                event.target.closest(
                                    '.delete-existing-image'
                                );


                            if (!button) {
                                return;
                            }


                            const imageId =
                                button.dataset.id;


                            const imageCard =
                                document.getElementById(
                                    'existing-image-' +
                                    imageId
                                );


                            if (!imageCard) {
                                return;
                            }


                            const alreadyDeleted =
                                deleteImagesContainer.querySelector(
                                    'input[value="' +
                                    imageId +
                                    '"]'
                                );


                            if (alreadyDeleted) {
                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Confirm
                            |--------------------------------------------------------------------------
                            */

                            const confirmed =
                                confirm(
                                    'Are you sure you want to delete this image?'
                                );


                            if (!confirmed) {
                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Hidden Input
                            |--------------------------------------------------------------------------
                            */

                            const hiddenInput =
                                document.createElement(
                                    'input'
                                );


                            hiddenInput.type =
                                'hidden';


                            hiddenInput.name =
                                'delete_images[]';


                            hiddenInput.value =
                                imageId;


                            deleteImagesContainer.appendChild(
                                hiddenInput
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Remove From UI
                            |--------------------------------------------------------------------------
                            */

                            imageCard.remove();

                        }
                    );

                }


                /* =====================================================
                   NEW IMAGE PICKER
                ===================================================== */

                const imageInput =
                    document.getElementById(
                        'images'
                    );


                const imagePreview =
                    document.getElementById(
                        'imagePreview'
                    );


                const imageInputs =
                    document.getElementById(
                        'imageInputs'
                    );


                let selectedFiles = [];


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

                                    const allowedTypes = [

                                        'image/jpeg',

                                        'image/png',

                                        'image/webp'

                                    ];


                                    if (
                                        !allowedTypes.includes(
                                            file.type
                                        )
                                    ) {

                                        alert(
                                            file.name +
                                            ' is not a valid image. Please select JPG, JPEG, PNG or WEBP.'
                                        );

                                        return;

                                    }


                                    if (
                                        file.size >
                                        2 * 1024 * 1024
                                    ) {

                                        alert(
                                            file.name +
                                            ' is larger than 2MB.'
                                        );

                                        return;

                                    }


                                    const duplicate =
                                        selectedFiles.some(
                                            function(
                                                oldFile
                                            ) {

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


                                    if (!duplicate) {

                                        selectedFiles.push(
                                            file
                                        );

                                    }

                                }
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Reset input
                            |--------------------------------------------------------------------------
                            */

                            this.value = '';


                            renderImages();

                        }
                    );

                }


                /* =====================================================
                   RENDER NEW IMAGES
                ===================================================== */

                function renderImages() {

                    if (
                        !imagePreview ||
                        !imageInputs
                    ) {
                        return;
                    }


                    imagePreview.innerHTML =
                        '';


                    imageInputs.innerHTML =
                        '';


                    selectedFiles.forEach(
                        function(
                            file, index
                        ) {

                            const reader =
                                new FileReader();


                            reader.onload =
                                function(
                                    event
                                ) {

                                    const col =
                                        document.createElement(
                                            'div'
                                        );


                                    col.className =
                                        'col-lg-3 col-md-4 col-sm-6 col-6';


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
                            | Hidden File Input
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


                /* =====================================================
                   REMOVE NEW IMAGE
                ===================================================== */

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


                            selectedFiles.splice(
                                index, 1
                            );


                            renderImages();

                        }
                    );

                }


                /* =====================================================
                   FORM VALIDATION
                ===================================================== */

                if (form) {

                    form.addEventListener(
                        'submit',
                        function(event) {

                            let isValid =
                                true;


                            document
                                .querySelectorAll(
                                    '.custom-error'
                                )
                                .forEach(
                                    function(
                                        element
                                    ) {

                                        element.remove();

                                    }
                                );


                            const name =
                                nameInput
                                .value
                                .trim();


                            if (
                                name === ''
                            ) {

                                showError(
                                    nameInput, 'Product name is required.'
                                );


                                isValid =
                                    false;

                            }


                            const category =
                                document.getElementById(
                                    'category_id'
                                ).value;


                            if (
                                category === ''
                            ) {

                                showError(
                                    document.getElementById(
                                        'category_id'
                                    ), 'Please select a category.'
                                );


                                isValid =
                                    false;

                            }


                            const type =
                                productType.value;


                            if (
                                type === ''
                            ) {

                                showError(
                                    productType, 'Please select product type.'
                                );


                                isValid =
                                    false;

                            }


                            if (
                                type === 'combo'
                            ) {

                                const checked =
                                    document.querySelectorAll(
                                        '.combo-product-checkbox:checked'
                                    );


                                if (
                                    checked.length === 0
                                ) {

                                    const wrapper =
                                        document.getElementById(
                                            'comboProductsWrapper'
                                        );


                                    const error =
                                        document.createElement(
                                            'div'
                                        );


                                    error.className =
                                        'text-danger small custom-error mt-2';


                                    error.innerHTML =
                                        'Please select at least one Single Product for Combo.';


                                    wrapper.appendChild(
                                        error
                                    );


                                    isValid =
                                        false;

                                }

                            }


                            const price =
                                document.getElementById(
                                    'price'
                                ).value;


                            if (
                                price === ''
                            ) {

                                showError(
                                    document.getElementById(
                                        'price'
                                    ), 'Price is required.'
                                );


                                isValid =
                                    false;

                            }


                            if (!isValid) {

                                event.preventDefault();


                                const firstError =
                                    document.querySelector(
                                        '.custom-error'
                                    );


                                if (
                                    firstError
                                ) {

                                    firstError.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });

                                }


                                return;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Loading
                            |--------------------------------------------------------------------------
                            */

                            const updateBtn =
                                document.getElementById(
                                    'updateBtn'
                                );


                            const updateText =
                                document.getElementById(
                                    'updateText'
                                );


                            const updateLoader =
                                document.getElementById(
                                    'updateLoader'
                                );


                            updateBtn.disabled =
                                true;


                            updateText.style.display =
                                'none';


                            updateLoader.style.display =
                                'inline';

                        }
                    );

                }


                /* =====================================================
                   SHOW ERROR
                ===================================================== */

                function showError(
                    element, message
                ) {

                    const error =
                        document.createElement(
                            'div'
                        );


                    error.className =
                        'text-danger small custom-error mt-1';


                    error.textContent =
                        message;


                    element.insertAdjacentElement(
                        'afterend', error
                    );

                }

            });
    </script>

@endsection

@endsection
