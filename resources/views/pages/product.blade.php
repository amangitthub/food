@extends('layouts.site-layout')

@section('title', 'Our Products | Food Website')

@section('meta_description', 'Discover delicious food, browse categories and explore your favourite meals.')

@section('content')

<style>
/* Uses your website variables (--theme, --theme2, --bg ...) with safe fallbacks */
.food-products-page{--g:var(--theme,#00813d);--r:var(--theme2,#d12525);--dark:var(--header,#212121);--txt:var(--text,#5c5c5b);--ln:var(--border,#d9d9d9);--cream:var(--bg,#f4f1ea);padding:70px 0;background:var(--cream)}
.food-products-page *{box-sizing:border-box}

/* Heading */
.food-products-heading{text-align:center;margin-bottom:30px}
.food-products-heading h2{margin:0 0 10px;color:var(--dark);font-size:clamp(28px,4.5vw,40px);font-weight:800}
.food-products-heading h2::after{content:"";display:block;width:56px;height:4px;margin:12px auto 0;background:var(--g);border-radius:4px}
.food-products-heading p{margin:0;color:var(--txt)}

/* Category filters */
.food-category-filters{display:flex;justify-content:center;flex-wrap:wrap;gap:10px;margin-bottom:32px}
.food-category-filters a{padding:10px 22px;background:#fff;border-radius:99px;box-shadow:0 2px 10px rgba(33,33,33,.06);color:var(--dark);text-decoration:none;font-size:14px;font-weight:600;transition:.25s}
.food-category-filters a:hover{color:var(--g)}
.food-category-filters a.active{background:var(--g);color:#fff;box-shadow:0 6px 16px rgba(0,129,61,.25)}

/* Product card */
.food-product-card{height:100%;display:flex;flex-direction:column;overflow:hidden;background:#fff;border-radius:20px;box-shadow:0 8px 28px rgba(33,33,33,.06);transition:transform .25s,box-shadow .25s}
.food-product-card:hover{transform:translateY(-6px);box-shadow:0 16px 36px rgba(33,33,33,.12)}
.food-product-image{position:relative;height:230px;overflow:hidden;background:var(--cream)}
.food-product-image img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.food-product-card:hover .food-product-image img{transform:scale(1.07)}
.food-product-placeholder{height:100%;display:flex;align-items:center;justify-content:center;color:#bbb;font-size:45px}

.food-product-info{flex:1;display:flex;flex-direction:column;padding:20px}
.food-product-category{align-self:flex-start;padding:4px 12px;margin-bottom:10px;background:#e6f4ec;color:var(--g);border-radius:99px;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px}
.food-product-info h5{margin:0 0 8px;color:var(--dark);font-size:19px;font-weight:700;line-height:1.35}
.food-product-info h5 a{color:inherit;text-decoration:none}
.food-product-info p{margin:0 0 16px;color:var(--txt);font-size:14px;line-height:1.65;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

.food-product-bottom{margin-top:auto;display:flex;flex-direction:column;gap:12px;padding-top:16px;border-top:1px dashed var(--ln)}
.food-product-price{color:var(--g);font-size:24px;font-weight:800;line-height:1}
.food-product-actions{display:flex;gap:8px;width:100%}
.food-product-button,.food-add-cart-button{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:11px 10px;border-radius:10px;font-size:13px;font-weight:700;text-align:center;text-decoration:none;white-space:nowrap;transition:.25s}
.food-add-cart-button{border:2px solid var(--g);background:var(--g);color:#fff;cursor:pointer}
.food-add-cart-button:hover{background:var(--dark);border-color:var(--dark);color:#fff}
.food-add-cart-button:disabled{opacity:.7;cursor:not-allowed}
.food-add-cart-button.added{background:var(--dark);border-color:var(--dark)}
.food-product-button{border:2px solid var(--ln);background:#fff;color:var(--dark)}
.food-product-button:hover{border-color:var(--g);color:var(--g)}

/* Favorite button (on the image) */
.food-card-favorite-form{position:absolute;top:12px;right:12px;z-index:5;margin:0}
.food-card-favorite-btn{width:40px;height:40px;display:inline-flex;align-items:center;justify-content:center;padding:0;border:0;border-radius:50%;background:rgba(255,255,255,.96);color:var(--r);cursor:pointer;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,.14);transition:.25s}
.food-card-favorite-btn:hover,.food-card-favorite-btn.is-favorite{background:var(--r);color:#fff;transform:scale(1.08)}
.food-card-favorite-btn:focus-visible{outline:3px solid rgba(0,129,61,.35);outline-offset:3px}
.food-card-favorite-form button:disabled{opacity:.6;cursor:wait}

/* Empty state */
.food-empty-state{padding:50px 20px;text-align:center;background:#fff;border-radius:20px;box-shadow:0 8px 28px rgba(33,33,33,.06)}

/* Infinite scroll loader */
.food-load-more-loader{width:100%;display:flex;justify-content:center;align-items:center;padding:35px 0;opacity:0;visibility:hidden;transform:translateY(15px);transition:opacity .35s,transform .35s,visibility .35s}
.food-load-more-loader.show{opacity:1;visibility:visible;transform:none}
.food-loader-box{display:flex;align-items:center;gap:12px;padding:12px 22px;background:#fff;border-radius:50px;box-shadow:0 8px 25px rgba(0,0,0,.08);color:var(--txt);font-size:14px;font-weight:600}
.food-loader-spinner{width:22px;height:22px;border:3px solid #eee;border-top-color:var(--g);border-radius:50%;animation:foodLoaderSpin .8s linear infinite}
@keyframes foodLoaderSpin{to{transform:rotate(360deg)}}
.food-new-product{animation:foodProductAppear .35s ease both}
@keyframes foodProductAppear{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
@media(prefers-reduced-motion:reduce){.food-new-product,.food-loader-spinner{animation:none}.food-product-card,.food-product-image img{transition:none}}

/* Mobile */
@media(max-width:575px){
    .food-products-page{padding:40px 0}
    .food-category-filters{flex-wrap:nowrap;justify-content:flex-start;overflow-x:auto;padding:4px 2px 8px;margin-bottom:22px;scrollbar-width:none}
    .food-category-filters::-webkit-scrollbar{display:none}
    .food-category-filters a{flex:none;padding:9px 18px}
    .food-product-image{height:200px}
    .food-product-info{padding:16px}
    .food-product-info h5{font-size:17px}
    .food-product-price{font-size:22px}
    .food-card-favorite-btn{width:38px;height:38px}
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
            <a href="{{ route('site.products') }}" class="{{ request()->filled('category_id') ? '' : 'active' }}">
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

                    {{-- <div class="food-product-image">
                        @if ($product->images->isNotEmpty() && $product->images->first()->image_path)
                        <img src="{{ asset($product->images->first()->image_path) }}"
                            alt="{{ $product->images->first()->alt_text ?: $product->name }}" loading="lazy">
                        @else
                        <div class="food-product-placeholder">
                            <i class="bi bi-image"></i>
                        </div>
                        @endif
                    </div> --}}

                    <div class="food-product-image">

                        @if ($product->images->isNotEmpty() && $product->images->first()->image_path)
                        <img src="{{ asset($product->images->first()->image_path) }}"
                            alt="{{ $product->images->first()->alt_text ?: $product->name }}" loading="lazy">
                        @else
                        <div class="food-product-placeholder">
                            <i class="bi bi-image"></i>
                        </div>
                        @endif
                    {{-- FAVORITE BUTTON --}}
                    @auth
                    @php
                    $isFavorite = \App\Models\Favorite::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->exists();
                    @endphp

                    <form action="{{ route('favorites.toggle') }}" method="POST" class="food-card-favorite-form">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <button type="submit" class="food-card-favorite-btn {{ $isFavorite ? 'is-favorite' : '' }}"
                            title="{{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}"
                            aria-label="{{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"
                                fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z" />
                            </svg>
                        </button>
                    </form>
                    @else
                    <a href="javascript:void(0);" class="food-card-favorite-form food-card-favorite-btn" title="Login to add to Favorites"
                        aria-label="Login to add to Favorites" data-bs-toggle="modal" data-bs-target="#loginModal">

                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z" />
                        </svg>
                    </a>
                    @endauth


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
                                <button type="button" class="food-add-cart-button" data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}" data-price="{{ (float) $product->price }}"
                                    data-image="{{ $product->images->isNotEmpty() && $product->images->first()->image_path
                                            ? asset($product->images->first()->image_path)
                                            : '' }}">
                                    <i class="bi bi-cart-plus"></i>
                                    Add to Cart
                                </button>

                                <a href="{{ route('products.show', $product->slug) }}" class="food-product-button">
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
        <div id="foodNoMoreProducts" class="text-center text-muted py-4"
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

    // Heart icon for dynamically loaded products
    const favoriteHtml = @json(auth()->check())
        ? `
            <form action="{{ route('favorites.toggle') }}"
                  method="POST"
                  class="food-card-favorite-form">
                <input type="hidden" name="_token"
                       value="${escapeHtml(@json(csrf_token()))}">
                <input type="hidden" name="product_id"
                       value="${escapeHtml(product.id)}">

                <button type="submit"
                        class="food-card-favorite-btn ${product.is_favorite ? 'is-favorite' : ''}"
                        title="${product.is_favorite ? 'Remove from Favorites' : 'Add to Favorites'}"
                        aria-label="${product.is_favorite ? 'Remove from Favorites' : 'Add to Favorites'}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="23" height="23" viewBox="0 0 24 24"
                         fill="${product.is_favorite ? 'currentColor' : 'none'}"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
                    </svg>
                </button>
            </form>
          `
        : `
            <a href="${escapeHtml(product.login_url || '{{ route('login', ['redirect' => request()->fullUrl()]) }}')}"
               class="food-card-favorite-form food-card-favorite-btn"
               title="Login to add to Favorites"
               aria-label="Login to add to Favorites">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="23" height="23" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
                </svg>
            </a>
          `;

    return `
        <div class="col-lg-4 col-md-6 food-new-product">
            <div class="food-product-card">
                <div class="food-product-image">
                    ${imageHtml}
                    ${favoriteHtml}
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

// Favorite toggle without page refresh
document.addEventListener('submit', async function (event) {
    const form = event.target.closest('.food-card-favorite-form');

    if (!form || form.tagName !== 'FORM') {
        return;
    }

    event.preventDefault();

    const button = form.querySelector('.food-card-favorite-btn');

    if (!button || button.disabled) {
        return;
    }

    button.disabled = true;

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: new FormData(form)
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Could not update favorites.');
        }

        const icon = button.querySelector('svg');

        button.classList.toggle('is-favorite', data.is_favorite);

        button.title = data.is_favorite
            ? 'Remove from Favorites'
            : 'Add to Favorites';

        button.setAttribute('aria-label', button.title);

        if (icon) {
            icon.setAttribute(
                'fill',
                data.is_favorite ? 'currentColor' : 'none'
            );
        }

    } catch (error) {
        console.error('Favorite error:', error);
        alert('Favorite update nahi ho paya. Please dobara try karo.');
    } finally {
        button.disabled = false;
    }
});

</script>

@endsection