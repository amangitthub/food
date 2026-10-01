@extends('layouts.dash-layout')

@section('content')

    <div class="container-fluid py-4">

        {{-- =====================================================
        PAGE HEADER
    ====================================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1">
                    Add Category
                </h4>

                <p class="text-muted mb-0">
                    Create a new product category
                </p>

            </div>


            <a href="{{ route('categories.index') }}" class="btn btn-light border">

                <i class="bi bi-arrow-left me-1"></i>

                Back to Categories

            </a>

        </div>


        {{-- =====================================================
        VALIDATION ERRORS
    ====================================================== --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">

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
        CATEGORY FORM CARD
    ====================================================== --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <h5 class="mb-0 fw-semibold">
                    Category Information
                </h5>

            </div>


            <div class="card-body p-4">

                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                    id="categoryForm">

                    @csrf


                    <div class="row g-4">


                        {{-- =================================================
                        CATEGORY NAME
                    ================================================== --}}
                        <div class="col-md-6">

                            <label for="name" class="form-label fw-semibold">

                                Category Name

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Enter category name" value="{{ old('name') }}">

                            <div class="text-danger small mt-1" id="nameError"></div>

                        </div>


                        {{-- =================================================
                        SLUG PREVIEW
                    ================================================== --}}
                        <div class="col-md-6">

                            <label for="slugPreview" class="form-label fw-semibold">

                                Slug

                            </label>


                            <input type="text" id="slugPreview" class="form-control bg-light"
                                placeholder="Slug will be generated automatically" readonly>

                            <small class="text-muted">
                                Slug will be generated automatically.
                            </small>

                        </div>


                        {{-- =================================================
                        IMAGE
                    ================================================== --}}
                        <div class="col-md-6">

                            <label for="image" class="form-label fw-semibold">

                                Category Image

                                <span class="text-muted fw-normal">
                                    (Optional)
                                </span>

                            </label>


                            <input type="file" name="image" id="image" class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">


                            <small class="text-muted">
                                JPG, JPEG, PNG or WEBP. Maximum 2MB.
                            </small>


                            <div class="text-danger small mt-1" id="imageError"></div>


                            {{-- IMAGE PREVIEW --}}
                            <div class="mt-3" id="imagePreviewContainer" style="display:none;">

                                <p class="small fw-semibold mb-2">
                                    Image Preview
                                </p>

                                <img id="imagePreview" src="#" alt="Category Preview" width="120" height="120"
                                    class="rounded border" style="object-fit:cover;">

                            </div>

                        </div>


                        {{-- =================================================
                        STATUS
                    ================================================== --}}
                        <div class="col-md-6">

                            <label for="status" class="form-label fw-semibold">

                                Status

                            </label>


                            <select name="status" id="status" class="form-select">

                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>

                                    Active

                                </option>

                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>

                                    Inactive

                                </option>

                            </select>

                        </div>


                        {{-- =================================================
                        SHORT DESCRIPTION
                    ================================================== --}}
                        <div class="col-12">

                            <label for="short_description" class="form-label fw-semibold">

                                Short Description

                                <span class="text-muted fw-normal">
                                    (Optional)
                                </span>

                            </label>


                            <textarea name="short_description" id="short_description" rows="3" class="form-control"
                                placeholder="Enter short description">{{ old('short_description') }}</textarea>


                            <div class="text-danger small mt-1" id="shortDescriptionError"></div>

                        </div>


                        {{-- =================================================
                        DESCRIPTION
                    ================================================== --}}
                        <div class="col-12">

                            <label for="description" class="form-label fw-semibold">

                                Description

                                <span class="text-muted fw-normal">
                                    (Optional)
                                </span>

                            </label>


                            <textarea name="description" id="description" rows="6" class="form-control"
                                placeholder="Enter category description">{{ old('description') }}</textarea>


                            <div class="text-danger small mt-1" id="descriptionError"></div>

                        </div>


                    </div>


                    {{-- =================================================
                    FORM BUTTONS
                ================================================== --}}
                    <div class="border-top mt-4 pt-4">

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('categories.index') }}" class="btn btn-light border">

                                Cancel

                            </a>


                            <button type="submit" class="btn btn-primary" id="submitBtn">

                                <i class="bi bi-check-lg me-1"></i>

                                Save Category

                            </button>

                        </div>

                    </div>


                </form>

            </div>

        </div>

    </div>


    {{-- =============================================================
    JQUERY VALIDATION + SLUG PREVIEW + IMAGE PREVIEW
============================================================= --}}

    @push('js')
        <script>
            $(document).ready(function() {


                // =========================================================
                // AUTOMATIC SLUG PREVIEW
                // =========================================================

                $('#name').on('keyup', function() {

                    let name = $(this).val();

                    let slug = name
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');

                    $('#slugPreview').val(slug);

                });


                // =========================================================
                // IMAGE PREVIEW
                // =========================================================

                $('#image').on('change', function(event) {

                    let file = event.target.files[0];

                    if (!file) {

                        $('#imagePreviewContainer').hide();

                        return;
                    }


                    let allowedTypes = [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ];


                    if (!allowedTypes.includes(file.type)) {

                        $('#imageError').text(
                            'Please select JPG, JPEG, PNG or WEBP image.'
                        );

                        $('#imagePreviewContainer').hide();

                        $(this).val('');

                        return;
                    }


                    // Maximum 2MB

                    if (file.size > 2 * 1024 * 1024) {

                        $('#imageError').text(
                            'Image size must not exceed 2MB.'
                        );

                        $('#imagePreviewContainer').hide();

                        $(this).val('');

                        return;
                    }


                    $('#imageError').text('');


                    let reader = new FileReader();


                    reader.onload = function(e) {

                        $('#imagePreview')
                            .attr('src', e.target.result);

                        $('#imagePreviewContainer').show();

                    };


                    reader.readAsDataURL(file);

                });


                // =========================================================
                // JQUERY VALIDATION
                // =========================================================

                $('#categoryForm').on('submit', function(e) {

                    let isValid = true;


                    // Clear old errors

                    $('.text-danger.small').text('');


                    // =====================================================
                    // NAME VALIDATION
                    // =====================================================

                    let name = $('#name').val().trim();


                    if (name === '') {

                        $('#nameError').text(
                            'Category name is required.'
                        );

                        isValid = false;

                    } else if (name.length > 255) {

                        $('#nameError').text(
                            'Category name must not exceed 255 characters.'
                        );

                        isValid = false;

                    }


                    // =====================================================
                    // IMAGE VALIDATION
                    // =====================================================

                    let imageInput = $('#image')[0];


                    if (imageInput.files.length > 0) {

                        let file = imageInput.files[0];


                        let allowedTypes = [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ];


                        if (!allowedTypes.includes(file.type)) {

                            $('#imageError').text(
                                'Please select JPG, JPEG, PNG or WEBP image.'
                            );

                            isValid = false;

                        }


                        if (file.size > 2 * 1024 * 1024) {

                            $('#imageError').text(
                                'Image size must not exceed 2MB.'
                            );

                            isValid = false;

                        }

                    }


                    // =====================================================
                    // STOP FORM IF INVALID
                    // =====================================================

                    if (!isValid) {

                        e.preventDefault();

                        $('html, body').animate({
                            scrollTop: $('.is-invalid, .text-danger')
                                .first()
                                .offset()?.top - 100
                        }, 300);

                        return false;

                    }


                    // =====================================================
                    // SUBMIT BUTTON
                    // =====================================================

                    $('#submitBtn')
                        .prop('disabled', true)
                        .html(
                            '<span class="spinner-border spinner-border-sm me-1"></span> Saving...'
                        );

                });

            });
        </script>
    @endpush

@endsection
