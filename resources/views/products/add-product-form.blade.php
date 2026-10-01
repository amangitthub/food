```blade
@extends('layouts.dash-layout')

@section('title', 'Add Product')

@section('content')

<div class="container-fluid py-4">

    {{-- ================= PAGE HEADER ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-1">Add Product</h3>
            <p class="text-muted mb-0">
                Create a new product with images.
            </p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>

    </div>


    {{-- ================= VALIDATION ERRORS ================= --}}
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


    {{-- ================= FORM ================= --}}
    <form
        action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        id="productForm"
    >

        @csrf

        <div class="row g-4">

            {{-- ================= LEFT COLUMN ================= --}}
            <div class="col-lg-8">

                {{-- ================= PRODUCT INFORMATION ================= --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-box-seam me-2"></i>
                            Product Information
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            {{-- CATEGORY --}}
                            <div class="col-md-6">

                                <label for="category_id" class="form-label">
                                    Category
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="category_id"
                                    id="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror"
                                >
                                    <option value="">
                                        Select Category
                                    </option>

                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- PRODUCT TYPE --}}
                            <div class="col-md-6">

                                <label for="product_type" class="form-label">
                                    Product Type
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="product_type"
                                    id="product_type"
                                    class="form-select @error('product_type') is-invalid @enderror"
                                >
                                    <option
                                        value="single"
                                        {{ old('product_type', 'single') == 'single' ? 'selected' : '' }}
                                    >
                                        Single
                                    </option>

                                    <option
                                        value="combo"
                                        {{ old('product_type') == 'combo' ? 'selected' : '' }}
                                    >
                                        Combo
                                    </option>
                                </select>

                                @error('product_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- PRODUCT NAME --}}
                            <div class="col-md-6">

                                <label for="name" class="form-label">
                                    Product Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Enter product name"
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- SLUG --}}
                            <div class="col-md-6">

                                <label for="slug" class="form-label">
                                    Slug
                                </label>

                                <input
                                    type="text"
                                    id="slug"
                                    class="form-control"
                                    value="{{ old('slug') }}"
                                    placeholder="product-slug"
                                    readonly
                                >

                                <small class="text-muted">
                                    Slug will be generated automatically.
                                </small>

                            </div>


                            {{-- COMBO PRODUCTS --}}
                            <div
                                class="col-12"
                                id="comboProductsWrapper"
                                style="{{ old('product_type') == 'combo' ? '' : 'display:none;' }}"
                            >

                                <label for="combo_product_ids" class="form-label">
                                    Select Products for Combo
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="combo_product_ids[]"
                                    id="combo_product_ids"
                                    class="form-select @error('combo_product_ids') is-invalid @enderror"
                                    multiple
                                    size="6"
                                >

                                    @foreach($products as $product)
                                        <option
                                            value="{{ $product->id }}"
                                            {{ in_array($product->id, old('combo_product_ids', [])) ? 'selected' : '' }}
                                        >
                                            {{ $product->name }}
                                        </option>
                                    @endforeach

                                </select>

                                <small class="text-muted">
                                    Hold Ctrl and select multiple products.
                                </small>

                                @error('combo_product_ids')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- SHORT DESCRIPTION --}}
                            <div class="col-12">

                                <label for="short_description" class="form-label">
                                    Short Description
                                </label>

                                <textarea
                                    name="short_description"
                                    id="short_description"
                                    rows="3"
                                    class="form-control"
                                    placeholder="Enter short description"
                                >{{ old('short_description') }}</textarea>

                            </div>


                            {{-- DESCRIPTION --}}
                            <div class="col-12">

                                <label for="description" class="form-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    id="description"
                                    rows="6"
                                    class="form-control"
                                    placeholder="Enter product description"
                                >{{ old('description') }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================= PRODUCT IMAGES ================= --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-images me-2"></i>
                            Product Images
                        </h5>
                    </div>

                    <div class="card-body">

                        <label for="images" class="form-label">
                            Select Product Images
                        </label>

                        <input
                            type="file"
                            name="images[]"
                            id="images"
                            class="form-control @error('images') is-invalid @enderror"
                            multiple
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="text-muted d-block mt-2">
                            You can select multiple images.
                            Maximum 2MB per image.
                            Allowed: JPG, JPEG, PNG, WEBP.
                        </small>

                        @error('images')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                        {{-- IMAGE PREVIEW --}}
                        <div
                            id="imagePreview"
                            class="row g-3 mt-3"
                        ></div>

                    </div>

                </div>

            </div>


            {{-- ================= RIGHT COLUMN ================= --}}
            <div class="col-lg-4">

                {{-- ================= PRODUCT SETTINGS ================= --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-gear me-2"></i>
                            Product Settings
                        </h5>
                    </div>

                    <div class="card-body">

                        {{-- PRICE --}}
                        <div class="mb-3">

                            <label for="price" class="form-label">
                                Price
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}"
                                    placeholder="0.00"
                                    min="0"
                                    step="0.01"
                                >

                            </div>

                            @error('price')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- STATUS --}}
                        <div class="mb-3">

                            <label for="status" class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                            >

                                <option
                                    value="Active"
                                    {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="Inactive"
                                    {{ old('status') == 'Inactive' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                {{-- ================= SUBMIT ================= --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            id="submitBtn"
                        >

                            <span id="submitText">
                                <i class="bi bi-check-circle me-1"></i>
                                Save Product
                            </span>

                            <span
                                id="submitLoader"
                                style="display:none;"
                            >
                                <span
                                    class="spinner-border spinner-border-sm me-1"
                                    role="status"
                                ></span>

                                Saving...
                            </span>

                        </button>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-outline-secondary w-100 mt-2"
                        >
                            Cancel
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection


@push('js')

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Generate Slug
    |--------------------------------------------------------------------------
    */

    $('#name').on('keyup change', function () {

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
    | Show / Hide Combo Products
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


    $('#product_type').on('change', function () {

        toggleComboProducts();

    });


    toggleComboProducts();


    /*
    |--------------------------------------------------------------------------
    | Multiple Image Preview
    |--------------------------------------------------------------------------
    */

    $('#images').on('change', function () {

        const preview = $('#imagePreview');

        preview.html('');

        const files = this.files;

        if (!files.length) {
            return;
        }


        $.each(files, function (index, file) {

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            // File type
            if (!allowedTypes.includes(file.type)) {

                alert(
                    file.name +
                    ' is not a valid image. Please select JPG, JPEG, PNG or WEBP.'
                );

                return;
            }


            // File size
            if (file.size > 2 * 1024 * 1024) {

                alert(
                    file.name +
                    ' is larger than 2MB.'
                );

                return;
            }


            // Preview
            const reader = new FileReader();

            reader.onload = function (e) {

                preview.append(`

                    <div class="col-md-3 col-sm-4 col-6">

                        <div class="border rounded p-2 bg-white">

                            <img
                                src="${e.target.result}"
                                class="img-fluid rounded"
                                style="
                                    width:100%;
                                    height:150px;
                                    object-fit:cover;
                                "
                            >

                            <small
                                class="d-block text-muted mt-2 text-truncate"
                                title="${file.name}"
                            >
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
    | Form Validation
    |--------------------------------------------------------------------------
    */

    $('#productForm').on('submit', function (e) {

        let isValid = true;

        $('.custom-error').remove();


        // Product Name
        let name = $('#name').val().trim();

        if (name === '') {

            $('#name').after(
                '<div class="text-danger small custom-error mt-1">Product name is required.</div>'
            );

            isValid = false;
        }


        // Category
        let category = $('#category_id').val();

        if (category === '') {

            $('#category_id').after(
                '<div class="text-danger small custom-error mt-1">Please select a category.</div>'
            );

            isValid = false;
        }


        // Product Type
        let productType = $('#product_type').val();

        if (productType === '') {

            $('#product_type').after(
                '<div class="text-danger small custom-error mt-1">Please select product type.</div>'
            );

            isValid = false;
        }


        // Combo Products
        if (productType === 'combo') {

            let comboProducts = $('#combo_product_ids').val();

            if (!comboProducts || comboProducts.length === 0) {

                $('#combo_product_ids').after(
                    '<div class="text-danger small custom-error mt-1">Please select at least one product for combo.</div>'
                );

                isValid = false;
            }
        }


        // Price
        let price = $('#price').val();

        if (price === '') {

            $('#price')
                .closest('.input-group')
                .after(
                    '<div class="text-danger small custom-error mt-1">Price is required.</div>'
                );

            isValid = false;
        }


        // Stop submit if invalid
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


        // Submit loader
        $('#submitBtn').prop('disabled', true);

        $('#submitText').hide();

        $('#submitLoader').show();

    });

});

</script>

@endpush
