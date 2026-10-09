@extends('layouts.site-layout')

@section('title', 'Our Products | Food Website')

@section('meta_description', 'Discover delicious food, browse categories and explore your favourite meals.')

@section('content')

<style>
    .food-products-page {
        padding: 70px 0;
        background: #f8f9fb;
    }

    .food-products-heading {
        text-align: center;
        margin-bottom: 35px;
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

    .food-category-filters {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 35px;
    }

    .food-category-filters a {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #e1e1e1;
        border-radius: 30px;
        background: #fff;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: .25s;
    }

    .food-category-filters a:hover,
    .food-category-filters a.active {
        background: #ff8c1a;
        border-color: #ff8c1a;
        color: #fff;
    }

    .food-product-card {
        height: 100%;
        overflow: hidden;
        border: 1px solid #eee;
        border-radius: 14px;
        background: #fff;
        transition: transform .25s, box-shadow .25s;
    }

    .food-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
    }

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

    .food-product-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .food-product-price {
        color: #ff8c1a;
        font-size: 20px;
        font-weight: 700;
    }

    .food-product-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .food-product-button,
    .food-add-cart-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 13px;
        border: 0;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all .25s ease;
    }

    .food-product-button {
        background: #071b2c;
        color: #fff;
    }

    .food-product-button:hover {
        background: #ff8c1a;
        color: #fff;
    }

    .food-add-cart-button {
        background: #ff8c1a;
        color: #fff;
        cursor: pointer;
    }

    .food-add-cart-button:hover {
        background: #071b2c;
        color: #fff;
        transform: translateY(-1px);
    }

    .food-add-cart-button:disabled {
        opacity: .7;
        cursor: not-allowed;
        transform: none;
    }

    .food-add-cart-button.added {
        background: #198754;
    }

    .food-empty-state {
        padding: 50px 20px;
        text-align: center;
        background: #fff;
        border-radius: 12px;
    }

    .food-load-more-loader {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 35px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(15px);
        transition: opacity .35s ease, transform .35s ease,
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
        box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
        color: #555;
        font-size: 14px;
        font-weight: 600;
    }

    .food-loader-spinner {
        width: 22px;
        height: 22px;
        border: 3px solid #eee;
        border-top-color: #ff8c1a;
        border-radius: 50%;
        animation: foodLoaderSpin .8s linear infinite;
    }

    @keyframes foodLoaderSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

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

    @media (max-width: 575px) {
        .food-products-page {
            padding: 45px 0;
        }

        .food-product-image {
            height: 200px;
        }

        .food-product-bottom {
            align-items: flex-start;
        }

        .food-product-actions {
            width: 100%;
        }

        .food-product-button,
        .food-add-cart-button {
            flex: 1;
        }

        .food-loader-box {
            padding: 10px 18px;
            font-size: 13px;
        }

        .food-loader-spinner {
            width: 19px;
            height: 19px;
        }
    }
</style>

<section class="food-products-page">
    <div class="container">

        <div class="food-products-heading">
            <h2>Our Delicious Products</h2>
            <p>Explore our menu and find your favourite food.</p>
        </div>

        {{-- CATEGORY FILTERS --}}
        <div class="food-category-filters">
            <a href="{{ route('site.products') }}"
               class="{{ request()->filled('category_id') ? '' : 'active' }}">
                All Products
            </a>

            @foreach ($categories as $category)
                <a href="{{ route('site.products', ['category_id' => $category->id]) }}"
                   class="{{ (string) request('category_id') === (string) $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- PRODUCT COUNT --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Explore Our Menu</h5>
            <span class="text-muted">{{ $products->total() }} products</span>
        </div>

        {{-- PRODUCTS --}}
        <div class="row g-4" id="foodProductsContainer">

            @forelse ($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="food-product-card">

                        <div class="food-product-image">
                            @if ($product->images->isNotEmpty() && $product->images->first()->image_path)
                                <img
                                    src="{{ asset($product->images->first()->image_path) }}"
                                    alt="{{ $product->images->first()->alt_text ?: $product->name }}"
                                    loading="lazy">
                            @else
                                <div class="food-product-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </div>

                        <div class="food-product-info">
                            <span class="food-product-category">
                                {{ $product->category->name ?? 'Food' }}
                            </span>

                            <h5>{{ $product->name }}</h5>

                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    $product->short_description ?: $product->description ?: 'Delicious food made for you.',
                                    100
                                ) }}
                            </p>

                            <div class="food-product-bottom">
                                <span class="food-product-price">
                                    ₹{{ number_format((float) $product->price, 2) }}
                                </span>

                                <div class="food-product-actions">
                                    <button
                                        type="button"
                                        class="food-add-cart-button"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ (float) $product->price }}"
                                        data-image="{{ $product->images->isNotEmpty() && $product->images->first()->image_path
                                            ? asset($product->images->first()->image_path)
                                            : '' }}">
                                        <i class="bi bi-cart-plus"></i>
                                        Add to Cart
                                    </button>

                                    <a href="{{ route('products.show', $product->slug) }}"
                                       class="food-product-button">
                                        View Details
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="food-empty-state">
                        <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                        <h4 class="mt-3">No Products Found</h4>
                        <p class="text-muted">
                            There are no active products in this category.
                        </p>

                        @if (request()->filled('category_id'))
                            <a href="{{ route('site.products') }}" class="btn btn-dark">
                                View All Products
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse

        </div>

        {{-- INFINITE SCROLL LOADER --}}
        <div class="food-load-more-loader" id="foodLoadMoreLoader">
            <div class="food-loader-box">
                <span class="food-loader-spinner"></span>
                <span>Loading Products...</span>
            </div>
        </div>

        {{-- NO MORE PRODUCTS --}}
        <div id="foodNoMoreProducts"
             class="text-center text-muted py-4"
             style="{{ $products->hasMorePages() ? 'display:none;' : '' }}">
            All products loaded.
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const productsContainer = document.getElementById('foodProductsContainer');
    const loader = document.getElementById('foodLoadMoreLoader');
    const noMoreProducts = document.getElementById('foodNoMoreProducts');

    if (!productsContainer) {
        return;
    }

    let currentPage = Number(@json($products->currentPage()));
    let lastPage = Number(@json($products->lastPage()));
    let loading = false;

    const categoryId = @json(request('category_id'));
    const searchValue = @json(request('search'));

    function showLoader() {
        if (loader) loader.classList.add('show');
    }

    function hideLoader() {
        if (loader) loader.classList.remove('show');
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value === null || value === undefined ? '' : String(value);
        return div.innerHTML;
    }

    function createProductCard(product) {
        const imageHtml = product.image
            ? `<img src="${escapeHtml(product.image)}"
                    alt="${escapeHtml(product.image_alt || product.name || 'Food')}"
                    loading="lazy">`
            : `<div class="food-product-placeholder">
                    <i class="bi bi-image"></i>
               </div>`;

        const description = product.short_description ||
                            product.description ||
                            'Delicious food made for you.';

        const productPrice = Number(product.price || 0).toFixed(2);

        return `
            <div class="col-lg-4 col-md-6 food-new-product">
                <div class="food-product-card">
                    <div class="food-product-image">
                        ${imageHtml}
                    </div>

                    <div class="food-product-info">
                        <span class="food-product-category">
                            ${escapeHtml(product.category || 'Food')}
                        </span>

                        <h5>${escapeHtml(product.name || '')}</h5>

                        <p>${escapeHtml(String(description).substring(0, 100))}</p>

                        <div class="food-product-bottom">
                            <span class="food-product-price">
                                ₹${productPrice}
                            </span>

                            <div class="food-product-actions">
                                <button
                                    type="button"
                                    class="food-add-cart-button"
                                    data-id="${escapeHtml(product.id)}"
                                    data-name="${escapeHtml(product.name || '')}"
                                    data-price="${productPrice}"
                                    data-image="${escapeHtml(product.image || '')}">
                                    <i class="bi bi-cart-plus"></i>
                                    Add to Cart
                                </button>

                                <a href="${escapeHtml(product.url || '#')}"
                                   class="food-product-button">
                                    View Details
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    async function loadMoreProducts() {
        if (loading || currentPage >= lastPage) {
            return;
        }

        loading = true;
        showLoader();

        const nextPage = currentPage + 1;

        try {
            const url = new URL(
                @json(route('site.products')),
                window.location.origin
            );

            url.searchParams.set('page', nextPage);

            if (categoryId) {
                url.searchParams.set('category_id', categoryId);
            }

            if (searchValue) {
                url.searchParams.set('search', searchValue);
            }

            const response = await fetch(url.toString(), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Failed to load products.');
            }

            const data = await response.json();

            if (Array.isArray(data.products)) {
                data.products.forEach(function (product) {
                    productsContainer.insertAdjacentHTML(
                        'beforeend',
                        createProductCard(product)
                    );
                });
            }

            currentPage = Number(data.current_page ?? nextPage);
            lastPage = Number(data.last_page ?? lastPage);

            if (!data.has_more || currentPage >= lastPage) {
                if (noMoreProducts) {
                    noMoreProducts.style.display = 'block';
                }
            } else if (noMoreProducts) {
                noMoreProducts.style.display = 'none';
            }

        } catch (error) {
            console.error('Infinite Scroll Error:', error);
        } finally {
            loading = false;
            hideLoader();
        }
    }

    function checkScrollPosition() {
        if (loading || currentPage >= lastPage) {
            return;
        }

        const scrollPosition = window.innerHeight + window.scrollY;
        const pageHeight = document.documentElement.scrollHeight;

        if (scrollPosition >= pageHeight - 700) {
            loadMoreProducts();
        }
    }

    window.addEventListener('scroll', checkScrollPosition, {
        passive: true
    });

    /* ============================================================
       ADD TO CART + SWEETALERT2
       Guest cart/session and logged-in cart behavior are handled
       by the existing Laravel cart.add route.
    ============================================================ */

    document.addEventListener('click', async function (event) {
        const button = event.target.closest('.food-add-cart-button');

        if (!button || button.disabled) {
            return;
        }

        const productId = Number(button.dataset.id);

        if (!productId) {
            Swal.fire({
                icon: 'error',
                title: 'Product Not Found',
                text: 'Product ID not found. Please refresh the page.',
                confirmButtonColor: '#ff8c1a'
            });
            return;
        }

        const originalHtml = button.innerHTML;

        button.disabled = true;
        button.innerHTML =
            '<i class="bi bi-hourglass-split"></i> Adding...';

        try {
            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content') || @json(csrf_token());

            const response = await fetch(@json(route('cart.add')), {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            });

            const data = await response.json();

            if (!response.ok || data.success !== true) {
                throw new Error(
                    data.message || 'Unable to add product to cart.'
                );
            }

            /* Update any matching header cart counter */
            if (data.cart_count !== undefined) {
                const count = Number(data.cart_count);

                document.querySelectorAll(
                    '#headerCartCount, .header-cart-count'
                ).forEach(function (element) {
                    element.textContent = count;
                    element.style.display = count > 0
                        ? 'inline-flex'
                        : 'none';
                });
            }

            button.innerHTML =
                '<i class="bi bi-check-lg"></i> Added';

            button.classList.add('added');

            await Swal.fire({
                icon: 'success',
                title: 'Added to Cart!',
                text: data.message || 'Product added to cart successfully.',
                confirmButtonText: 'Continue Shopping',
                confirmButtonColor: '#ff8c1a',
                timer: 2200,
                timerProgressBar: true
            });

        } catch (error) {
            console.error('Add To Cart Error:', error);

            Swal.fire({
                icon: 'error',
                title: 'Could Not Add Product',
                text: error.message ||
                    'Something went wrong. Please try again.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ff8c1a'
            });

        } finally {
            button.innerHTML = originalHtml;
            button.classList.remove('added');
            button.disabled = false;
        }
    });

    /* Check if another page should load immediately */
    setTimeout(checkScrollPosition, 300);
});
</script>

@endsection