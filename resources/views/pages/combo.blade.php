@extends('layouts.site-layout')

@section('title', 'Our Combos | Food Website')

@section('meta_description', 'Discover delicious food combos and enjoy our best combination meals.')

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

/* Category filter (Bootstrap .btn classes stay, only the look changes) */
.food-category-filter{margin-bottom:32px}
.food-category-filter .btn{padding:10px 22px;border:0;border-radius:99px;font-size:14px;font-weight:600;transition:.25s}
.food-category-filter .btn-outline-dark,.food-category-filter .btn-outline-warning{background:#fff;color:var(--dark);box-shadow:0 2px 10px rgba(33,33,33,.06)}
.food-category-filter .btn-outline-dark:hover,.food-category-filter .btn-outline-warning:hover{background:#fff;color:var(--g)}
.food-category-filter .btn-dark,.food-category-filter .btn-warning{background:var(--g);color:#fff;box-shadow:0 6px 16px rgba(0,129,61,.25)}
.food-category-filter .btn-dark:hover,.food-category-filter .btn-warning:hover{background:var(--g);color:#fff}

/* Combo card */
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

/* Price on top, two equal buttons below */
.food-product-bottom{margin-top:auto;display:grid;grid-template-columns:1fr 1fr;gap:10px;padding-top:16px;border-top:1px dashed var(--ln)}
.food-product-price{grid-column:1/-1;color:var(--g);font-size:24px;font-weight:800;line-height:1}
.food-product-button,.food-add-cart-button{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:11px 10px;border-radius:10px;font-size:13px;font-weight:700;text-align:center;text-decoration:none;white-space:nowrap;transition:.25s}
.food-add-cart-button{border:2px solid var(--g);background:var(--g);color:#fff;cursor:pointer}
.food-add-cart-button:hover{background:var(--dark);border-color:var(--dark);color:#fff}
.food-add-cart-button:disabled{opacity:.7;cursor:not-allowed}
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
    .food-category-filter{margin-bottom:22px}
    .food-category-filter .d-flex{flex-wrap:nowrap!important;justify-content:flex-start!important;overflow-x:auto;padding:4px 2px 8px;scrollbar-width:none}
    .food-category-filter .d-flex::-webkit-scrollbar{display:none}
    .food-category-filter .btn{flex:none;padding:9px 18px}
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
            <h2>Our Delicious Combos</h2>
            <p>Enjoy our delicious food combinations at amazing prices.</p>
        </div>

        {{-- CATEGORY FILTER --}}
        <div class="food-category-filter">
            <div class="d-flex flex-wrap justify-content-center gap-2">

                <a href="{{ route('site.combos') }}"
                    class="btn {{ !request('category_id') ? 'btn-dark' : 'btn-outline-dark' }}">
                    All Combos
                </a>

                @foreach ($categories as $category)
                <a href="{{ route('site.combos', ['category_id' => $category->id]) }}"
                    class="btn {{ request('category_id') == $category->id ? 'btn-warning' : 'btn-outline-warning' }}">
                    {{ $category->name }}
                </a>
                @endforeach

            </div>
        </div>

        {{-- COMBO COUNT --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Explore Our Combos</h5>
            <span class="text-muted">{{ $combos->total() }} combos</span>
        </div>

        {{-- COMBO LIST --}}
        <div class="row g-4" id="foodProductsContainer">

            @forelse ($combos as $combo)
            <div class="col-lg-4 col-md-6">

                <div class="food-product-card">

                    <div class="food-product-image">

                        @if ($combo->images->isNotEmpty() && $combo->images->first()->image_path)
                        <img src="{{ asset($combo->images->first()->image_path) }}"
                            alt="{{ $combo->images->first()->alt_text ?: $combo->name }}" loading="lazy">
                        @else
                        <div class="food-product-placeholder">
                            <i class="bi bi-image"></i>
                        </div>
                        @endif

                        {{-- WISHLIST / FAVORITES --}}
                        @auth
                        @php
                        $isFavorite = \App\Models\Favorite::where('user_id', auth()->id())
                        ->where('product_id', $combo->id)
                        ->exists();
                        @endphp

                        <form action="{{ route('favorites.toggle') }}" method="POST" class="food-card-favorite-form">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $combo->id }}">

                            <button type="submit" class="food-card-favorite-btn {{ $isFavorite ? 'is-favorite' : '' }}"
                                title="{{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}"
                                aria-label="{{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}">

                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z" />
                                </svg>
                            </button>
                        </form>
                        @else
                        <a href="javascript:void(0);" class="food-card-favorite-form food-card-favorite-btn"
                            title="Login to add to Favorites" aria-label="Login to add to Favorites"
                            data-bs-toggle="modal" data-bs-target="#loginModal">

                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z" />
                            </svg>
                        </a>
                        @endauth

                    </div>


                    <div class="food-product-info">

                        <span class="food-product-category">
                            {{ $combo->category->name ?? 'Combo' }}
                        </span>

                        <h5>
                            {{ $combo->name }}
                        </h5>

                        <p>
                            {{ \Illuminate\Support\Str::limit(
                            $combo->short_description
                            ?: $combo->description
                            ?: 'Delicious combo made for you.',
                            100
                            ) }}
                        </p>

                        <div class="food-product-bottom">

                            <span class="food-product-price">
                                ₹{{ number_format((float) $combo->price, 2) }}
                            </span>

                            <button type="button" class="food-add-cart-button" data-id="{{ $combo->id }}">
                                <i class="bi bi-cart-plus"></i>
                                <span>Add to Cart</span>
                            </button>

                            <a href="{{ route('products.show', $combo->slug) }}" class="food-product-button">
                                View Details
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12" id="foodInitialEmptyState">
                <div class="food-empty-state">
                    <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                    <h4 class="mt-3">No Combos Found</h4>
                    <p class="text-muted">
                        There are no active combos available for this category right now.
                    </p>
                </div>
            </div>
            @endforelse

        </div>

        {{-- INFINITE SCROLL LOADER --}}
        <div class="food-load-more-loader" id="foodLoadMoreLoader">
            <div class="food-loader-box">
                <span class="food-loader-spinner"></span>
                <span>Loading Combos...</span>
            </div>
        </div>

        {{-- NO MORE COMBOS --}}
        <div id="foodNoMoreProducts" class="text-center text-muted py-4"
            style="{{ $combos->hasMorePages() ? 'display:none;' : '' }}">
            All combos loaded.
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const productsContainer = document.getElementById('foodProductsContainer');
    const loader = document.getElementById('foodLoadMoreLoader');
    const noMoreProducts = document.getElementById('foodNoMoreProducts');

    let currentPage = {{ $combos->currentPage() }};
    let lastPage = {{ $combos->lastPage() }};
    let loading = false;

    const categoryId = @json(request('category_id'));

    function showLoader() {
        if (loader) loader.classList.add('show');
    }

    function hideLoader() {
        if (loader) loader.classList.remove('show');
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function formatPrice(value) {
        const price = Number(value) || 0;
        return price.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

 
function createComboCard(combo) {
    const imageHtml = combo.image
        ? `<img src="${escapeHtml(combo.image)}"
                alt="${escapeHtml(combo.image_alt || combo.name)}"
                loading="lazy">`
        : `<div class="food-product-placeholder">
                <i class="bi bi-image"></i>
           </div>`;

    const description = combo.short_description ||
                        combo.description ||
                        'Delicious combo made for you.';

    const isLoggedIn = @json(auth()->check());
    const csrfToken = @json(csrf_token());

    let favoriteHtml = '';

    if (isLoggedIn) {
        const isFavorite = combo.is_favorite === true ||
                           combo.is_favorite === 1 ||
                           combo.is_favorite === '1';

        favoriteHtml = `
            <form action="{{ route('favorites.toggle') }}"
                  method="POST"
                  class="food-card-favorite-form">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="product_id" value="${Number(combo.id)}">

                <button type="submit"
                        class="food-card-favorite-btn ${isFavorite ? 'is-favorite' : ''}"
                        title="${isFavorite ? 'Remove from Favorites' : 'Add to Favorites'}"
                        aria-label="${isFavorite ? 'Remove from Favorites' : 'Add to Favorites'}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="22" height="22" viewBox="0 0 24 24"
                         fill="${isFavorite ? 'currentColor' : 'none'}"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
                    </svg>
                </button>
            </form>`;
    } else {
        favoriteHtml = `
            <a href="javascript:void(0);"
               class="food-card-favorite-form food-card-favorite-btn"
               title="Login to add to Favorites"
               aria-label="Login to add to Favorites"
               data-bs-toggle="modal"
               data-bs-target="#loginModal">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="22" height="22" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0l-1.1 1.1-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
                </svg>
            </a>`;
    }

    return `
        <div class="col-lg-4 col-md-6 food-new-product">
            <div class="food-product-card">

                <div class="food-product-image">
                    ${imageHtml}
                    ${favoriteHtml}
                </div>

                <div class="food-product-info">
                    <span class="food-product-category">
                        ${escapeHtml(combo.category || 'Combo')}
                    </span>

                    <h5>${escapeHtml(combo.name)}</h5>

                    <p>${escapeHtml(description.substring(0, 100))}</p>

                    <div class="food-product-bottom">
                        <span class="food-product-price">
                            ₹${formatPrice(combo.price)}
                        </span>

                        <button type="button"
                                class="food-add-cart-button"
                                data-id="${Number(combo.id)}">
                            <i class="bi bi-cart-plus"></i>
                            <span>Add to Cart</span>
                        </button>

                        <a href="${escapeHtml(combo.url || '#')}"
                           class="food-product-button">
                            View Details
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>`;
}


    async function loadMoreCombos() {
        if (loading || currentPage >= lastPage) return;

        loading = true;
        showLoader();

        const nextPage = currentPage + 1;
        const url = new URL(@json(route('site.combos')), window.location.origin);

        url.searchParams.set('page', nextPage);

        if (categoryId) {
            url.searchParams.set('category_id', categoryId);
        }

        try {
            const response = await fetch(url.toString(), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Failed to load combos.');
            }

            const data = await response.json();

            if (Array.isArray(data.combos) && data.combos.length) {
                const emptyState = document.getElementById('foodInitialEmptyState');
                if (emptyState) emptyState.remove();

                data.combos.forEach(function (combo) {
                    productsContainer.insertAdjacentHTML(
                        'beforeend',
                        createComboCard(combo)
                    );
                });
            }

            currentPage = Number(data.current_page) || nextPage;
            lastPage = Number(data.last_page) || currentPage;

            if (!data.has_more || currentPage >= lastPage) {
                if (noMoreProducts) noMoreProducts.style.display = 'block';
            }
        } catch (error) {
            console.error('Combo infinite scroll error:', error);

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Unable to Load Combos',
                    text: 'Please check your connection and try again.',
                    confirmButtonColor: '#ff8c1a'
                });
            }
        } finally {
            loading = false;
            hideLoader();
        }
    }

    window.addEventListener('scroll', function () {
        if (loading || currentPage >= lastPage) return;

        const scrollPosition = window.innerHeight + window.scrollY;
        const pageHeight = document.documentElement.scrollHeight;

        if (scrollPosition >= pageHeight - 500) {
            loadMoreCombos();
        }
    }, { passive: true });

    /* =========================================================
       ADD TO CART + SWEETALERT2
    ========================================================= */

    document.addEventListener('click', async function (event) {
        const button = event.target.closest('.food-add-cart-button');

        if (!button || button.disabled) return;

        event.preventDefault();

        const productId = Number(button.dataset.id);

        if (!productId) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Combo Not Found',
                    text: 'Please refresh the page and try again.',
                    confirmButtonColor: '#ff8c1a'
                });
            } else {
                alert('Combo not found. Please refresh the page.');
            }
            return;
        }

        const originalHTML = button.innerHTML;

        button.disabled = true;
        button.innerHTML =
            '<i class="bi bi-hourglass-split"></i><span> Adding...</span>';

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
                    result.message || 'Could not add combo to cart.'
                );
            }

            if (result.cart_count !== undefined) {
                document.querySelectorAll(
                    '#headerCartCount, .header-cart-count'
                ).forEach(function (element) {
                    const count = Number(result.cart_count) || 0;
                    element.textContent = count;
                    element.style.display =
                        count > 0 ? 'inline-flex' : 'none';
                });

                if (typeof window.updateHeaderCartCount === 'function') {
                    window.updateHeaderCartCount(result.cart_count);
                }
            }

            button.innerHTML =
                '<i class="bi bi-check-circle"></i><span>Added</span>';

            if (typeof Swal !== 'undefined') {
                await Swal.fire({
                    icon: 'success',
                    title: 'Combo Added to Cart!',
                    text: result.message || 'Your combo was added successfully.',
                    confirmButtonText: 'Continue Shopping',
                    confirmButtonColor: '#ff8c1a',
                    timer: 2200,
                    timerProgressBar: true
                });
            } else {
                alert(result.message || 'Combo added to cart successfully.');
            }
        } catch (error) {
            console.error('Combo Add to Cart Error:', error);

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Could Not Add Combo',
                    text: error.message || 'Something went wrong. Please try again.',
                    confirmButtonColor: '#ff8c1a'
                });
            } else {
                alert(error.message || 'Something went wrong. Please try again.');
            }
        } finally {
            button.innerHTML = originalHTML;
            button.disabled = false;
        }
    });
});
</script>

@endsection