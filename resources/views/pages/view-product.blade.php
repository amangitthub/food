@extends('layouts.site-layout')

@section('title', ($product->name ?? 'Product Details') . ' | Food Website')

@section('meta_description')
{{ $product->short_description ?? 'View complete product information.' }}
@endsection

@section('content')

<style>
    /* Uses your website variables (--theme, --theme2, --bg ...) with safe fallbacks */
    .food-product-details-section {
        --g: var(--theme, #00813d);
        --r: var(--theme2, #d12525);
        --dark: var(--header, #212121);
        --txt: var(--text, #5c5c5b);
        --ln: var(--border, #d9d9d9);
        --cream: var(--bg, #f4f1ea);
        --sh: 0 8px 30px rgba(33, 33, 33, .07);
        padding: 70px 0;
        background: var(--cream)
    }

    .food-product-details-section * {
        box-sizing: border-box
    }

    /* Back link */
    .food-product-back {
        margin-bottom: 24px
    }

    .food-product-back a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: #fff;
        border-radius: 99px;
        box-shadow: 0 2px 10px rgba(33, 33, 33, .06);
        color: var(--dark);
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: .2s
    }

    .food-product-back a:hover {
        background: var(--g);
        color: #fff
    }

    /* Gallery */
    .food-gallery,
    .food-detail-placeholder {
        width: 100%;
        height: 480px;
        background: #fff;
        border-radius: 22px;
        box-shadow: var(--sh);
        display: flex;
        align-items: center;
        justify-content: center
    }

    .food-gallery {
        position: relative;
        overflow: hidden
    }

    .food-detail-placeholder {
        flex-direction: column;
        color: #aaa
    }

    .placeholder-icon {
        font-size: 60px;
        margin-bottom: 10px
    }

    .gallery-main-image {
        width: 100%;
        height: 100%;
        padding: 26px;
        object-fit: contain;
        display: block;
        user-select: none
    }

    .gallery-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 20;
        width: 46px;
        height: 46px;
        border: 0;
        border-radius: 50%;
        background: #fff;
        color: var(--dark);
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(0, 0, 0, .16);
        transition: .2s
    }

    .gallery-arrow:hover {
        background: var(--g);
        color: #fff
    }

    .gallery-prev {
        left: 15px
    }

    .gallery-next {
        right: 15px
    }

    .gallery-counter {
        width: fit-content;
        margin: 14px auto 0;
        padding: 4px 16px;
        background: #fff;
        border-radius: 99px;
        box-shadow: 0 2px 10px rgba(33, 33, 33, .06);
        color: var(--dark);
        font-size: 13px;
        font-weight: 700
    }

    .gallery-thumbnails {
        display: flex;
        gap: 12px;
        margin-top: 14px;
        padding: 4px;
        overflow-x: auto
    }

    .gallery-thumbnail {
        flex: 0 0 82px;
        width: 82px;
        height: 82px;
        padding: 4px;
        background: #fff;
        border: 2px solid transparent;
        border-radius: 14px;
        overflow: hidden;
        cursor: pointer;
        opacity: .7;
        transition: .2s
    }

    .gallery-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 9px
    }

    .gallery-thumbnail:hover {
        opacity: 1
    }

    .gallery-thumbnail.active {
        border-color: var(--g);
        opacity: 1
    }

    /* Details card */
    .food-detail-content {
        min-width: 0;
        padding: 32px;
        background: #fff;
        border-radius: 22px;
        box-shadow: var(--sh)
    }

    .food-detail-category {
        display: inline-block;
        padding: 5px 15px;
        margin-bottom: 12px;
        background: #e6f4ec;
        color: var(--g);
        border-radius: 99px;
        font-size: 12.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px
    }

    .food-title-favorite-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px
    }

    .food-detail-title {
        flex: 1;
        min-width: 0;
        margin: 0;
        font-size: 42px;
        line-height: 1.18;
        font-weight: 800;
        color: var(--dark);
        overflow-wrap: anywhere
    }

    .food-favorite-form {
        flex-shrink: 0;
        margin: 0
    }

    .food-title-favorite-row .food-favorite-btn,
    .food-title-favorite-row .food-card-favorite-btn {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: 1px solid var(--ln);
        border-radius: 50%;
        background: #fff;
        color: var(--r);
        text-decoration: none;
        cursor: pointer;
        transition: .25s
    }

    .food-title-favorite-row .food-favorite-btn:hover,
    .food-title-favorite-row .food-favorite-btn.is-favorite,
    .food-title-favorite-row .food-card-favorite-btn:hover,
    .food-title-favorite-row .food-card-favorite-btn.is-favorite {
        background: var(--r);
        border-color: var(--r);
        color: #fff;
        box-shadow: 0 6px 16px rgba(209, 37, 37, .22)
    }

    .food-product-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        padding: 0;
        margin: 0 0 6px;
        border: 0
    }

    .food-meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
        padding: 14px 16px;
        background: var(--cream);
        border-radius: 14px
    }

    .food-meta-item span {
        color: var(--txt);
        font-size: 12.5px
    }

    .food-meta-item strong {
        color: var(--dark);
        font-size: 16px;
        font-weight: 700;
        text-transform: capitalize;
        overflow-wrap: anywhere
    }

    .food-detail-price {
        margin: 22px 0;
        font-size: 38px;
        line-height: 1.1;
        font-weight: 800;
        color: var(--g)
    }

    /* Add to cart */
    .food-add-cart-box {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin: 0 0 10px
    }

    .food-quantity-box {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        height: 54px;
        border: 1px solid var(--ln);
        border-radius: 12px;
        overflow: hidden;
        background: #fff
    }

    .food-qty-btn {
        width: 46px;
        height: 54px;
        border: 0;
        background: var(--cream);
        color: var(--dark);
        font-size: 22px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s
    }

    .food-qty-btn:hover {
        background: var(--g);
        color: #fff
    }

    .food-qty-btn:disabled {
        opacity: .5;
        cursor: not-allowed
    }

    #productQuantity {
        width: 52px;
        height: 54px;
        border: 0;
        text-align: center;
        font-size: 17px;
        font-weight: 700;
        color: var(--dark);
        outline: none;
        background: #fff
    }

    .food-add-cart-btn {
        flex: 1 1 220px;
        min-height: 54px;
        padding: 0 26px;
        border: 0;
        border-radius: 12px;
        background: var(--g);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(0, 129, 61, .22);
        transition: .25s
    }

    .food-add-cart-btn:hover {
        transform: translateY(-2px);
        background: var(--dark);
        box-shadow: 0 12px 24px rgba(33, 33, 33, .25)
    }

    .food-add-cart-btn:disabled {
        cursor: not-allowed;
        opacity: .75;
        transform: none
    }

    .food-cart-success-message {
        display: none;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
        padding: 10px 14px;
        background: #e6f4ec;
        border-radius: 10px;
        color: #00642f;
        font-size: 14px;
        font-weight: 600
    }

    .food-cart-success-message.show {
        display: flex
    }

    /* Descriptions */
    .food-description-block {
        margin-top: 26px;
        padding-top: 22px;
        border-top: 1px dashed var(--ln)
    }

    .food-description-block h5 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 10px;
        font-size: 18px;
        font-weight: 700;
        color: var(--dark)
    }

    .food-description-block h5::before {
        content: "";
        width: 4px;
        height: 18px;
        background: var(--g);
        border-radius: 4px
    }

    .food-description-block p {
        margin: 0;
        color: var(--txt);
        line-height: 1.85;
        overflow-wrap: anywhere
    }

    /* Combo items */
    .combo-items-section {
        width: 100%;
        margin-top: 26px;
        padding: 24px 0 4px;
        border-top: 1px dashed var(--ln)
    }

    .combo-items-heading {
        text-align: left;
        margin-bottom: 20px
    }

    .combo-items-label {
        display: inline-flex;
        padding: 5px 13px;
        margin-bottom: 10px;
        background: #e6f4ec;
        color: var(--g);
        border-radius: 50px;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: 1px
    }

    .combo-items-heading h2 {
        margin: 0;
        color: var(--dark);
        font-size: 24px;
        line-height: 1.35;
        font-weight: 800
    }

    .combo-heading-line {
        width: 44px;
        height: 4px;
        background: var(--g);
        border-radius: 5px;
        margin: 10px 0
    }

    .combo-items-heading p {
        margin: 0;
        color: var(--txt);
        font-size: 13.5px;
        line-height: 1.6
    }

    .combo-item-card {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background: #fff;
        border: 1px solid #ebe6da;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(33, 33, 33, .05);
        transition: .25s
    }

    .combo-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(33, 33, 33, .1)
    }

    .combo-item-image {
        position: relative;
        width: 100%;
        height: 145px;
        overflow: hidden;
        background: var(--cream)
    }

    .combo-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block
    }

    .combo-item-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 4px 10px;
        background: var(--g);
        color: #fff;
        border-radius: 50px;
        font-size: 10.5px;
        font-weight: 700
    }

    .combo-item-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bbb;
        font-size: 32px
    }

    .combo-item-content {
        padding: 12px 8px;
        text-align: center
    }

    .combo-item-content h4 {
        margin: 0;
        color: var(--dark);
        font-size: 14px;
        line-height: 1.45;
        font-weight: 700;
        overflow-wrap: anywhere
    }

    /* Product information */
    .food-product-type-section {
        margin-top: 26px;
        padding: 22px;
        background: var(--cream);
        border-radius: 16px
    }

    .food-product-type-section h3 {
        margin: 0 0 14px;
        font-size: 20px;
        font-weight: 800;
        color: var(--dark)
    }

    .food-type-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 14px 18px;
        background: #fff;
        border-radius: 12px
    }

    .food-type-box span {
        color: var(--txt)
    }

    .food-type-box strong {
        color: var(--dark);
        text-transform: capitalize
    }
        /* ========================================
   YOU MAY ALSO LIKE - RECOMMENDED PRODUCTS
======================================== */

.food-recommend-section {
    padding: 55px 0 70px;
    background: var(--bg, #f4f1ea);
}

.food-recommend-section * {
    box-sizing: border-box;
}

.food-recommend-heading {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}

.food-recommend-eyebrow {
    display: inline-block;
    margin-bottom: 8px;
    padding: 6px 13px;
    border-radius: 50px;
    background: #e6f4ec;
    color: var(--theme, #00813d);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.food-recommend-heading h2 {
    margin: 0;
    color: var(--header, #212121);
    font-size: clamp(25px, 4vw, 34px);
    font-weight: 800;
}

.food-recommend-heading p {
    margin: 8px 0 0;
    color: var(--text, #5c5c5b);
    font-size: 14px;
}

.food-recommend-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}

.food-recommend-card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, .06);
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 6px 22px rgba(33, 33, 33, .05);
    transition: transform .25s ease, box-shadow .25s ease;
}

.food-recommend-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(33, 33, 33, .12);
}

.food-recommend-image {
    position: relative;
    display: block;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #f4f1ea;
}

.food-recommend-image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
}

.food-recommend-card:hover .food-recommend-image img {
    transform: scale(1.07);
}

.food-recommend-no-image {
    display: flex;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 35px;
}

.food-recommend-category {
    position: absolute;
    top: 12px;
    left: 12px;
    max-width: calc(100% - 24px);
    overflow: hidden;
    padding: 6px 10px;
    border-radius: 50px;
    background: #fff;
    color: var(--theme, #00813d);
    font-size: 10px;
    font-weight: 800;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.food-recommend-content {
    padding: 17px;
}

.food-recommend-name {
    display: -webkit-box;
    min-height: 44px;
    margin: 0 0 8px;
    overflow: hidden;
    color: var(--header, #212121);
    font-size: 15px;
    font-weight: 800;
    line-height: 1.5;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.food-recommend-name a {
    color: inherit;
    text-decoration: none;
}

.food-recommend-name a:hover {
    color: var(--theme, #00813d);
}

.food-recommend-price {
    margin-bottom: 14px;
    color: var(--theme, #00813d);
    font-size: 21px;
    font-weight: 800;
}

.food-recommend-actions {
    display: grid;
    grid-template-columns: 1fr;
    gap: 9px;
}

.food-recommend-view,
.food-recommend-add {
    display: flex;
    width: 100%;
    min-height: 42px;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px;
    border: 0;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 800;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: .2s;
}

.food-recommend-view {
    border: 1px solid var(--theme, #00813d);
    background: #fff;
    color: var(--theme, #00813d);
}

.food-recommend-view:hover {
    background: var(--theme, #00813d);
    color: #fff;
}

.food-recommend-add {
    background: var(--theme, #00813d);
    color: #fff;
}

.food-recommend-add:hover {
    background: var(--header, #212121);
}

.food-recommend-add:disabled {
    cursor: wait;
    opacity: .65;
}

.food-recommend-message {
    min-height: 16px;
    color: var(--theme, #00813d);
    font-size: 11px;
    text-align: center;
}

.food-recommend-empty {
    padding: 30px;
    border-radius: 16px;
    background: #fff;
    color: var(--text, #5c5c5b);
    text-align: center;
}

@media (max-width: 991px) {
    .food-recommend-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }
}

@media (max-width: 767px) {
    .food-recommend-section {
        padding: 35px 0 45px;
    }

    .food-recommend-grid {
        gap: 12px;
    }

    .food-recommend-content {
        padding: 12px;
    }

    .food-recommend-heading {
        margin-bottom: 20px;
    }

    .food-recommend-name {
        font-size: 13px;
    }

    .food-recommend-price {
        font-size: 18px;
    }

    .food-recommend-category {
        top: 7px;
        left: 7px;
        font-size: 9px;
    }
}

    /* Tablet */
    @media(max-width:991px) {

        .food-gallery,
        .food-detail-placeholder {
            height: 400px
        }

        .food-detail-title {
            font-size: 34px
        }

        .combo-item-image {
            height: 150px
        }
    }

    /* Mobile */
    @media(max-width:767px) {
        .food-product-details-section {
            padding: 26px 0 40px
        }

        .food-product-details-section .container {
            padding-left: 14px;
            padding-right: 14px
        }

        .food-product-details-section .row.g-5 {
            --bs-gutter-x: 0;
            --bs-gutter-y: 1.25rem
        }

        /* removes the big Bootstrap gap */
        .food-product-back {
            margin-bottom: 14px
        }

        .food-gallery,
        .food-detail-placeholder {
            height: 300px;
            border-radius: 16px
        }

        .gallery-main-image {
            padding: 12px
        }

        .gallery-arrow {
            width: 38px;
            height: 38px
        }

        .gallery-prev {
            left: 8px
        }

        .gallery-next {
            right: 8px
        }

        .gallery-thumbnails {
            gap: 8px
        }

        .gallery-thumbnail {
            flex-basis: 60px;
            width: 60px;
            height: 60px;
            border-radius: 10px
        }

        .food-detail-content {
            padding: 20px 16px;
            border-radius: 16px
        }

        .food-title-favorite-row {
            gap: 10px
        }

        .food-detail-title {
            font-size: 25px;
            line-height: 1.25
        }

        .food-title-favorite-row .food-favorite-btn,
        .food-title-favorite-row .food-card-favorite-btn {
            width: 42px;
            height: 42px
        }

        .food-product-meta {
            grid-template-columns: 1fr 1fr;
            gap: 10px
        }

        .food-meta-item {
            padding: 12px 14px
        }

        .food-meta-item strong {
            font-size: 14.5px
        }

        .food-detail-price {
            margin: 16px 0;
            font-size: 28px
        }

        .food-add-cart-box {
            flex-direction: column;
            align-items: stretch
        }

        .food-quantity-box {
            width: 100%;
            justify-content: center
        }

        #productQuantity {
            flex: 1
        }

        .food-add-cart-btn {
            flex: none;
            width: 100%
        }

        /* flex:none stops the button from getting 220px tall */
        .food-description-block {
            margin-top: 20px;
            padding-top: 18px
        }

        .food-description-block h5 {
            font-size: 16.5px
        }

        .combo-items-heading h2 {
            font-size: 19px
        }

        .combo-item-image {
            height: 105px
        }

        .combo-item-content {
            padding: 10px 6px
        }

        .combo-item-content h4 {
            font-size: 12.5px
        }

        .food-product-type-section {
            padding: 18px 14px
        }

        .food-type-box {
            flex-wrap: wrap;
            padding: 12px 14px
        }
    }
</style>

<section class="food-product-details-section">
    <div class="container">

        <div class="food-product-back">
            <a href="{{ route('site.products') }}">
                <span>←</span> Back to Products
            </a>
        </div>

        <div class="row g-5">

            {{-- PRODUCT GALLERY --}}
            <div class="col-lg-6">
                @if ($product->images->count() > 0)
                <div class="food-gallery" id="foodGallery">

                    @if ($product->images->count() > 1)
                    <button type="button" class="gallery-arrow gallery-prev" id="galleryPrev"
                        aria-label="Previous image">
                        &#10094;
                    </button>
                    @endif

                    <img id="galleryMainImage" class="gallery-main-image"
                        src="{{ asset($product->images->first()->image_path) }}"
                        alt="{{ $product->images->first()->alt_text ?: $product->name }}">

                    @if ($product->images->count() > 1)
                    <button type="button" class="gallery-arrow gallery-next" id="galleryNext" aria-label="Next image">
                        &#10095;
                    </button>
                    @endif
                </div>

                @if ($product->images->count() > 1)
                <div class="gallery-counter">
                    <span id="galleryCurrent">1</span> /
                    <span>{{ $product->images->count() }}</span>
                </div>

                <div class="gallery-thumbnails">
                    @foreach ($product->images as $index => $image)
                    <button type="button" class="gallery-thumbnail {{ $index === 0 ? 'active' : '' }}"
                        data-index="{{ $index }}" aria-label="View image {{ $index + 1 }}">
                        <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text ?: $product->name }}">
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

            {{-- PRODUCT DETAILS --}}
            <div class="col-lg-6">
                <div class="food-detail-content">

                    <div class="food-detail-category">
                        {{ $product->category->name ?? 'Food' }}
                    </div>

                    {{-- <h1 class="food-detail-title">{{ $product->name }}</h1> --}}

                    <div class="food-title-favorite-row">
                        <h1 class="food-detail-title">{{ $product->name }}</h1>

                        @auth
                        @php
                        $isFavorite = \App\Models\Favorite::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->exists();
                        @endphp

                        <form action="{{ route('favorites.toggle') }}" method="POST" class="food-favorite-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <button type="submit" class="food-card-favorite-btn {{ $isFavorite ? 'is-favorite' : '' }}"
                                title="{{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}"
                                aria-label="{{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"
                                    fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z" />
                                </svg>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login', ['redirect' => request()->fullUrl()]) }}"
                            class="food-card-favorite-form food-card-favorite-btn" title="Login to add to Favorites"
                            aria-label="Login to add to Favorites">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z" />
                            </svg>
                        </a>
                        @endauth
                    </div>


                    <div class="food-product-meta">
                        <div class="food-meta-item">
                            <span>Category</span>
                            <strong>{{ $product->category->name ?? 'N/A' }}</strong>
                        </div>

                        <div class="food-meta-item">
                            <span>Product Type</span>
                            <strong>{{ $product->product_type ?? 'Single' }}</strong>
                        </div>
                    </div>

                    <div class="food-detail-price">
                        ₹{{ number_format((float) $product->price, 2) }}
                    </div>

                    {{-- ADD TO CART --}}
                    <div class="food-add-cart-box">

                        {{-- <div class="food-quantity-box">
                            <button type="button" class="food-qty-btn" id="qtyMinus"
                                aria-label="Decrease quantity">−</button>

                            <input type="text" id="productQuantity" value="1" readonly aria-label="Quantity">

                            <button type="button" class="food-qty-btn" id="qtyPlus"
                                aria-label="Increase quantity">+</button>
                        </div> --}}

                        <button type="button" class="food-add-cart-btn" id="addToCartBtn" data-id="{{ $product->id }}">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Add To Cart</span>
                        </button>
                    </div>

                    <div id="cartSuccessMessage" class="food-cart-success-message">
                        <i class="fa fa-check-circle"></i>
                        <span>Product added to cart successfully!</span>
                    </div>

                    {{-- COMBO ITEMS --}}
                    @if (
                    $product->product_type === 'combo' &&
                    isset($comboProducts) &&
                    $comboProducts->count() > 0
                    )
                    <div class="combo-items-section">
                        <div class="combo-items-heading">
                            <span class="combo-items-label">COMBO COLLECTION</span>
                            <h2>What's Inside This Combo?</h2>
                            <div class="combo-heading-line"></div>
                            <p>Discover the delicious items included in this combo.</p>
                        </div>

                        <div class="row g-3">
                            @foreach ($comboProducts as $comboItem)
                            <div class="col-xl-6 col-md-6 col-6">
                                <div class="combo-item-card">
                                    <div class="combo-item-image">
                                        @if (
                                        $comboItem->images->count() > 0 &&
                                        $comboItem->images->first()->image_path
                                        )
                                        <img src="{{ asset($comboItem->images->first()->image_path) }}"
                                            alt="{{ $comboItem->images->first()->alt_text ?: $comboItem->name }}"
                                            loading="lazy">
                                        @else
                                        <div class="combo-item-placeholder">
                                            <i class="fa fa-picture-o"></i>
                                        </div>
                                        @endif

                                        <span class="combo-item-badge">Included</span>
                                    </div>

                                    <div class="combo-item-content">
                                        <h4>{{ $comboItem->name }}</h4>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- SHORT DESCRIPTION --}}
                    @if (!empty($product->short_description))
                    <div class="food-description-block">
                        <h5>Short Description</h5>
                        <p>{{ $product->short_description }}</p>
                    </div>
                    @endif

                    {{-- DESCRIPTION --}}
                    @if (!empty($product->description))
                    <div class="food-description-block">
                        <h5>Description</h5>
                        <p>{!! nl2br(e($product->description)) !!}</p>
                    </div>
                    @endif

                    {{-- PRODUCT INFORMATION --}}
                    @if (!empty($product->product_type))
                    <div class="food-product-type-section">
                        <h3>Product Information</h3>
                        <div class="food-type-box">
                            <span>Product Type</span>
                            <strong>{{ $product->product_type }}</strong>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    {{-- ========================================
    YOU MAY ALSO LIKE
    ======================================== --}}
    <section class="food-recommend-section">
        <div class="container">

            <div class="food-recommend-heading">
                <div>
                    <span class="food-recommend-eyebrow">
                        Handpicked For You
                    </span>

                    <h2>You May Also Like ❤️</h2>

                    <p>Discover more delicious favourites from our menu.</p>
                </div>

                <a href="{{ route('site.products') }}" class="food-recommend-view"
                    style="width:auto;padding:12px 18px;">
                    View All Products <span>→</span>
                </a>
            </div>

            @if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())

            <div class="food-recommend-grid">

                @foreach($recommendedProducts as $recommended)
                @php
                $recommendImage = $recommended->images->first();
                @endphp

                <article class="food-recommend-card">

                    <a href="{{ route('products.show', $recommended->slug) }}" class="food-recommend-image">

                        @if($recommendImage && $recommendImage->image_path)
                        <img src="{{ asset($recommendImage->image_path) }}"
                            alt="{{ $recommendImage->alt_text ?: $recommended->name }}" loading="lazy">
                        @else
                        <div class="food-recommend-no-image">
                            <i class="fa fa-cutlery"></i>
                        </div>
                        @endif

                        <span class="food-recommend-category">
                            {{ $recommended->category->name ?? 'Food' }}
                        </span>

                    </a>

                    <div class="food-recommend-content">

                        <h3 class="food-recommend-name">
                            <a href="{{ route('products.show', $recommended->slug) }}">
                                {{ $recommended->name }}
                            </a>
                        </h3>

                        <div class="food-recommend-price">
                            ₹{{ number_format((float) $recommended->price, 2) }}
                        </div>

                        <div class="food-recommend-actions">

                            <a href="{{ route('products.show', $recommended->slug) }}" class="food-recommend-view">
                                View Product
                            </a>

                            <button type="button" class="food-recommend-add" data-id="{{ $recommended->id }}">

                                <i class="fa fa-shopping-cart"></i>
                                <span>Add To Cart</span>
                            </button>

                            <div class="food-recommend-message" aria-live="polite"></div>

                        </div>

                    </div>

                </article>
                @endforeach

            </div>

            @else
            <div class="food-recommend-empty">
                More delicious products are coming soon!
                <a href="{{ route('site.products') }}">Explore Menu</a>
            </div>
            @endif

        </div>
    </section>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       PRODUCT GALLERY
    ========================================================= */

    const productImages = [
        @foreach ($product->images as $image)
            {
                src: @json(asset($image->image_path)),
                alt: @json($image->alt_text ?: $product->name)
            }@if (!$loop->last),@endif
        @endforeach
    ];

    const mainImage = document.getElementById('galleryMainImage');
    const previousButton = document.getElementById('galleryPrev');
    const nextButton = document.getElementById('galleryNext');
    const currentNumber = document.getElementById('galleryCurrent');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    const gallery = document.getElementById('foodGallery');

    let currentIndex = 0;

    function showImage(index) {
        if (!productImages.length || !mainImage) return;

        if (index < 0) index = productImages.length - 1;
        if (index >= productImages.length) index = 0;

        currentIndex = index;
        mainImage.src = productImages[index].src;
        mainImage.alt = productImages[index].alt;

        if (currentNumber) currentNumber.textContent = index + 1;

        thumbnails.forEach(function (thumbnail, thumbnailIndex) {
            thumbnail.classList.toggle('active', thumbnailIndex === index);
        });
    }

    if (previousButton) {
        previousButton.addEventListener('click', function () {
            showImage(currentIndex - 1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            showImage(currentIndex + 1);
        });
    }

    thumbnails.forEach(function (thumbnail, index) {
        thumbnail.addEventListener('click', function () {
            showImage(index);
        });
    });

    if (gallery) {
        let touchStartX = 0;

        gallery.addEventListener('touchstart', function (event) {
            touchStartX = event.changedTouches[0].screenX;
        }, { passive: true });

        gallery.addEventListener('touchend', function (event) {
            const touchEndX = event.changedTouches[0].screenX;
            const distance = touchStartX - touchEndX;

            if (Math.abs(distance) < 50) return;

            showImage(distance > 0 ? currentIndex + 1 : currentIndex - 1);
        }, { passive: true });
    }

    if (productImages.length) showImage(0);

    /* =========================================================
       QUANTITY
    ========================================================= */

    const minusBtn = document.getElementById('qtyMinus');
    const plusBtn = document.getElementById('qtyPlus');
    const quantityInput = document.getElementById('productQuantity');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const successMessage = document.getElementById('cartSuccessMessage');

    let quantity = 1;

    function setQuantity(value) {
        quantity = Math.max(1, Math.min(99, parseInt(value, 10) || 1));

        if (quantityInput) {
            quantityInput.value = quantity;
        }
    }

    if (minusBtn) {
        minusBtn.addEventListener('click', function () {
            setQuantity(quantity - 1);
        });
    }

    if (plusBtn) {
        plusBtn.addEventListener('click', function () {
            setQuantity(quantity + 1);
        });
    }

    /* =========================================================
       HEADER CART COUNT
    ========================================================= */

    function updateHeaderCartCount(count) {
        if (count === undefined || count === null) return;

        count = Number(count) || 0;

        document.querySelectorAll(
            '#headerCartCount, .header-cart-count'
        ).forEach(function (element) {
            element.textContent = count;
            element.style.display = count > 0 ? 'inline-flex' : 'none';
        });
    }

    window.updateHeaderCartCount = updateHeaderCartCount;

    /* =========================================================
       SWEETALERT HELPER
    ========================================================= */

    function showCartAlert(options) {
        if (typeof Swal !== 'undefined') {
            return Swal.fire(options);
        }

        alert(
            (options.title ? options.title + '\n' : '') +
            (options.text || '')
        );

        return Promise.resolve();
    }

    /* =========================================================
       ADD TO CART
    ========================================================= */

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function (event) {
            event.preventDefault();

            const button = this;

            if (button.disabled) return;

            const productId = Number(button.dataset.id);
            const addQuantity = Math.max(
                1,
                parseInt(quantityInput ? quantityInput.value : '1', 10) || 1
            );

            if (!productId) {
                showCartAlert({
                    icon: 'error',
                    title: 'Product Not Found',
                    text: 'Product ID is missing. Please refresh the page.',
                    confirmButtonColor: '#e63946'
                });
                return;
            }

            const originalHTML = button.innerHTML;

            button.disabled = true;
            button.innerHTML =
                '<i class="fa fa-spinner fa-spin"></i><span>Adding...</span>';

            try {
                const response = await fetch(@json(route('cart.add')), {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN':
                            document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || @json(csrf_token()),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: addQuantity
                    })
                });

                let result;

                try {
                    result = await response.json();
                } catch (jsonError) {
                    throw new Error(
                        response.status === 419
                            ? 'Your session expired. Refresh the page and try again.'
                            : 'The server returned an unexpected response.'
                    );
                }

                if (
                    !response.ok ||
                    result.success === false ||
                    result.error
                ) {
                    throw new Error(
                        result.message || 'Unable to add product to cart.'
                    );
                }

                if (result.cart_count !== undefined) {
                    updateHeaderCartCount(result.cart_count);
                }

                if (successMessage) {
                    const messageText = successMessage.querySelector('span');

                    if (messageText) {
                        messageText.textContent =
                            result.message || 'Product added to cart successfully!';
                    }

                    successMessage.classList.add('show');
                }

                button.innerHTML =
                    '<i class="fa fa-check"></i><span>Added To Cart</span>';

                setQuantity(1);

                await showCartAlert({
                    icon: 'success',
                    title: 'Added to Cart!',
                    text: result.message || 'Product added to cart successfully.',
                    confirmButtonText: 'Continue Shopping',
                    confirmButtonColor: '#e63946',
                    timer: 2200,
                    timerProgressBar: true
                });

            } catch (error) {
                console.error('Add to Cart Error:', error);

                showCartAlert({
                    icon: 'error',
                    title: 'Could Not Add to Cart',
                    text: error.message || 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e63946'
                });
            } finally {
                button.innerHTML = originalHTML;
                button.disabled = false;
            }
        });
    }
    /* ========================================
   RECOMMENDED PRODUCTS - ADD TO CART
======================================== */

document.querySelectorAll('.food-recommend-add').forEach(function (button) {

    button.addEventListener('click', async function () {

        if (button.disabled) return;

        const productId = Number(button.dataset.id);
        const card = button.closest('.food-recommend-card');
        const message = card.querySelector('.food-recommend-message');
        const originalHTML = button.innerHTML;

        if (!productId) return;

        button.disabled = true;
        button.innerHTML =
            '<i class="fa fa-spinner fa-spin"></i> Adding...';

        message.textContent = '';

        try {
            const response = await fetch(@json(route('cart.add')), {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN':
                        document.querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content') || @json(csrf_token()),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            });

            const result = await response.json();

            if (!response.ok || result.success === false || result.error) {
                throw new Error(
                    result.message || 'Unable to add product to cart.'
                );
            }

            if (result.cart_count !== undefined &&
                typeof window.updateHeaderCartCount === 'function') {
                window.updateHeaderCartCount(result.cart_count);
            }

            button.innerHTML =
                '<i class="fa fa-check"></i> Added To Cart';

            message.textContent =
                result.message || 'Product added successfully!';

        } catch (error) {
            button.innerHTML = originalHTML;
            message.textContent =
                error.message || 'Please try again.';
        } finally {
            button.disabled = false;

            if (button.innerHTML.includes('Added To Cart')) {
                setTimeout(function () {
                    button.innerHTML = originalHTML;
                }, 1800);
            }
        }
    });

});

});
</script>

@endsection