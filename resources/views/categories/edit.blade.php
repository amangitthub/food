@extends('layouts.dash-layout')

@section('title', 'Edit Category')

@section('content')

    <div class="container-fluid py-4">

        {{-- =========================
        PAGE HEADER
    ========================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="mb-1">
                    Edit Category
                </h4>

                <p class="text-muted mb-0">
                    Update category information
                </p>

            </div>


            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

        </div>


        {{-- =========================
        VALIDATION ERRORS
    ========================== --}}
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


        {{-- =========================
        SUCCESS MESSAGE
    ========================== --}}
        @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
        @endif


        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
                    id="categoryEditForm">

                    @csrf

                    @method('PUT')


                    <div class="row g-4">


                        {{-- =========================
                        CATEGORY NAME
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="name" class="form-label">

                                Category Name

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $category->name) }}" placeholder="Enter category name">

                        </div>


                        {{-- =========================
                        SLUG
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="slug" class="form-label">

                                Slug

                            </label>


                            <input type="text" id="slug" class="form-control"
                                value="{{ old('name', $category->name) ? \Illuminate\Support\Str::slug(old('name', $category->name)) : $category->slug }}"
                                readonly>


                            <small class="text-muted">

                                Slug will be generated automatically.

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
                                placeholder="Enter short description">{{ old('short_description', $category->short_description) }}</textarea>

                        </div>


                        {{-- =========================
                        DESCRIPTION
                    ========================== --}}
                        <div class="col-md-12">

                            <label for="description" class="form-label">

                                Description

                            </label>


                            <textarea name="description" id="description" rows="6" class="form-control"
                                placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>

                        </div>


                        {{-- =========================
                        EXISTING IMAGE
                    ========================== --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Current Image
                            </label>


                            @if ($category->image)
                                <div class="border rounded p-2 bg-white">

                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                        class="img-fluid rounded" style="width:100%; max-height:250px; object-fit:cover;"
                                        onerror="this.style.display='none';">

                                </div>
                            @else
                                <div class="border rounded d-flex align-items-center justify-content-center"
                                    style="height:250px;">

                                    <div class="text-center">

                                        <i class="bi bi-image fs-1 text-muted"></i>

                                        <p class="text-muted mb-0 mt-2">
                                            No image available
                                        </p>

                                    </div>

                                </div>
                            @endif

                        </div>


                        {{-- =========================
                        NEW IMAGE
                    ========================== --}}
                        <div class="col-md-6">

                            <label for="image" class="form-label">

                                Change Image

                            </label>


                            <input type="file" name="image" id="image" class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">


                            <small class="text-muted d-block mt-1">

                                JPG, JPEG, PNG or WEBP.
                                Maximum 2MB.

                            </small>


                            {{-- IMAGE PREVIEW --}}

                            <div id="imagePreview" class="mt-3" style="display:none;">

                                <p class="small text-muted mb-2">
                                    New Image Preview
                                </p>


                                <img id="previewImage" src="" alt="Preview" class="img-fluid rounded border"
                                    style="width:100%; max-height:250px; object-fit:cover;">

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


                                <option value="active"
                                    {{ old('status', $category->status) === 'active' ? 'selected' : '' }}>

                                    Active

                                </option>


                                <option value="inactive"
                                    {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>

                                    Inactive

                                </option>


                            </select>

                        </div>


                        {{-- =========================
                        BUTTONS
                    ========================== --}}
                        <div class="col-md-12">

                            <div class="d-flex gap-2">


                                <button type="submit" class="btn btn-primary" id="updateCategoryBtn">


                                    <span id="updateCategoryText">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Update Category

                                    </span>


                                    <span id="updateCategoryLoader" style="display:none;">

                                        <span class="spinner-border spinner-border-sm me-1">
                                        </span>

                                        Updating...

                                    </span>


                                </button>


                                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">

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
            | Image Preview
            |--------------------------------------------------------------------------
            */

            $('#image').on('change', function() {

                const file = this.files[0];

                if (!file) {

                    $('#imagePreview').hide();

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Allowed Types
                |--------------------------------------------------------------------------
                */

                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                if (!allowedTypes.includes(file.type)) {

                    alert(
                        'Invalid image. Please select JPG, JPEG, PNG or WEBP.'
                    );

                    $(this).val('');

                    $('#imagePreview').hide();

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Maximum 2MB
                |--------------------------------------------------------------------------
                */

                if (file.size > 2 * 1024 * 1024) {

                    alert(
                        'Image size must not exceed 2MB.'
                    );

                    $(this).val('');

                    $('#imagePreview').hide();

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Preview
                |--------------------------------------------------------------------------
                */

                const reader = new FileReader();


                reader.onload = function(e) {

                    $('#previewImage')
                        .attr('src', e.target.result);


                    $('#imagePreview').show();

                };


                reader.readAsDataURL(file);

            });


            /*
            |--------------------------------------------------------------------------
            | Form Validation
            |--------------------------------------------------------------------------
            */

            $('#categoryEditForm').on('submit', function(e) {

                let isValid = true;


                /*
                |--------------------------------------------------------------------------
                | Remove Previous Errors
                |--------------------------------------------------------------------------
                */

                $('.custom-error').remove();


                /*
                |--------------------------------------------------------------------------
                | Category Name
                |--------------------------------------------------------------------------
                */

                let name = $('#name').val().trim();


                if (name === '') {

                    $('#name').after(
                        '<div class="text-danger small custom-error mt-1">' +
                        'Category name is required.' +
                        '</div>'
                    );


                    isValid = false;

                }


                /*
                |--------------------------------------------------------------------------
                | Stop Submit
                |--------------------------------------------------------------------------
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
                |--------------------------------------------------------------------------
                | Loading
                |--------------------------------------------------------------------------
                */

                $('#updateCategoryBtn')
                    .prop('disabled', true);


                $('#updateCategoryText')
                    .hide();


                $('#updateCategoryLoader')
                    .show();

            });

        });
    </script>
@endpush
