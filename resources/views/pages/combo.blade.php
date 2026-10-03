@extends('layouts.site-layout')

@section('title', 'Our Combos | Food Website')

@section('meta_description', 'Discover delicious food combos and enjoy our best combination meals.')

@section('content')

<style>
    /* =========================================================
           COMBO PAGE
        ========================================================= */

    .food-products-page {
        padding: 70px 0;
        background: #f8f9fb;
    }


    /* =========================================================
           HEADING
        ========================================================= */

    .food-products-heading {
        text-align: center;
        margin-bottom: 30px;
    }

    .food-products-heading h2 {
        color: #202124;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .food-products-heading p {
        color: #777;
        margin-bottom: 0;
    }


    /* =========================================================
           CATEGORY FILTER
        ========================================================= */

    .food-category-filter {
        margin-bottom: 35px;
    }

    .food-category-filter .btn {
        border-radius: 50px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        transition: all .25s ease;
    }

    .food-category-filter .btn-dark {
        background: #071b2c;
        border-color: #071b2c;
        color: #fff;
    }

    .food-category-filter .btn-dark:hover {
        background: #ff8c1a;
        border-color: #ff8c1a;
        color: #fff;
    }

    .food-category-filter .btn-outline-dark {
        color: #071b2c;
        border-color: #071b2c;
        background: transparent;
    }

    .food-category-filter .btn-outline-dark:hover {
        background: #071b2c;
        color: #fff;
    }

    .food-category-filter .btn-warning {
        background: #ff8c1a;
        border-color: #ff8c1a;
        color: #fff;
    }

    .food-category-filter .btn-warning:hover {
        background: #e97908;
        border-color: #e97908;
        color: #fff;
    }

    .food-category-filter .btn-outline-warning {
        color: #ff8c1a;
        border-color: #ff8c1a;
        background: transparent;
    }

    .food-category-filter .btn-outline-warning:hover {
        background: #ff8c1a;
        border-color: #ff8c1a;
        color: #fff;
    }


    /* =========================================================
           COMBO CARD
        ========================================================= */

    .food-product-card {
        height: 100%;
        overflow: hidden;
        border: 1px solid #eee;
        border-radius: 14px;
        background: #fff;
        transition:
            transform .25s,
            box-shadow .25s;
    }

    .food-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
    }


    /* =========================================================
           COMBO IMAGE
        ========================================================= */

    .food-product-image {
        height: 230px;
        overflow: hidden;
        background: #f1f1f1;
    }

    .food-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s;
    }

    .food-product-card:hover .food-product-image img {
        transform: scale(1.05);
    }

    .food-product-placeholder {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 45px;
    }


    /* =========================================================
           COMBO INFO
        ========================================================= */

    .food-product-info {
        padding: 20px;
    }

    .food-product-category {
        display: inline-block;
        color: #ff8c1a;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .food-product-info h5 {
        font-weight: 700;
        margin-bottom: 10px;
        color: #222;
    }

    .food-product-info h5 a {
        color: inherit;
        text-decoration: none;
    }

    .food-product-info p {
        color: #777;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }


    /* =========================================================
           COMBO BOTTOM
        ========================================================= */

    .food-product-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .food-product-price {
        color: #ff8c1a;
        font-size: 20px;
        font-weight: 700;
    }

    .food-product-button {
        display: inline-block;
        padding: 9px 14px;
        border-radius: 6px;
        background: #071b2c;
        color: #fff;
        font-size: 13px;
        text-decoration: none;
        transition: all .25s ease;
    }

    .food-product-button:hover {
        background: #ff8c1a;
        color: #fff;
    }


    /* =========================================================
           EMPTY
        ========================================================= */

    .food-empty-state {
        padding: 50px 20px;
        text-align: center;
        background: #fff;
        border-radius: 12px;
    }


    /* =========================================================
           INFINITE SCROLL LOADER
        ========================================================= */

    .food-load-more-loader {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;

        padding: 35px 0;

        opacity: 0;
        visibility: hidden;

        transform: translateY(15px);

        transition:
            opacity .35s ease,
            transform .35s ease,
            visibility .35s ease;
    }

    .food-load-more-loader.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .food-loader-box {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 12px 22px;

        background: #fff;

        border-radius: 50px;

        box-shadow:
            0 8px 25px rgba(0, 0, 0, .08);

        color: #555;

        font-size: 14px;

        font-weight: 600;
    }

    .food-loader-spinner {
        width: 22px;
        height: 22px;

        border: 3px solid #eeeeee;

        border-top-color: #ff8c1a;

        border-radius: 50%;

        animation:
            foodLoaderSpin .8s linear infinite;
    }

    @keyframes foodLoaderSpin {

        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }

    }


    /* =========================================================
           NEW COMBO FADE
        ========================================================= */

    .food-new-product {
        animation: foodProductAppear .35s ease both;
    }

    @keyframes foodProductAppear {

        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }

    }


    /* =========================================================
           MOBILE
        ========================================================= */

    @media (max-width: 575px) {

        .food-products-page {
            padding: 45px 0;
        }

        .food-product-image {
            height: 200px;
        }

        .food-loader-box {
            padding: 10px 18px;
            font-size: 13px;
        }

        .food-loader-spinner {
            width: 19px;
            height: 19px;
        }

        .food-category-filter .btn {
            padding: 8px 14px;
            font-size: 12px;
        }

    }
</style>


<section class="food-products-page">

    <div class="container">


        {{-- =====================================================
        PAGE HEADING
        ====================================================== --}}

        <div class="food-products-heading">

            <h2>
                Our Delicious Combos
            </h2>

            <p>
                Enjoy our delicious food combinations at amazing prices.
            </p>

        </div>


        {{-- =====================================================
        CATEGORY FILTER
        ====================================================== --}}

        <div class="food-category-filter">

            <div class="d-flex flex-wrap justify-content-center gap-2">

                {{-- ALL COMBOS --}}

                <a href="{{ route('site.combos') }}"
                    class="btn {{ !request('category_id') ? 'btn-dark' : 'btn-outline-dark' }}">

                    All Combos

                </a>


                {{-- CATEGORIES --}}

                @foreach ($categories as $category)
                <a href="{{ route('site.combos', ['category_id' => $category->id]) }}" class="btn
                        {{ request('category_id') == $category->id ? 'btn-warning' : 'btn-outline-warning' }}">

                    {{ $category->name }}

                </a>
                @endforeach

            </div>

        </div>


        {{-- =====================================================
        COMBO COUNT
        ====================================================== --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="mb-0">
                Explore Our Combos
            </h5>

            <span class="text-muted">

                {{ $combos->total() }}

                combos

            </span>

        </div>


        {{-- =====================================================
        COMBOS
        ====================================================== --}}

        <div class="row g-4" id="foodProductsContainer">

            @forelse($combos as $combo)
            <div class="col-lg-4 col-md-6">

                <div class="food-product-card">


                    {{-- Combo Image --}}

                    <div class="food-product-image">

                        @if ($combo->images->isNotEmpty() && $combo->images->first()->image_path)
                        <img src="{{ asset($combo->images->first()->image_path) }}"
                            alt="{{ $combo->images->first()->alt_text ?: $combo->name }}" loading="lazy">
                        @else
                        <div class="food-product-placeholder">

                            <i class="bi bi-image"></i>

                        </div>
                        @endif

                    </div>


                    {{-- Combo Details --}}

                    <div class="food-product-info">


                        {{-- Category --}}

                        <span class="food-product-category">

                            {{ $combo->category->name ?? 'Combo' }}

                        </span>


                        {{-- Name --}}

                        <h5>

                            {{ $combo->name }}

                        </h5>


                        {{-- Description --}}

                        <p>

                            {{ \Illuminate\Support\Str::limit(
                            $combo->short_description ?: $combo->description ?: 'Delicious combo made for you.',
                            100,
                            ) }}

                        </p>


                        {{-- Bottom --}}

                        <div class="food-product-bottom">


                            {{-- Price --}}

                            <span class="food-product-price">

                                ₹{{ number_format((float) $combo->price, 2) }}

                            </span>


                            {{-- Details --}}

                            <a href="{{ route('products.show', $combo->id) }}" class="food-product-button">

                                View Details

                                <i class="bi bi-arrow-right ms-1"></i>

                            </a>


                        </div>

                    </div>

                </div>

            </div>

            @empty

            <div class="col-12">

                <div class="food-empty-state">

                    <i class="bi bi-emoji-frown fs-1 text-muted"></i>

                    <h4 class="mt-3">
                        No Combos Found
                    </h4>

                    <p class="text-muted">
                        There are no active combos available
                        for this category right now.
                    </p>

                </div>

            </div>
            @endforelse

        </div>


        {{-- =====================================================
        INFINITE SCROLL LOADER
        ====================================================== --}}

        <div class="food-load-more-loader" id="foodLoadMoreLoader">

            <div class="food-loader-box">

                <span class="food-loader-spinner"></span>

                <span>
                    Loading Combos...
                </span>

            </div>

        </div>


        {{-- =====================================================
        NO MORE COMBOS
        ====================================================== --}}

        <div id="foodNoMoreProducts" class="text-center text-muted py-4"
            style="{{ $combos->hasMorePages() ? 'display:none;' : '' }}">

            All combos loaded.

        </div>


    </div>

</section>


{{-- =============================================================
INFINITE SCROLL JAVASCRIPT
============================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {


            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const productsContainer =
                document.getElementById('foodProductsContainer');

            const loader =
                document.getElementById('foodLoadMoreLoader');

            const noMoreProducts =
                document.getElementById('foodNoMoreProducts');


            /*
            |--------------------------------------------------------------------------
            | Pagination State
            |--------------------------------------------------------------------------
            */

            let currentPage =
                {{ $combos->currentPage() }};

            let lastPage =
                {{ $combos->lastPage() }};

            let loading = false;


            /*
            |--------------------------------------------------------------------------
            | Current Category
            |--------------------------------------------------------------------------
            */

            const categoryId =
                "{{ request('category_id') }}";


            /*
            |--------------------------------------------------------------------------
            | Show Loader
            |--------------------------------------------------------------------------
            */

            function showLoader() {

                if (loader) {

                    loader.classList.add('show');

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Hide Loader
            |--------------------------------------------------------------------------
            */

            function hideLoader() {

                if (loader) {

                    loader.classList.remove('show');

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Escape HTML
            |--------------------------------------------------------------------------
            */

            function escapeHtml(value) {

                if (
                    value === null ||
                    value === undefined
                ) {

                    return '';

                }

                const div =
                    document.createElement('div');

                div.textContent = value;

                return div.innerHTML;

            }


            /*
            |--------------------------------------------------------------------------
            | Create Combo Card
            |--------------------------------------------------------------------------
            */

            function createComboCard(combo) {

                const imageHtml = combo.image

                    ?

                    `
            <img
                src="${escapeHtml(combo.image)}"
                alt="${escapeHtml(combo.image_alt)}"
                loading="lazy"
            >
            `

                    :

                    `
            <div class="food-product-placeholder">

                <i class="bi bi-image"></i>

            </div>
            `;


                const description =
                    combo.short_description ||
                    'Delicious combo made for you.';


                return `

            <div class="col-lg-4 col-md-6 food-new-product">

                <div class="food-product-card">


                    <div class="food-product-image">

                        ${imageHtml}

                    </div>


                    <div class="food-product-info">


                        <span class="food-product-category">

                            ${escapeHtml(combo.category)}

                        </span>


                        <h5>

                            ${escapeHtml(combo.name)}

                        </h5>


                        <p>

                            ${escapeHtml(
                                description.substring(0, 100)
                            )}

                        </p>


                        <div class="food-product-bottom">


                            <span class="food-product-price">

                                ₹${escapeHtml(combo.price)}

                            </span>


                            <a
                                href="${escapeHtml(combo.url)}"
                                class="food-product-button"
                            >

                                View Details

                                <i class="bi bi-arrow-right ms-1"></i>

                            </a>


                        </div>

                    </div>

                </div>

            </div>

        `;

            }


            /*
            |--------------------------------------------------------------------------
            | Load More Combos
            |--------------------------------------------------------------------------
            */

            async function loadMoreCombos() {


                // Already loading

                if (loading) {

                    return;

                }


                // No more pages

                if (currentPage >= lastPage) {

                    hideLoader();

                    return;

                }


                loading = true;

                showLoader();


                const nextPage =
                    currentPage + 1;


                try {


                    /*
                    |--------------------------------------------------------------------------
                    | Build URL
                    |--------------------------------------------------------------------------
                    */

                    const url = new URL(
                        "{{ route('site.combos') }}",
                        window.location.origin
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Page
                    |--------------------------------------------------------------------------
                    */

                    url.searchParams.set(
                        'page',
                        nextPage
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Category
                    |--------------------------------------------------------------------------
                    */

                    if (categoryId) {

                        url.searchParams.set(
                            'category_id',
                            categoryId
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | AJAX Request
                    |--------------------------------------------------------------------------
                    */

                    const response =
                        await fetch(
                            url.toString(), {
                                method: 'GET',

                                headers: {

                                    'X-Requested-With': 'XMLHttpRequest',

                                    'Accept': 'application/json'

                                }
                            }
                        );


                    if (!response.ok) {

                        throw new Error(
                            'Failed to load combos.'
                        );

                    }


                    const data =
                        await response.json();


                    /*
                    |--------------------------------------------------------------------------
                    | Add Combos
                    |--------------------------------------------------------------------------
                    */

                    if (
                        data.combos &&
                        data.combos.length
                    ) {

                        data.combos.forEach(
                            function(combo) {

                                productsContainer.insertAdjacentHTML(
                                    'beforeend',
                                    createComboCard(combo)
                                );

                            }
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Update Pagination
                    |--------------------------------------------------------------------------
                    */

                    currentPage =
                        data.current_page;

                    lastPage =
                        data.last_page;


                    /*
                    |--------------------------------------------------------------------------
                    | No More Combos
                    |--------------------------------------------------------------------------
                    */

                    if (!data.has_more) {

                        if (noMoreProducts) {

                            noMoreProducts.style.display =
                                'block';

                        }

                    }


                } catch (error) {

                    console.error(
                        'Infinite Scroll Error:',
                        error
                    );

                } finally {

                    loading = false;

                    hideLoader();

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Scroll Detection
            |--------------------------------------------------------------------------
            */

            window.addEventListener(
                'scroll',
                function() {


                    if (loading) {

                        return;

                    }


                    if (currentPage >= lastPage) {

                        return;

                    }


                    const scrollPosition =
                        window.innerHeight +
                        window.scrollY;


                    const pageHeight =
                        document.documentElement.scrollHeight;


                    /*
                    |--------------------------------------------------------------------------
                    | 500px Before Bottom
                    |--------------------------------------------------------------------------
                    */

                    if (
                        scrollPosition >=
                        pageHeight - 500
                    ) {

                        loadMoreCombos();

                    }

                }, {
                    passive: true
                }
            );

        });
</script>

@endsection