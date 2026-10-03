@extends('layouts.site-layout')

@section('title', ($product->name ?? 'Product Details') . ' | Food Website')

@section('meta_description')
    {{ $product->short_description ?? 'View complete product information.' }}
@endsection

@section('content')

    <section class="food-product-details-section">

        <div class="container">

            {{-- Back --}}
            <div class="food-product-back">
                <a href="{{ route('site.products') }}">
                    <span>←</span>
                    Back to Products
                </a>
            </div>

            <div class="row g-5">

                {{-- ================= PRODUCT GALLERY ================= --}}
                <div class="col-lg-6">

                    @if ($product->images->count() > 0)

                        <div class="food-gallery" id="foodGallery">

                            {{-- Previous --}}
                            @if ($product->images->count() > 1)
                                <button type="button" class="gallery-arrow gallery-prev" id="galleryPrev"
                                    aria-label="Previous image">
                                    &#10094;
                                </button>
                            @endif

                            {{-- Main Image --}}
                            <img id="galleryMainImage" class="gallery-main-image"
                                src="{{ asset($product->images->first()->image_path) }}"
                                alt="{{ $product->images->first()->alt_text ?: $product->name }}">

                            {{-- Next --}}
                            @if ($product->images->count() > 1)
                                <button type="button" class="gallery-arrow gallery-next" id="galleryNext"
                                    aria-label="Next image">
                                    &#10095;
                                </button>
                            @endif

                        </div>

                        {{-- Counter --}}
                        @if ($product->images->count() > 1)
                            <div class="gallery-counter">
                                <span id="galleryCurrent">1</span>
                                <span>/</span>
                                <span>{{ $product->images->count() }}</span>
                            </div>
                        @endif


                        {{-- Thumbnails --}}
                        @if ($product->images->count() > 1)

                            <div class="gallery-thumbnails">

                                @foreach ($product->images as $index => $image)
                                    <button type="button" class="gallery-thumbnail {{ $index === 0 ? 'active' : '' }}"
                                        data-index="{{ $index }}" aria-label="View image {{ $index + 1 }}">

                                        <img src="{{ asset($image->image_path) }}"
                                            alt="{{ $image->alt_text ?: $product->name }}">

                                    </button>
                                @endforeach

                            </div>

                        @endif
                    @else
                        <div class="food-detail-placeholder">
                            <div class="placeholder-icon">🖼</div>
                            <span>No Image Available</span>
                        </div>

                    @endif

                </div>


                {{-- ================= PRODUCT DETAILS ================= --}}
                <div class="col-lg-6">

                    <div class="food-detail-content">

                        {{-- Category --}}
                        <div class="food-detail-category">
                            {{ $product->category->name ?? 'Food' }}
                        </div>


                        {{-- Name --}}
                        <h1 class="food-detail-title">
                            {{ $product->name }}
                        </h1>


                        {{-- Status --}}
                        <div class="food-detail-status">

                            @if ($product->status === 'Active')
                                <span class="food-status-active">
                                    ● Active
                                </span>
                            @else
                                <span class="food-status-inactive">
                                    ● {{ $product->status }}
                                </span>
                            @endif

                        </div>


                        {{-- Product Meta --}}
                        <div class="food-product-meta">

                            <div class="food-meta-item">

                                <span>Category</span>

                                <strong>
                                    {{ $product->category->name ?? 'N/A' }}
                                </strong>

                            </div>


                            <div class="food-meta-item">

                                <span>Product Type</span>

                                <strong>
                                    {{ $product->product_type ?? 'Single' }}
                                </strong>

                            </div>

                        </div>


                        {{-- Price --}}
                        <div class="food-detail-price">
                            ₹{{ number_format((float) $product->price, 2) }}
                        </div>


                        {{-- Short Description --}}
                        @if (!empty($product->short_description))
                            <div class="food-description-block">

                                <h5>
                                    Short Description
                                </h5>

                                <p>
                                    {{ $product->short_description }}
                                </p>

                            </div>
                        @endif


                        {{-- Description --}}
                        @if (!empty($product->description))
                            <div class="food-description-block">

                                <h5>
                                    Description
                                </h5>

                                <p>
                                    {!! nl2br(e($product->description)) !!}
                                </p>

                            </div>
                        @endif

                    </div>

                </div>

            </div>


            {{-- Product Type --}}
            @if (!empty($product->product_type))
                <div class="food-product-type-section">

                    <h3>
                        Product Information
                    </h3>

                    <div class="food-type-box">

                        <span>
                            Product Type
                        </span>

                        <strong>
                            {{ $product->product_type }}
                        </strong>

                    </div>

                </div>
            @endif

        </div>

    </section>


    {{-- =========================================================
     GALLERY JAVASCRIPT
========================================================= --}}

    @if ($product->images->count() > 1)
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /*
                |--------------------------------------------------------------------------
                | Product Images
                |--------------------------------------------------------------------------
                */

                const productImages = [
                    @foreach ($product->images as $image)
                        {
                            src: @json(asset($image->image_path)),
                            alt: @json($image->alt_text ?: $product->name)
                        }
                        {{ !$loop->last ? ',' : '' }}
                    @endforeach
                ];


                /*
                |--------------------------------------------------------------------------
                | Elements
                |--------------------------------------------------------------------------
                */

                const mainImage = document.getElementById('galleryMainImage');

                const previousButton = document.getElementById('galleryPrev');

                const nextButton = document.getElementById('galleryNext');

                const currentNumber = document.getElementById('galleryCurrent');

                const thumbnails = document.querySelectorAll('.gallery-thumbnail');

                const gallery = document.getElementById('foodGallery');


                /*
                |--------------------------------------------------------------------------
                | Current Image
                |--------------------------------------------------------------------------
                */

                let currentIndex = 0;


                /*
                |--------------------------------------------------------------------------
                | Show Image
                |--------------------------------------------------------------------------
                */

                function showImage(index) {

                    if (!productImages.length) {
                        return;
                    }


                    // Previous from first image
                    if (index < 0) {
                        index = productImages.length - 1;
                    }


                    // Next from last image
                    if (index >= productImages.length) {
                        index = 0;
                    }


                    currentIndex = index;


                    /*
                    | Change Main Image
                    */

                    mainImage.src = productImages[index].src;

                    mainImage.alt = productImages[index].alt;


                    /*
                    | Update Counter
                    */

                    if (currentNumber) {

                        currentNumber.textContent = index + 1;

                    }


                    /*
                    | Update Active Thumbnail
                    */

                    thumbnails.forEach(function(thumbnail, thumbnailIndex) {

                        if (thumbnailIndex === index) {

                            thumbnail.classList.add('active');

                        } else {

                            thumbnail.classList.remove('active');

                        }

                    });


                    /*
                    | Scroll Active Thumbnail
                    */

                    if (thumbnails[index]) {

                        thumbnails[index].scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest',
                            inline: 'center'
                        });

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Previous Button
                |--------------------------------------------------------------------------
                */

                if (previousButton) {

                    previousButton.addEventListener('click', function(event) {

                        event.preventDefault();

                        showImage(currentIndex - 1);

                    });

                }


                /*
                |--------------------------------------------------------------------------
                | Next Button
                |--------------------------------------------------------------------------
                */

                if (nextButton) {

                    nextButton.addEventListener('click', function(event) {

                        event.preventDefault();

                        showImage(currentIndex + 1);

                    });

                }


                /*
                |--------------------------------------------------------------------------
                | Thumbnail Click
                |--------------------------------------------------------------------------
                */

                thumbnails.forEach(function(thumbnail, index) {

                    thumbnail.addEventListener('click', function(event) {

                        event.preventDefault();

                        showImage(index);

                    });

                });


                /*
                |--------------------------------------------------------------------------
                | Keyboard Navigation
                |--------------------------------------------------------------------------
                */

                document.addEventListener('keydown', function(event) {

                    if (event.key === 'ArrowLeft') {

                        showImage(currentIndex - 1);

                    }


                    if (event.key === 'ArrowRight') {

                        showImage(currentIndex + 1);

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | Mobile Swipe
                |--------------------------------------------------------------------------
                */

                let touchStartX = 0;

                let touchEndX = 0;


                if (gallery) {

                    gallery.addEventListener('touchstart', function(event) {

                        touchStartX = event.changedTouches[0].screenX;

                    }, {
                        passive: true
                    });


                    gallery.addEventListener('touchend', function(event) {

                        touchEndX = event.changedTouches[0].screenX;

                        const distance = touchStartX - touchEndX;


                        if (Math.abs(distance) < 50) {

                            return;

                        }


                        if (distance > 0) {

                            // Swipe left = next
                            showImage(currentIndex + 1);

                        } else {

                            // Swipe right = previous
                            showImage(currentIndex - 1);

                        }

                    }, {
                        passive: true
                    });

                }


                /*
                |--------------------------------------------------------------------------
                | Initial Image
                |--------------------------------------------------------------------------
                */

                showImage(0);

            });
        </script>
    @endif


    {{-- =========================================================
     CSS
========================================================= --}}

    <style>
        .food-product-details-section {
            padding: 70px 0;
            background: #f8f9fa;
        }


        /* Back Button */

        .food-product-back {
            margin-bottom: 25px;
        }

        .food-product-back a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #222;
            text-decoration: none;
            font-weight: 600;
        }

        .food-product-back a:hover {
            color: #e63946;
        }


        /* Gallery */

        .food-gallery {
            position: relative;
            width: 100%;
            height: 480px;
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e5e5e5;
            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* Main Image */

        .gallery-main-image {
            width: 100%;
            height: 100%;
            padding: 25px;

            object-fit: contain;

            display: block;

            user-select: none;

            transition: opacity 0.2s ease;
        }


        /* Arrow */

        .gallery-arrow {
            position: absolute;

            top: 50%;

            transform: translateY(-50%);

            z-index: 20;

            width: 50px;
            height: 50px;

            border: none;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.95);

            color: #222;

            font-size: 25px;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);

            transition: all 0.2s ease;
        }

        .gallery-arrow:hover {

            background: #222;

            color: #fff;

        }

        .gallery-prev {
            left: 15px;
        }

        .gallery-next {
            right: 15px;
        }


        /* Counter */

        .gallery-counter {

            text-align: center;

            margin-top: 12px;

            color: #777;

            font-size: 14px;

            font-weight: 600;
        }


        /* Thumbnails */

        .gallery-thumbnails {

            display: flex;

            gap: 12px;

            margin-top: 15px;

            padding: 3px;

            overflow-x: auto;
        }


        /* Thumbnail */

        .gallery-thumbnail {

            flex: 0 0 85px;

            width: 85px;

            height: 85px;

            padding: 4px;

            background: #fff;

            border: 2px solid transparent;

            border-radius: 10px;

            overflow: hidden;

            cursor: pointer;

            transition: all 0.2s ease;
        }


        .gallery-thumbnail img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

            border-radius: 6px;

        }


        .gallery-thumbnail:hover {

            border-color: #999;

        }


        .gallery-thumbnail.active {

            border-color: #e63946;

        }


        /* Details */

        .food-detail-content {

            padding: 10px 0;

        }


        .food-detail-category {

            display: inline-block;

            color: #e63946;

            font-size: 14px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.5px;

            margin-bottom: 10px;
        }


        .food-detail-title {

            font-size: 44px;

            line-height: 1.2;

            font-weight: 700;

            color: #222;

            margin-bottom: 15px;
        }


        /* Status */

        .food-detail-status {

            margin-bottom: 25px;
        }


        .food-status-active,
        .food-status-inactive {

            display: inline-flex;

            padding: 7px 13px;

            border-radius: 50px;

            font-size: 13px;

            font-weight: 600;
        }


        .food-status-active {

            color: #16803c;

            background: #e9f8ef;

        }


        .food-status-inactive {

            color: #c62828;

            background: #fdecec;

        }


        /* Meta */

        .food-product-meta {

            display: flex;

            gap: 50px;

            padding: 20px 0;

            border-top: 1px solid #eee;

            border-bottom: 1px solid #eee;
        }


        .food-meta-item {

            display: flex;

            flex-direction: column;

            gap: 6px;
        }


        .food-meta-item span {

            color: #888;

            font-size: 13px;
        }


        .food-meta-item strong {

            color: #222;

            font-size: 16px;

            font-weight: 600;
        }


        /* Price */

        .food-detail-price {

            font-size: 34px;

            font-weight: 700;

            color: #e63946;

            margin: 25px 0;
        }


        /* Description */

        .food-description-block {

            margin-top: 25px;
        }


        .food-description-block h5 {

            font-size: 18px;

            font-weight: 700;

            margin-bottom: 10px;

            color: #222;
        }


        .food-description-block p {

            color: #666;

            line-height: 1.8;

            margin: 0;
        }


        /* Product Type */

        .food-product-type-section {

            margin-top: 50px;

            background: #fff;

            padding: 30px;

            border-radius: 18px;

            border: 1px solid #eee;
        }


        .food-product-type-section h3 {

            margin-bottom: 20px;

            font-size: 24px;

            font-weight: 700;
        }


        .food-type-box {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 15px 20px;

            background: #f8f9fa;

            border-radius: 10px;
        }


        .food-type-box span {

            color: #777;
        }


        .food-type-box strong {

            text-transform: capitalize;
        }


        /* Placeholder */

        .food-detail-placeholder {

            width: 100%;

            height: 480px;

            background: #fff;

            border-radius: 20px;

            border: 1px solid #eee;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            color: #aaa;
        }


        .placeholder-icon {

            font-size: 60px;

            margin-bottom: 10px;
        }


        /* Responsive */

        @media (max-width: 991px) {

            .food-gallery {
                height: 400px;
            }

            .food-detail-title {
                font-size: 36px;
            }

        }


        @media (max-width: 575px) {

            .food-product-details-section {
                padding: 40px 0;
            }

            .food-gallery {
                height: 320px;
                border-radius: 15px;
            }

            .gallery-main-image {
                padding: 15px;
            }

            .gallery-arrow {
                width: 40px;
                height: 40px;
            }

            .gallery-prev {
                left: 8px;
            }

            .gallery-next {
                right: 8px;
            }

            .gallery-thumbnail {
                flex-basis: 70px;
                width: 70px;
                height: 70px;
            }

            .food-detail-title {
                font-size: 30px;
            }

            .food-product-meta {
                gap: 25px;
            }

            .food-detail-price {
                font-size: 28px;
            }

        }
    </style>

@endsection
