@extends('layouts.site-layout')

@section('title', 'My Favorites | Food Website')

@section('content')
<style>
/* Uses your website variables (--theme, --theme2, --bg ...) with safe fallbacks */
.food-favorites-page{--g:var(--theme,#00813d);--r:var(--theme2,#d12525);--dark:var(--header,#212121);--txt:var(--text,#5c5c5b);--ln:var(--border,#d9d9d9);--cream:var(--bg,#f4f1ea);min-height:80vh;padding:60px 0 80px!important;background:var(--cream)}
.food-favorites-page *{box-sizing:border-box}

/* ---------- Header ---------- */
.favorites-heading{margin-bottom:32px}
.favorites-eyebrow{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;background:#fff;border-radius:99px;box-shadow:0 2px 10px rgba(33,33,33,.06);color:var(--r);font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase}
.favorites-heading h2{color:var(--dark);font-size:clamp(30px,4.5vw,44px);font-weight:800;line-height:1.1}
.favorites-heading h2 span{color:var(--r)}
.favorites-heading p{color:var(--txt);font-size:15px;line-height:1.8}
.favorites-count{display:inline-flex;align-items:center;gap:8px;margin-top:12px;padding:5px 14px;background:#e6f4ec;border-radius:99px;color:var(--g);font-size:13px;font-weight:700}
.favorites-explore-btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:14px 24px;background:var(--g);border:0;border-radius:12px;color:#fff!important;text-decoration:none;font-size:14px;font-weight:700;box-shadow:0 8px 20px rgba(0,129,61,.22);transition:.25s}
.favorites-explore-btn:hover{background:var(--dark);transform:translateY(-2px)}

/* ---------- Alert ---------- */
.favorites-alert{border:0;border-radius:12px;padding:16px 20px;background:#e6f4ec;color:#00642f;font-weight:600}

/* ---------- Product card ---------- */
.food-product-card{height:100%;display:flex;flex-direction:column;overflow:hidden;background:#fff;border-radius:20px;box-shadow:0 8px 28px rgba(33,33,33,.06);transition:transform .25s,box-shadow .25s}
.food-product-card:hover{transform:translateY(-6px);box-shadow:0 16px 36px rgba(33,33,33,.12)}
.food-product-image{position:relative;height:235px;overflow:hidden;background:var(--cream)}
.food-product-image img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
.food-product-card:hover .food-product-image img{transform:scale(1.07)}
.food-product-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:14px}

/* Heart (remove from favorites) */
.food-card-favorite-form{position:absolute;top:12px;right:12px;z-index:2;margin:0}
.food-card-favorite-btn{width:42px;height:42px;display:flex;align-items:center;justify-content:center;padding:0;border:0;border-radius:50%;background:#fff;color:var(--r);cursor:pointer;box-shadow:0 4px 14px rgba(0,0,0,.14);transition:.25s}
.food-card-favorite-btn:hover{background:var(--r);color:#fff;transform:scale(1.08)}

.food-product-info{flex:1;display:flex;flex-direction:column;padding:20px}
.food-product-category{align-self:flex-start;padding:4px 12px;margin-bottom:10px;background:#e6f4ec;color:var(--g);border-radius:99px;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px}
.food-product-info h5{margin:0 0 8px;color:var(--dark);font-size:19px;font-weight:700;line-height:1.35}
.food-product-info p{flex-grow:1;margin:0 0 16px;color:var(--txt);font-size:14px;line-height:1.65;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

/* Price on top, two equal buttons below */
.food-product-bottom{margin-top:auto;display:flex;flex-direction:column;align-items:flex-start;gap:12px;padding-top:16px;border-top:1px dashed var(--ln)}
.food-product-price{color:var(--g);font-size:24px;font-weight:800;line-height:1}
.food-product-actions{display:flex;gap:8px;width:100%}
.food-product-button,.food-add-cart-button{flex:1;min-width:0;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:11px 8px;border-radius:10px;font-family:inherit;font-size:12.5px;font-weight:700;white-space:nowrap;text-decoration:none;cursor:pointer;transition:.25s}
.food-add-cart-button{border:2px solid var(--g);background:var(--g);color:#fff}
.food-add-cart-button:hover{background:var(--dark);border-color:var(--dark);color:#fff}
.food-add-cart-button:disabled{opacity:.7;cursor:not-allowed}
.food-product-button{border:2px solid var(--ln);background:#fff;color:var(--dark)!important}
.food-product-button:hover{border-color:var(--g);color:var(--g)!important}
.food-add-cart-button:focus-visible,.food-product-button:focus-visible,.food-card-favorite-btn:focus-visible{outline:3px solid rgba(0,129,61,.35);outline-offset:3px}

/* ---------- Empty state ---------- */
.favorites-empty{padding:60px 20px;background:#fff;border-radius:24px;box-shadow:0 8px 28px rgba(33,33,33,.06)}
.favorites-empty-icon{width:100px;height:100px;margin:0 auto 22px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#fbe7e7;color:var(--r)}
.favorites-empty h3{margin-bottom:12px;color:var(--dark);font-size:27px;font-weight:800}
.favorites-empty p{max-width:400px;margin:0 auto;color:var(--txt);line-height:1.8}

/* ---------- Pagination ---------- */
.favorites-pagination nav{display:flex;justify-content:center}
.favorites-pagination .pagination{gap:6px;flex-wrap:wrap}
.favorites-pagination .page-link{padding:10px 15px;border:0;border-radius:10px!important;background:#fff;color:var(--dark);box-shadow:0 2px 8px rgba(33,33,33,.06)}
.favorites-pagination .active .page-link{background:var(--g);color:#fff}

/* ---------- Mobile ---------- */
@media(max-width:767px){
    .food-favorites-page{padding:38px 0 55px!important}
    .favorites-heading{margin-bottom:24px}
    .favorites-explore-btn{width:100%}
    .food-product-image{height:215px}
    .food-product-info{padding:16px}
    .food-product-info h5{font-size:17px}
    .food-product-price{font-size:22px}
    .favorites-empty{padding:40px 18px}
    .favorites-empty h3{font-size:23px}
}
@media(max-width:360px){
    .food-product-actions{flex-direction:column}
    .food-product-button,.food-add-cart-button{width:100%}
}
</style>

<section class="food-favorites-page">
    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="favorites-heading d-flex justify-content-between align-items-center flex-wrap gap-4">

            <div>
                <span class="favorites-eyebrow">
                    <i class="fas fa-heart"></i>
                    Your personal collection
                </span>

                <h2 class="mt-3 mb-2">
                    My Favorites <span>&hearts;</span>
                </h2>

                <p class="mb-0">
                    Your cravings, your collection. All your favorite food in one place.
                </p>

                <div class="favorites-count">
                    <i class="fas fa-bookmark"></i>
                    {{ $favorites->total() }} saved items
                </div>
            </div>

            <a href="{{ route('site.products') }}" class="favorites-explore-btn">
                <i class="fas fa-utensils"></i>
                Explore Menu
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show favorites-alert mb-4" role="alert">

                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>

            </div>
        @endif

        {{-- FAVORITES GRID --}}
        @if($favorites->count() > 0)

            <div class="row g-4">

                @foreach($favorites as $favorite)

                    @php
                        $product = $favorite->product;
                    @endphp

                    @if($product && $product->status === 'Active')

                        <div class="col-xl-4 col-md-6">

                            <div class="food-product-card">

                                {{-- PRODUCT IMAGE --}}
                                <div class="food-product-image">

                                    @if($product->images->isNotEmpty() && $product->images->first()->image_path)

                                        <img
                                            src="{{ asset($product->images->first()->image_path) }}"
                                            alt="{{ $product->images->first()->alt_text ?: $product->name }}"
                                            loading="lazy">

                                    @else

                                        <div class="food-product-placeholder">
                                            <span>
                                                <i class="fas fa-utensils me-2"></i>
                                                Image coming soon
                                            </span>
                                        </div>

                                    @endif

                                    {{-- REMOVE FAVORITE --}}
                                    <form
                                        action="{{ route('favorites.destroy', $favorite->id) }}"
                                        method="POST"
                                        class="food-card-favorite-form"
                                        onsubmit="return confirm('Remove this product from Favorites?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="food-card-favorite-btn is-favorite"
                                            title="Remove from Favorites"
                                            aria-label="Remove {{ $product->name }} from Favorites">

                                            <i class="fas fa-heart fa-lg"></i>

                                        </button>

                                    </form>

                                </div>

                                {{-- PRODUCT DETAILS --}}
                                <div class="food-product-info">

                                    <span class="food-product-category">
                                        {{ $product->category->name ?? 'Food' }}
                                    </span>

                                    <h5>{{ $product->name }}</h5>

                                    <p>
                                        {{ \Illuminate\Support\Str::limit(
                                            $product->short_description ?: $product->description,
                                            100
                                        ) }}
                                    </p>

                                    {{-- PRICE --}}
                                    <div class="food-product-bottom">

                                        <span class="food-product-price">
                                            ₹{{ number_format((float) $product->price, 2) }}
                                        </span>

                                        {{-- ACTION BUTTONS --}}
                                        <div class="food-product-actions">
                                             {{-- ADD TO CART --}}
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
                                            
                                            {{-- VIEW DETAILS --}}
                                            <a
                                                href="{{ route('products.show', $product->slug) }}"
                                                class="food-product-button">

                                                <i class="bi bi-eye"></i>
                                                View Details

                                            </a>

                                           

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

            {{-- PAGINATION --}}
            <div class="favorites-pagination mt-5">
                {{ $favorites->links() }}
            </div>

        @else

            {{-- EMPTY FAVORITES --}}
            <div class="favorites-empty text-center">

                <div class="favorites-empty-icon">
                    <i class="far fa-heart fa-3x"></i>
                </div>

                <h3>Your Favorites List Is Empty</h3>

                <p>
                    Looks like you haven't saved any delicious food yet.
                    Explore our menu and tap the heart to save the dishes you love!
                </p>

                <a href="{{ route('site.products') }}" class="favorites-explore-btn mt-4">
                    <i class="fas fa-utensils"></i>
                    Discover Delicious Food
                    <i class="fas fa-arrow-right"></i>
                </a>

            </div>

        @endif

    </div>
</section>
<script>
document.addEventListener('click', async function (event) {
    const button = event.target.closest('.food-add-cart-button');

    if (!button || button.disabled) return;

    const productId = button.dataset.id;
    const originalHTML = button.innerHTML;

    if (!productId) {
        alert('Product ID missing.');
        return;
    }

    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split"></i> Adding...';

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
                product_id: Number(productId),
                quantity: 1
            })
        });

        const data = await response.json();

        if (!response.ok || data.success !== true) {
            throw new Error(
                data.message || 'Unable to add product to cart.'
            );
        }

        button.innerHTML = '<i class="bi bi-check-circle"></i> Added';

        if (typeof Swal !== 'undefined') {
            await Swal.fire({
                icon: 'success',
                title: 'Added to Cart!',
                text: data.message || 'Product added successfully.',
                confirmButtonColor: '#ff8c1a'
            });
        } else {
            alert(data.message || 'Product added to cart!');
        }

        if (data.cart_count !== undefined) {
            document.querySelectorAll(
                '#headerCartCount, .header-cart-count'
            ).forEach(function (counter) {
                counter.textContent = data.cart_count;
            });
        }

    } catch (error) {
        console.error('Add to cart error:', error);

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Cart Error',
                text: error.message,
                confirmButtonColor: '#ff8c1a'
            });
        } else {
            alert(error.message);
        }
    } finally {
        button.disabled = false;
        button.innerHTML = originalHTML;
    }
});
</script>


@endsection