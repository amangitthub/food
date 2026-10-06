@extends('layouts.site-layout')

@section('title', ($product->name ?? 'Product Details') . ' | Food Website')

@section('meta_description')
    {{ $product->short_description ?? 'View complete product information.' }}
@endsection

@section('content')

<section class="food-product-details-section">

    <div class="container">

        {{-- =====================================================
        BACK
        ====================================================== --}}

        <div class="food-product-back">

            <a href="{{ route('site.products') }}">
                <span>←</span>
                Back to Products
            </a>

        </div>


        <div class="row g-5">

            {{-- =====================================================
            PRODUCT GALLERY
            ====================================================== --}}

            <div class="col-lg-6">

                @if ($product->images->count() > 0)

                    <div class="food-gallery" id="foodGallery">

                        @if ($product->images->count() > 1)

                            <button
                                type="button"
                                class="gallery-arrow gallery-prev"
                                id="galleryPrev"
                                aria-label="Previous image">

                                &#10094;

                            </button>

                        @endif


                        <img
                            id="galleryMainImage"
                            class="gallery-main-image"
                            src="{{ asset($product->images->first()->image_path) }}"
                            alt="{{ $product->images->first()->alt_text ?: $product->name }}"
                        >


                        @if ($product->images->count() > 1)

                            <button
                                type="button"
                                class="gallery-arrow gallery-next"
                                id="galleryNext"
                                aria-label="Next image">

                                &#10095;

                            </button>

                        @endif

                    </div>


                    @if ($product->images->count() > 1)

                        <div class="gallery-counter">

                            <span id="galleryCurrent">1</span>

                            <span>/</span>

                            <span>
                                {{ $product->images->count() }}
                            </span>

                        </div>

                    @endif


                    @if ($product->images->count() > 1)

                        <div class="gallery-thumbnails">

                            @foreach ($product->images as $index => $image)

                                <button
                                    type="button"
                                    class="gallery-thumbnail {{ $index === 0 ? 'active' : '' }}"
                                    data-index="{{ $index }}"
                                    aria-label="View image {{ $index + 1 }}">

                                    <img
                                        src="{{ asset($image->image_path) }}"
                                        alt="{{ $image->alt_text ?: $product->name }}"
                                    >

                                </button>

                            @endforeach

                        </div>

                    @endif

                @else

                    <div class="food-detail-placeholder">

                        <div class="placeholder-icon">
                            🖼
                        </div>

                        <span>
                            No Image Available
                        </span>

                    </div>

                @endif

            </div>


            {{-- =====================================================
            PRODUCT DETAILS
            ====================================================== --}}

            <div class="col-lg-6">

                <div class="food-detail-content">

                    <div class="food-detail-category">

                        {{ $product->category->name ?? 'Food' }}

                    </div>


                    <h1 class="food-detail-title">

                        {{ $product->name }}

                    </h1>

{{-- 
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

                    </div> --}}


                    <div class="food-product-meta">

                        <div class="food-meta-item">

                            <span>
                                Category
                            </span>

                            <strong>
                                {{ $product->category->name ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="food-meta-item">

                            <span>
                                Product Type
                            </span>

                            <strong>
                                {{ $product->product_type ?? 'Single' }}
                            </strong>

                        </div>

                    </div>


                    <div class="food-detail-price">

                        ₹{{ number_format((float) $product->price, 2) }}

                    </div>


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


        {{-- =====================================================
        COMBO ITEMS
        ====================================================== --}}

        @if (
            $product->product_type === 'combo' &&
            isset($comboProducts) &&
            $comboProducts->count() > 0
        )

            <div class="combo-items-section">

                {{-- Heading --}}

                <div class="combo-items-heading">

                    <span class="combo-items-label">
                        COMBO ITEMS
                    </span>

                    <h2>
                        What's Inside This Combo?
                    </h2>

                    <div class="combo-heading-line"></div>

                    <p>
                        Delicious items included in this combo
                    </p>

                </div>


                {{-- Items --}}

                <div class="row g-4 justify-content-center">

                    @foreach ($comboProducts as $comboItem)

                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div class="combo-item-card">

                                {{-- Image --}}

                                <div class="combo-item-image">

                                    @if (
                                        $comboItem->images->count() > 0 &&
                                        $comboItem->images->first()->image_path
                                    )

                                        <img
                                            src="{{ asset($comboItem->images->first()->image_path) }}"
                                            alt="{{ $comboItem->images->first()->alt_text ?: $comboItem->name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <div class="combo-item-placeholder">

                                            <i class="bi bi-image"></i>

                                        </div>

                                    @endif


                                    {{-- Small combo badge --}}

                                    <span class="combo-item-badge">
                                        Included
                                    </span>

                                </div>


                                {{-- Name --}}

                                <div class="combo-item-content">

                                    <h4>
                                        {{ $comboItem->name }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif


        {{-- =====================================================
        PRODUCT TYPE
        ====================================================== --}}

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

    const productImages = [

        @foreach ($product->images as $image)

            {
                src: @json(asset($image->image_path)),
                alt: @json($image->alt_text ?: $product->name)
            }

            {{ !$loop->last ? ',' : '' }}

        @endforeach

    ];


    const mainImage =
        document.getElementById('galleryMainImage');

    const previousButton =
        document.getElementById('galleryPrev');

    const nextButton =
        document.getElementById('galleryNext');

    const currentNumber =
        document.getElementById('galleryCurrent');

    const thumbnails =
        document.querySelectorAll('.gallery-thumbnail');

    const gallery =
        document.getElementById('foodGallery');


    let currentIndex = 0;


    function showImage(index) {

        if (!productImages.length) {
            return;
        }


        if (index < 0) {
            index = productImages.length - 1;
        }


        if (index >= productImages.length) {
            index = 0;
        }


        currentIndex = index;


        mainImage.src =
            productImages[index].src;

        mainImage.alt =
            productImages[index].alt;


        if (currentNumber) {

            currentNumber.textContent =
                index + 1;

        }


        thumbnails.forEach(
            function(thumbnail, thumbnailIndex) {

                if (thumbnailIndex === index) {

                    thumbnail.classList.add('active');

                } else {

                    thumbnail.classList.remove('active');

                }

            }
        );


        if (thumbnails[index]) {

            thumbnails[index].scrollIntoView({

                behavior: 'smooth',

                block: 'nearest',

                inline: 'center'

            });

        }

    }


    if (previousButton) {

        previousButton.addEventListener(
            'click',
            function(event) {

                event.preventDefault();

                showImage(
                    currentIndex - 1
                );

            }
        );

    }


    if (nextButton) {

        nextButton.addEventListener(
            'click',
            function(event) {

                event.preventDefault();

                showImage(
                    currentIndex + 1
                );

            }
        );

    }


    thumbnails.forEach(
        function(thumbnail, index) {

            thumbnail.addEventListener(
                'click',
                function(event) {

                    event.preventDefault();

                    showImage(index);

                }
            );

        }
    );


    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key === 'ArrowLeft') {

                showImage(
                    currentIndex - 1
                );

            }


            if (event.key === 'ArrowRight') {

                showImage(
                    currentIndex + 1
                );

            }

        }
    );


    let touchStartX = 0;

    let touchEndX = 0;


    if (gallery) {

        gallery.addEventListener(
            'touchstart',
            function(event) {

                touchStartX =
                    event.changedTouches[0].screenX;

            },
            {
                passive: true
            }
        );


        gallery.addEventListener(
            'touchend',
            function(event) {

                touchEndX =
                    event.changedTouches[0].screenX;

                const distance =
                    touchStartX - touchEndX;


                if (Math.abs(distance) < 50) {
                    return;
                }


                if (distance > 0) {

                    showImage(
                        currentIndex + 1
                    );

                } else {

                    showImage(
                        currentIndex - 1
                    );

                }

            },
            {
                passive: true
            }
        );

    }


    showImage(0);

});

</script>

@endif


{{-- =========================================================
CSS
========================================================= --}}

<style>

/* =====================================================
   MAIN SECTION
===================================================== */

.food-product-details-section {

    padding: 70px 0;

    background: #f8f9fa;

}


/* =====================================================
   BACK
===================================================== */

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

    transition: color .2s ease;

}


.food-product-back a:hover {

    color: #e63946;

}


/* =====================================================
   GALLERY
===================================================== */

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


.gallery-main-image {

    width: 100%;

    height: 100%;

    padding: 25px;

    object-fit: contain;

    display: block;

    user-select: none;

    transition: opacity .2s ease;

}


.gallery-arrow {

    position: absolute;

    top: 50%;

    transform: translateY(-50%);

    z-index: 20;

    width: 50px;

    height: 50px;

    border: none;

    border-radius: 50%;

    background: rgba(255,255,255,.95);

    color: #222;

    font-size: 25px;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    box-shadow: 0 4px 15px rgba(0,0,0,.15);

    transition: all .2s ease;

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


.gallery-counter {

    text-align: center;

    margin-top: 12px;

    color: #777;

    font-size: 14px;

    font-weight: 600;

}


.gallery-thumbnails {

    display: flex;

    gap: 12px;

    margin-top: 15px;

    padding: 3px;

    overflow-x: auto;

}


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

    transition: all .2s ease;

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


/* =====================================================
   DETAILS
===================================================== */

.food-detail-content {

    padding: 10px 0;

}


.food-detail-category {

    display: inline-block;

    color: #e63946;

    font-size: 14px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .5px;

    margin-bottom: 10px;

}


.food-detail-title {

    font-size: 44px;

    line-height: 1.2;

    font-weight: 700;

    color: #222;

    margin-bottom: 15px;

}


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


.food-detail-price {

    font-size: 34px;

    font-weight: 700;

    color: #e63946;

    margin: 25px 0;

}


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


/* =====================================================
   COMBO ITEMS
===================================================== */

.combo-items-section {

    margin-top: 65px;

    padding: 55px 0 10px;

    border-top: 1px solid #e5e5e5;

}


.combo-items-heading {

    text-align: center;

    margin-bottom: 38px;

}


.combo-items-label {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 7px 15px;

    background: #fff0f1;

    color: #e63946;

    border-radius: 50px;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 1.2px;

    margin-bottom: 13px;

}


.combo-items-heading h2 {

    margin: 0;

    color: #222;

    font-size: 30px;

    line-height: 1.3;

    font-weight: 700;

}


.combo-heading-line {

    width: 45px;

    height: 3px;

    background: #e63946;

    border-radius: 5px;

    margin: 14px auto;

}


.combo-items-heading p {

    margin: 0;

    color: #888;

    font-size: 14px;

}


/* =====================================================
   COMBO CARD
===================================================== */

.combo-item-card {

    position: relative;

    height: 100%;

    overflow: hidden;

    background: #fff;

    border: 1px solid #ededed;

    border-radius: 18px;

    box-shadow: 0 5px 20px rgba(0,0,0,.035);

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        border-color .3s ease;

}


.combo-item-card:hover {

    transform: translateY(-7px);

    border-color: #f1c4c7;

    box-shadow: 0 15px 35px rgba(0,0,0,.09);

}


/* =====================================================
   COMBO IMAGE
===================================================== */

.combo-item-image {

    position: relative;

    width: 100%;

    height: 210px;

    overflow: hidden;

    background: #f4f4f4;

}


.combo-item-image img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    display: block;

    transition: transform .45s ease;

}


.combo-item-card:hover
.combo-item-image img {

    transform: scale(1.07);

}


/* =====================================================
   INCLUDED BADGE
===================================================== */

.combo-item-badge {

    position: absolute;

    top: 13px;

    right: 13px;

    padding: 6px 11px;

    background: rgba(255,255,255,.94);

    color: #e63946;

    border-radius: 50px;

    font-size: 11px;

    font-weight: 700;

    box-shadow: 0 3px 12px rgba(0,0,0,.10);

}


/* =====================================================
   PLACEHOLDER
===================================================== */

.combo-item-placeholder {

    width: 100%;

    height: 100%;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #aaa;

    font-size: 42px;

}


/* =====================================================
   ITEM NAME
===================================================== */

.combo-item-content {

    padding: 18px 20px 20px;

    text-align: center;

}


.combo-item-content h4 {

    margin: 0;

    color: #222;

    font-size: 18px;

    line-height: 1.4;

    font-weight: 700;

}


/* =====================================================
   PRODUCT TYPE
===================================================== */

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


/* =====================================================
   PLACEHOLDER
===================================================== */

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


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 991px) {

    .food-gallery {

        height: 400px;

    }


    .food-detail-title {

        font-size: 36px;

    }


    .combo-items-section {

        margin-top: 50px;

        padding-top: 45px;

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


    .combo-items-section {

        margin-top: 40px;

        padding-top: 35px;

    }


    .combo-items-heading {

        margin-bottom: 28px;

    }


    .combo-items-heading h2 {

        font-size: 24px;

    }


    .combo-item-image {

        height: 200px;

    }


    .combo-item-content {

        padding: 16px;

    }


    .combo-item-content h4 {

        font-size: 17px;

    }

}

</style>

@endsection