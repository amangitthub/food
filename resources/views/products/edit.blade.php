@extends('layouts.dash-layout')

@section('title', 'Edit Product')

@section('content')

    <div class="container-fluid py-4">

        {{-- =========================
        PAGE HEADER
    ========================== --}}
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


        {{-- =========================
        VALIDATION ERRORS
    ========================== --}}
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


        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                    id="productEditForm">

                    @csrf

                    @method('PUT')


                    <div class="row g-4">

                        {{-- =========================
                        CATEGORY
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="category_id" class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>

                            <select name="category_id" id="category_id" class="form-select">

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

                        </div>


                        {{-- =========================
                        PRODUCT TYPE
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="product_type" class="form-label">
                                Product Type <span class="text-danger">*</span>
                            </label>

                            <select name="product_type" id="product_type" class="form-select">

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


                        {{-- =========================
                        PRODUCT NAME
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="name" class="form-label">
                                Product Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $product->name) }}" placeholder="Enter product name">

                        </div>


                        {{-- =========================
                        SLUG
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="slug" class="form-label">
                                Slug
                            </label>

                            <input type="text" id="slug" class="form-control"
                                value="{{ old('name', $product->name) ? \Illuminate\Support\Str::slug(old('name', $product->name)) : $product->slug }}"
                                readonly>

                        </div>


                        {{-- =========================
                        COMBO PRODUCTS
                    ========================== --}}
                        @php
                            $selectedComboProducts = old(
                                'combo_product_ids',
                                is_array($product->combo_product_ids) ? $product->combo_product_ids : [],
                            );
                        @endphp

                        <div class="col-md-12" id="comboProductsWrapper">

                            <label for="combo_product_ids" class="form-label">
                                Select Combo Products
                            </label>

                            <select name="combo_product_ids[]" id="combo_product_ids" class="form-select" multiple
                                size="6">

                                @foreach ($products as $comboProduct)
                                    <option value="{{ $comboProduct->id }}"
                                        {{ in_array($comboProduct->id, $selectedComboProducts) ? 'selected' : '' }}>

                                        {{ $comboProduct->name }}

                                    </option>
                                @endforeach

                            </select>

                            <small class="text-muted">
                                Hold CTRL and select multiple products.
                            </small>

                        </div>


                        {{-- =========================
                        SHORT DESCRIPTION
                    ========================== --}}
                        <div class="col-md-12">

                            <label for="short_description" class="form-label">
                                Short Description
                            </label>

                            <textarea name="short_description" id="short_description" rows="3" class="form-control"
                                placeholder="Enter short description">{{ old('short_description', $product->short_description) }}</textarea>

                        </div>


                        {{-- =========================
                        DESCRIPTION
                    ========================== --}}
                        <div class="col-md-12">

                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea name="description" id="description" rows="6" class="form-control"
                                placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>

                        </div>


                        {{-- =========================
                        EXISTING IMAGES
                    ========================== --}}
                        <div class="col-md-12">

                            <label class="form-label">
                                Existing Images
                            </label>

                            @if ($product->images->count())

                                <div class="row g-3">

                                    @foreach ($product->images as $image)
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">

                                            <div class="border rounded p-2 bg-white">

                                                <img src="{{ asset($image->image_path) }}"
                                                    alt="{{ $image->alt_text ?? $product->name }}"
                                                    class="img-fluid rounded"
                                                    style="width:100%;height:130px;object-fit:cover;"
                                                    onerror="this.style.display='none';">

                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <p class="text-muted">
                                    No existing images.
                                </p>

                            @endif

                        </div>


                        {{-- =========================
                        NEW IMAGES
                    ========================== --}}
                        <div class="col-md-12">

                            <label for="images" class="form-label">
                                Add New Images
                            </label>

                            <input type="file" name="images[]" id="images" class="form-control" multiple
                                accept=".jpg,.jpeg,.png,.webp">

                            <small class="text-muted">
                                JPG, JPEG, PNG or WEBP. Maximum 2MB per image.
                            </small>

                            <div id="imagePreview" class="row g-3 mt-2">
                            </div>

                        </div>


                        {{-- =========================
                        PRICE
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="price" class="form-label">
                                Price <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input type="number" name="price" id="price" class="form-control"
                                    value="{{ old('price', $product->price) }}" min="0" step="0.01"
                                    placeholder="0.00">

                            </div>

                        </div>


                        {{-- =========================
                        STATUS
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="status" class="form-label">
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


                        {{-- =========================
                        BUTTONS
                    ========================== --}}
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

@endsection


@push('js')
    <script>
        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | Generate Slug
            |--------------------------------------------------------------------------
            */

            $('#name').on('keyup change', function() {

                let value = $(this).val();

                let slug = value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');

                $('#slug').val(slug);

            });


            /*
            |--------------------------------------------------------------------------
            | Toggle Combo Products
            |--------------------------------------------------------------------------
            */

            function toggleComboProducts() {

                let productType = $('#product_type').val();

                if (productType === 'combo') {

                    $('#comboProductsWrapper').slideDown();

                } else {

                    $('#comboProductsWrapper').slideUp();

                    $('#combo_product_ids').val([]);

                }

            }


            $('#product_type').on('change', toggleComboProducts);

            toggleComboProducts();


            /*
            |--------------------------------------------------------------------------
            | Image Preview
            |--------------------------------------------------------------------------
            */

            $('#images').on('change', function() {

                const preview = $('#imagePreview');

                preview.html('');

                const files = this.files;

                if (!files.length) {
                    return;
                }


                $.each(files, function(index, file) {

                    const allowedTypes = [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ];


                    if (!allowedTypes.includes(file.type)) {

                        alert(
                            file.name +
                            ' is not a valid image. Please select JPG, JPEG, PNG or WEBP.'
                        );

                        return;
                    }


                    if (file.size > 2 * 1024 * 1024) {

                        alert(
                            file.name +
                            ' is larger than 2MB.'
                        );

                        return;
                    }


                    const reader = new FileReader();


                    reader.onload = function(e) {

                        preview.append(`

                    <div class="col-md-3 col-sm-4 col-6">

                        <div class="border rounded p-2 bg-white">

                            <img src="${e.target.result}"
                                 class="img-fluid rounded"
                                 style="width:100%;height:150px;object-fit:cover;">

                            <small class="d-block text-muted mt-2 text-truncate"
                                   title="${file.name}">

                                ${file.name}

                            </small>

                        </div>

                    </div>

                `);

                    };


                    reader.readAsDataURL(file);

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            $('#productEditForm').on('submit', function(e) {

                let isValid = true;

                $('.custom-error').remove();


                /*
                | Product Name
                */

                let name = $('#name').val().trim();

                if (name === '') {

                    $('#name').after(
                        '<div class="text-danger small custom-error mt-1">Product name is required.</div>'
                    );

                    isValid = false;

                }


                /*
                | Category
                */

                let category = $('#category_id').val();

                if (category === '') {

                    $('#category_id').after(
                        '<div class="text-danger small custom-error mt-1">Please select a category.</div>'
                    );

                    isValid = false;

                }


                /*
                | Product Type
                */

                let productType = $('#product_type').val();

                if (productType === '') {

                    $('#product_type').after(
                        '<div class="text-danger small custom-error mt-1">Please select product type.</div>'
                    );

                    isValid = false;

                }


                /*
                | Combo Products
                */

                if (productType === 'combo') {

                    let comboProducts = $('#combo_product_ids').val();

                    if (!comboProducts || comboProducts.length === 0) {

                        $('#combo_product_ids').after(
                            '<div class="text-danger small custom-error mt-1">Please select at least one product for combo.</div>'
                        );

                        isValid = false;

                    }

                }


                /*
                | Price
                */

                let price = $('#price').val();

                if (price === '') {

                    $('#price').closest('.input-group').after(
                        '<div class="text-danger small custom-error mt-1">Price is required.</div>'
                    );

                    isValid = false;

                }


                /*
                | Stop Submit
                */

                if (!isValid) {

                    e.preventDefault();

                    const firstError = $('.custom-error').first();

                    if (firstError.length) {

                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 150
                        }, 400);

                    }

                    return false;

                }


                /*
                | Loading
                */

                $('#updateBtn').prop('disabled', true);

                $('#updateText').hide();

                $('#updateLoader').show();

            });

        });
    </script>
@endpush
