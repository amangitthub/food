@extends('layouts.site-layout')

@section('title', 'Shopping Cart | Food Website')

@section('meta_description')
    Review your selected food items and manage your cart.
@endsection

@section('content')
<style>
/* Uses your website variables (--theme, --theme2, --bg ...) with safe fallbacks */
.food-cart-page{--g:var(--theme,#00813d);--r:var(--theme2,#d12525);--dark:var(--header,#212121);--txt:var(--text,#5c5c5b);--ln:var(--border,#d9d9d9);--cream:var(--bg,#f4f1ea);--soft:#e6f4ec;--sh:0 8px 30px rgba(33,33,33,.07);padding:70px 0;background:var(--cream)}
.food-cart-page *{box-sizing:border-box}

/* ---------- Header ---------- */
.food-cart-header{display:flex;align-items:center;justify-content:space-between;gap:25px;margin-bottom:30px}
.food-cart-header-left{display:flex;align-items:center;gap:16px}
.food-cart-header-icon{width:60px;height:60px;flex:none;display:flex;align-items:center;justify-content:center;border-radius:18px;background:var(--g);color:#fff;font-size:24px;box-shadow:0 10px 22px rgba(0,129,61,.25)}
.food-cart-label{display:block;color:var(--g);font-size:12px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase}
.food-cart-header h1{margin:2px 0 4px;color:var(--dark);font-size:clamp(26px,4vw,34px);font-weight:800}
.food-cart-header p{margin:0;color:var(--txt);font-size:14px}
.food-continue-btn{display:inline-flex;align-items:center;gap:8px;padding:11px 20px;background:#fff;border-radius:99px;box-shadow:0 2px 10px rgba(33,33,33,.06);color:var(--dark);text-decoration:none;font-size:14px;font-weight:700;transition:.25s}
.food-continue-btn:hover{background:var(--g);color:#fff}

/* ---------- Empty cart ---------- */
.food-empty-cart{padding:60px 25px;text-align:center;background:#fff;border-radius:22px;box-shadow:var(--sh)}
.food-empty-icon{width:84px;height:84px;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:var(--soft);color:var(--g);font-size:32px}
.food-empty-cart h2{color:var(--dark);font-weight:800}
.food-empty-cart p{margin-bottom:22px;color:var(--txt)}
.food-shop-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 24px;border-radius:12px;background:var(--g);color:#fff;text-decoration:none;font-weight:700;transition:.25s}
.food-shop-btn:hover{background:var(--dark);color:#fff}

/* ---------- Cards ---------- */
.food-cart-items-card,.food-checkout-card,.food-cart-summary{margin-bottom:20px;overflow:hidden;background:#fff;border-radius:20px;box-shadow:var(--sh)}
.food-cart-items-header{display:flex;align-items:center;justify-content:space-between;gap:15px;padding:20px 22px;border-bottom:1px dashed var(--ln)}
.food-cart-items-title,.food-checkout-card-header,.food-summary-title{display:flex;align-items:center;gap:12px}
.food-cart-items-title-icon,.food-checkout-icon,.food-summary-title-icon{width:44px;height:44px;flex:none;display:flex;align-items:center;justify-content:center;border-radius:12px;background:var(--soft);color:var(--g)}
.food-cart-items-header h3,.food-checkout-card-header h3,.food-summary-title h3{margin:0;color:var(--dark);font-size:18px;font-weight:800}
.food-cart-items-header span,.food-checkout-card-header p{color:var(--txt);font-size:13px}
.food-checkout-card{padding:24px}
.food-checkout-card-header{margin-bottom:22px}
.food-checkout-card-header p{margin:3px 0 0}
.food-clear-cart{border:0;background:none;color:var(--r);font-size:13px;font-weight:700;cursor:pointer}
.food-clear-cart:hover{text-decoration:underline}

/* ---------- Cart items ---------- */
.food-cart-item{display:grid;grid-template-columns:minmax(180px,1fr) auto auto 36px;align-items:center;gap:16px;padding:18px 22px;border-bottom:1px dashed var(--ln)}
.food-cart-item:last-child{border-bottom:0}
.food-cart-product{display:flex;align-items:center;gap:14px;min-width:0}
.food-cart-image{width:72px;height:72px;flex:0 0 72px;overflow:hidden;border-radius:14px;background:var(--cream)}
.food-cart-image img{width:100%;height:100%;object-fit:cover}
.food-cart-no-image{height:100%;display:flex;align-items:center;justify-content:center;color:var(--g);font-size:22px}
.food-cart-product-info{min-width:0}
.food-cart-product-info h4{margin:0 0 5px;color:var(--dark);font-size:15.5px;font-weight:700;overflow-wrap:anywhere}
.food-cart-product-info span{color:var(--txt);font-size:13px}
.food-cart-quantity{display:flex;align-items:center;gap:12px;padding:4px;background:var(--cream);border-radius:12px;font-weight:700;color:var(--dark)}
.cart-qty-btn{width:32px;height:32px;border:0;border-radius:9px;background:#fff;color:var(--dark);font-size:18px;cursor:pointer;box-shadow:0 1px 4px rgba(33,33,33,.1);transition:.2s}
.cart-qty-btn:hover{background:var(--g);color:#fff}
.cart-qty-btn:disabled{opacity:.5;cursor:not-allowed}
.food-cart-item-total{text-align:right;white-space:nowrap}
.food-cart-item-total strong{color:var(--dark);font-size:16px;font-weight:800}
.food-remove-item{width:36px;height:36px;border:0;border-radius:10px;background:#fbe7e7;color:var(--r);cursor:pointer;transition:.2s}
.food-remove-item:hover{background:var(--r);color:#fff}

/* ---------- Forms ---------- */
.food-form-label{display:block;margin-bottom:7px;color:var(--dark);font-size:13px;font-weight:700}
.food-form-label span{color:var(--r)}
.food-form-input,.food-address-select{width:100%;min-height:48px;padding:11px 14px;border:1px solid var(--ln);border-radius:12px;outline:none;background:#fff;color:var(--dark);font-size:14px;transition:.25s}
.food-form-input:focus,.food-address-select:focus{border-color:var(--g);box-shadow:0 0 0 4px rgba(0,129,61,.12)}
textarea.food-form-input{min-height:78px;resize:vertical}
/* keeps typed text always visible */
.food-form-input,.food-form-input:focus{color:var(--dark)!important;background:#fff!important;-webkit-text-fill-color:var(--dark)!important;opacity:1!important;visibility:visible!important}

/* ---------- Saved addresses ---------- */
.food-saved-address-list{display:grid;gap:12px;margin:16px 0 20px}
.food-saved-address-card{display:flex;align-items:flex-start;gap:12px;padding:16px;background:#fff;border:2px solid var(--cream);border-radius:14px;transition:.2s}
.food-saved-address-card.is-default{border-color:#cfe8d9;background:#f7fbf8}
.food-saved-address-card.is-selected{border-color:var(--g);background:#f1f9f4}
.food-saved-address-card>div:first-child{color:var(--g)!important}  /* overrides the old inline orange icon color */
.food-saved-address-details{flex:1;min-width:0;overflow-wrap:anywhere}
.food-saved-address-details strong{display:block;margin-bottom:5px;color:var(--dark);font-size:14.5px}
.food-saved-address-details p{margin:0;color:var(--txt);font-size:13px;line-height:1.7}
.food-address-badge{display:inline-block;margin-top:8px;padding:3px 11px;border-radius:99px;background:var(--soft);color:var(--g);font-size:11px;font-weight:700}
.food-no-saved-addresses{padding:18px;border:1px dashed var(--ln);border-radius:12px;color:var(--txt);font-size:13px;text-align:center}
.food-use-address,.food-new-address-btn{border:2px solid var(--g);background:#fff;color:var(--g);font-weight:700;cursor:pointer;transition:.2s}
.food-use-address{flex:none;padding:7px 14px;border-radius:9px;font-size:12px}
.food-new-address-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:10px;font-size:13px}
.food-use-address:hover,.food-use-address.active,.food-new-address-btn:hover{background:var(--g);color:#fff}
#newAddressForm[hidden]{display:none!important}
.food-checkout-card a.d-inline-block{color:var(--g)!important}  /* overrides the old inline orange link */

/* ---------- Payment ---------- */
.food-payment-methods{display:grid;gap:12px}
.food-payment-option{display:flex;align-items:center;gap:13px;padding:16px;border:2px solid var(--g);background:#f7fbf8;border-radius:14px;cursor:pointer}
.food-payment-option input{accent-color:var(--g);width:18px;height:18px}
.food-payment-content{flex:1}
.food-payment-content strong{display:block;color:var(--dark);font-size:14.5px}
.food-payment-content small{color:var(--txt);font-size:12.5px}
.food-payment-option>i{color:var(--g);font-size:20px}

/* ---------- Order summary ---------- */
.food-cart-summary{position:sticky;top:95px}
.food-summary-top{padding:20px 22px;border-bottom:1px dashed var(--ln)}
.food-summary-body{padding:22px}
.food-summary-row{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px;color:var(--txt);font-size:14px}
.food-summary-row strong{color:var(--dark)}
.food-free{color:var(--g)!important}
.food-summary-divider{height:0;margin:18px 0;border-top:1px dashed var(--ln)}
.food-summary-total{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:20px}
.food-summary-total span{color:var(--dark);font-weight:800}
.food-summary-total strong{color:var(--g);font-size:26px;font-weight:800}
.food-mini-checkout-info{margin-bottom:18px;padding:15px;background:var(--cream);border-radius:14px}
.food-mini-info-title{margin-bottom:10px;color:var(--dark);font-size:13px;font-weight:800}
.food-mini-info-title i{margin-right:6px;color:var(--g)}
.food-mini-info-row{display:flex;justify-content:space-between;gap:12px;margin-top:8px;color:var(--txt);font-size:12.5px}
.food-mini-info-row strong{max-width:65%;overflow:hidden;color:var(--dark);text-align:right;text-overflow:ellipsis;white-space:nowrap}
.food-checkout-btn{width:100%;min-height:54px;display:flex;align-items:center;justify-content:center;gap:10px;border:0;border-radius:12px;background:var(--g);color:#fff;font-size:16px;font-weight:800;cursor:pointer;box-shadow:0 10px 22px rgba(0,129,61,.25);transition:.25s}
.food-checkout-btn:hover{background:var(--dark)}
.food-checkout-btn:disabled{opacity:.6;cursor:not-allowed}
.food-secure-text{margin-top:12px;color:var(--txt);text-align:center;font-size:12px}
.food-secure-text i{color:var(--g)}

/* ---------- Responsive ---------- */
@media(max-width:991px){
    .food-cart-header{align-items:flex-start;flex-direction:column}
    .food-cart-summary{position:static}
}
@media(max-width:767px){
    .food-cart-page{padding:40px 0}
    .food-cart-item{grid-template-columns:1fr auto;gap:12px;padding:16px}
    .food-cart-product{grid-column:1/-1}
    .food-cart-item-total{text-align:left}
    .food-checkout-card{padding:18px}
    .food-cart-items-header{padding:16px}
}
@media(max-width:480px){
    .food-cart-header-left{align-items:flex-start}
    .food-cart-header-icon{width:48px;height:48px;flex-basis:48px;font-size:20px}
    .food-cart-image{width:60px;height:60px;flex-basis:60px}
    .food-saved-address-card{flex-wrap:wrap}
    .food-use-address{margin-left:auto}
    .food-summary-body{padding:18px}
}

/* ---------- Recommended products ---------- */
.food-recommendations{padding:42px 0 8px}
.food-recommendations-header{display:flex;align-items:end;justify-content:space-between;gap:15px;margin-bottom:22px}
.food-recommendations-kicker{display:block;color:var(--theme,#00813d);font-size:12px;font-weight:800;letter-spacing:1.1px;text-transform:uppercase;margin-bottom:5px}
.food-recommendations-header h2{margin:0;color:var(--header,#212121);font-size:clamp(23px,3vw,30px);font-weight:800}
.food-recommendations-header p{margin:6px 0 0;color:var(--text,#5c5c5b);font-size:14px}
.food-recommendation-card{height:100%;background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 8px 28px rgba(33,33,33,.07);transition:transform .25s,box-shadow .25s}
.food-recommendation-card:hover{transform:translateY(-5px);box-shadow:0 14px 32px rgba(33,33,33,.12)}
.food-recommendation-image{display:block;aspect-ratio:4/3;background:#f4f1ea;overflow:hidden}
.food-recommendation-image img{width:100%;height:100%;object-fit:cover;transition:transform .35s}
.food-recommendation-card:hover .food-recommendation-image img{transform:scale(1.05)}
.food-recommendation-body{padding:16px}
.food-recommendation-body h3{font-size:16px;font-weight:800;margin:0 0 8px;line-height:1.4}
.food-recommendation-body h3 a{color:#212121;text-decoration:none}
.food-recommendation-price{font-size:17px;font-weight:800;color:var(--theme,#00813d);margin-bottom:13px}
.food-recommendation-add{width:100%;border:0;border-radius:10px;padding:11px 12px;background:var(--theme,#00813d);color:#fff;font-weight:700;cursor:pointer;transition:.2s}
.food-recommendation-add:hover{background:#212121;color:#fff}
.food-recommendation-add:disabled{opacity:.65;cursor:wait}
@media(max-width:575px){.food-recommendations{padding-top:30px}.food-recommendation-body{padding:12px}.food-recommendation-body h3{font-size:14px}.food-recommendation-price{font-size:15px}}

</style>

<section class="food-cart-page">
    <div class="container">

        <div class="food-cart-header">
            <div class="food-cart-header-left">
                <div class="food-cart-header-icon"><i class="fa fa-shopping-basket"></i></div>
                <div>
                    <span class="food-cart-label">Your Order</span>
                    <h1>Shopping Cart</h1>
                    <p>Review your delicious selections before checkout.</p>
                </div>
            </div>

            <a href="{{ route('site.products') }}" class="food-continue-btn">
                <i class="fa fa-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <div id="emptyCart" class="food-empty-cart" style="display:none">
            <div class="food-empty-icon"><i class="fa fa-shopping-basket"></i></div>
            <h2>Your Cart is Empty</h2>
            <p>Looks like you haven't added any delicious food yet.</p>
            <a href="{{ route('site.products') }}" class="food-shop-btn">
                <i class="fa fa-utensils"></i> Explore Menu
            </a>
        </div>

        <div id="cartContent" class="row g-4 align-items-start" style="display:none">

            <div class="col-12 col-lg-8 food-cart-left">

                {{-- CART ITEMS --}}
                <div class="food-cart-items-card">
                    <div class="food-cart-items-header">
                        <div class="food-cart-items-title">
                            <div class="food-cart-items-title-icon"><i class="fa fa-shopping-bag"></i></div>
                            <div>
                                <h3>Your Items</h3>
                                <span id="cartItemText">0 items</span>
                            </div>
                        </div>
                        <button type="button" id="clearCartBtn" class="food-clear-cart">
                            <i class="fa fa-trash"></i> Clear Cart
                        </button>
                    </div>
                    <div id="cartItems"></div>
                </div>

                {{-- CUSTOMER DETAILS --}}
                <div class="food-checkout-card">
                    <div class="food-checkout-card-header">
                        <div class="food-checkout-icon"><i class="fa fa-user"></i></div>
                        <div>
                            <h3>Customer Details</h3>
                            <p>Enter your contact information for delivery.</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="customerName" class="food-form-label">Full Name <span>*</span></label>
                            <input type="text" id="customerName" class="food-form-input"
                                   placeholder="Enter your full name" autocomplete="name"
                                   value="{{ old('name', auth()->user()->name ?? '') }}">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="customerEmail" class="food-form-label">Email Address <span>*</span></label>
                            <input type="email" id="customerEmail" class="food-form-input"
                                   placeholder="Enter your email" autocomplete="email"
                                   value="{{ old('email', auth()->user()->email ?? '') }}">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="customerPhone" class="food-form-label">Phone Number <span>*</span></label>
                            <input type="tel" id="customerPhone" class="food-form-input"
                                   placeholder="Enter your phone number" maxlength="15" autocomplete="tel"
                                   value="{{ old('mobile', auth()->user()->mobile ?? '') }}">
                        </div>
                    </div>
                </div>

                {{-- DELIVERY ADDRESS --}}
                <div class="food-checkout-card">
                    <div class="food-checkout-card-header">
                        <div class="food-checkout-icon"><i class="fa fa-map-marker-alt"></i></div>
                        <div>
                            <h3>Delivery Address</h3>
                            <p>Select a saved address or add a new one.</p>
                        </div>
                    </div>

                    @auth
                        <div class="mb-3">
                            <label for="savedAddressSelect" class="food-form-label">Select Delivery Address</label>
                            <select id="savedAddressSelect" class=" food-address-select"> {{-- class:food-form-input --}}
                                <option value="">-- Select an Address --</option>
                                @foreach(($addresses ?? collect()) as $savedAddress)
                                    <option
                                        value="{{ $savedAddress->id }}"
                                        data-name="{{ $savedAddress->name }}"
                                        data-mobile="{{ $savedAddress->mobile }}"
                                        data-address="{{ $savedAddress->address }}"
                                        data-city="{{ $savedAddress->city }}"
                                        data-state="{{ $savedAddress->state }}"
                                        data-pincode="{{ $savedAddress->pincode }}"
                                        data-country="{{ $savedAddress->country }}"
                                        @selected($savedAddress->is_default === 'Yes')
                                    >
                                        {{ $savedAddress->name }} - {{ $savedAddress->address }}
                                        @if($savedAddress->city), {{ $savedAddress->city }}@endif
                                        @if($savedAddress->is_default === 'Yes') (Default) @endif
                                    </option>
                                @endforeach
                                <option value="new">+ Add New Address</option>
                            </select>

                            <a href="{{ route('addresses.index') }}"
                               class="d-inline-block mt-2"
                               style="color:#ff8c1a;font-weight:600;font-size:13px">
                                <i class="fa fa-cog"></i> Manage Saved Addresses
                            </a>
                        </div>

                        {{-- SAVED ADDRESS CARDS --}}
                        <div class=" food-saved-address-list" id="savedAddressList">
                            @forelse(($addresses ?? collect()) as $savedAddress)
                                <div class="food-saved-address-card {{ $savedAddress->is_default === 'Yes' ? 'is-default' : '' }}"
                                     data-address-card="{{ $savedAddress->id }}">
                                    <div style="color:#ff8c1a;font-size:21px">
                                        <i class="fa fa-map-marker-alt"></i>
                                    </div>

                                    <div class="food-saved-address-details">
                                        <strong>
                                            {{ $savedAddress->name }} · {{ $savedAddress->mobile }}
                                        </strong>
                                        <p>
                                            {{ $savedAddress->address }}
                                            @if($savedAddress->city), {{ $savedAddress->city }}@endif
                                            @if($savedAddress->state), {{ $savedAddress->state }}@endif
                                            @if($savedAddress->pincode) - {{ $savedAddress->pincode }}@endif
                                            @if($savedAddress->country), {{ $savedAddress->country }}@endif
                                        </p>
                                        @if($savedAddress->is_default === 'Yes')
                                            <span class="food-address-badge">Default Address</span>
                                        @endif
                                    </div>

                                    <button type="button"
                                            class="food-use-address useSavedAddress"
                                            data-address-id="{{ $savedAddress->id }}">
                                        Use Address
                                    </button>
                                </div>
                            @empty
                                <div class="food-no-saved-addresses" id="noSavedAddresses">
                                    No saved addresses yet. Add your first delivery address below.
                                </div>
                            @endforelse
                        </div>

                        <button type="button" id="showNewAddressBtn" class="food-new-address-btn">
                            <i class="fa fa-plus"></i> Add New Address
                        </button>
                    @endauth

                    {{-- NEW ADDRESS FORM --}}
                    <div id="newAddressForm" @auth hidden @endauth>
                        <div class="row g-3">

                            <div class="col-12">
                                <label for="deliveryName" class="food-form-label">Full Name <span>*</span></label>
                                <input type="text" id="deliveryName" class="food-form-input"
                                       value="{{ auth()->user()->name ?? '' }}" placeholder="Enter full name">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="deliveryPhone" class="food-form-label">Mobile Number <span>*</span></label>
                                <input type="tel" id="deliveryPhone" class="food-form-input"
                                       value="{{ auth()->user()->mobile ?? '' }}" maxlength="15"
                                       placeholder="Enter mobile number">
                            </div>

                            <div class="col-12">
                                <label for="customerAddress" class="food-form-label">Full Address <span>*</span></label>
                                <textarea id="customerAddress" class="food-form-input" rows="2"
                                          placeholder="House / Flat No., Street, Area"></textarea>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="customerCity" class="food-form-label">City <span>*</span></label>
                                <input type="text" id="customerCity" class="food-form-input" placeholder="Enter city">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="customerState" class="food-form-label">State <span>*</span></label>
                                <input type="text" id="customerState" class="food-form-input" placeholder="Enter state">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="customerPincode" class="food-form-label">Pincode <span>*</span></label>
                                <input type="text" id="customerPincode" class="food-form-input"
                                       maxlength="6" placeholder="Enter pincode">
                            </div>

                            @auth
                                <div class="col-12">
                                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600">
                                        <input type="checkbox" id="saveNewAddress" checked>
                                        Save this address to my account
                                    </label>
                                </div>
                            @endauth

                            <div class="col-12">
                                <button type="button" id="cancelNewAddressBtn"
                                        class="food-new-address-btn">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PAYMENT --}}
                <div class="food-checkout-card">
                    <div class="food-checkout-card-header">
                        <div class="food-checkout-icon"><i class="fa fa-credit-card"></i></div>
                        <div>
                            <h3>Payment Method</h3>
                            <p>Select your preferred payment method.</p>
                        </div>
                    </div>

                    <div class="food-payment-methods">
                        <label class="food-payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span class="food-payment-content">
                                <strong>Cash on Delivery</strong>
                                <small>Pay when your order arrives.</small>
                            </span>
                            <i class="fa fa-money-bill-wave"></i>
                        </label>
                    </div>
                </div>
            </div>

            {{-- ORDER SUMMARY --}}
            <div class="col-12 col-lg-4 food-cart-right">
                <div class="food-cart-summary">
                    <div class="food-summary-top">
                        <div class="food-summary-title">
                            <div class="food-summary-title-icon"><i class="fa fa-receipt"></i></div>
                            <h3>Order Summary</h3>
                        </div>
                    </div>

                    <div class="food-summary-body">
                        <div class="food-summary-row"><span>Items</span><strong id="summaryItems">0</strong></div>
                        <div class="food-summary-row"><span>Subtotal</span><strong id="summarySubtotal">₹0.00</strong></div>
                        <div class="food-summary-row"><span>Delivery</span><strong class="food-free">FREE</strong></div>
                        <div class="food-summary-divider"></div>
                        <div class="food-summary-total"><span>Total</span><strong id="summaryTotal">₹0.00</strong></div>

                        <div class="food-mini-checkout-info">
                            <div class="food-mini-info-title"><i class="fa fa-user"></i> Customer Information</div>
                            <div class="food-mini-info-row"><span>Name</span><strong id="summaryCustomerName">Not entered</strong></div>
                            <div class="food-mini-info-row"><span>Phone</span><strong id="summaryCustomerPhone">Not entered</strong></div>
                        </div>

                        <button type="button" class="food-checkout-btn" id="checkoutBtn">
                            Place Order <i class="fa fa-arrow-right"></i>
                        </button>

                        <div class="food-secure-text"><i class="fa fa-shield-alt"></i> Secure &amp; safe ordering</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- RANDOM PRODUCT RECOMMENDATIONS --}}
@if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())
<section class="food-recommendations">
    <div class="container">
        <div class="food-recommendations-header">
            <div>
                <span class="food-recommendations-kicker">Picked for you</span>
                <h2>You May Also Like</h2>
                <p>Discover something delicious to add to your order.</p>
            </div>
            <a href="{{ route('site.products') }}" class="food-continue-btn">View Menu <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="row g-3 g-md-4">
            @foreach($recommendedProducts as $recommendedProduct)
                @php
                    $recommendedImage = $recommendedProduct->images->first();
                    $recommendedImagePath = $recommendedImage->image_path ?? null;
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <article class="food-recommendation-card">
                        <a class="food-recommendation-image" href="{{ route('products.show', $recommendedProduct->slug) }}">
                            @if($recommendedImagePath)
                                <img src="{{ asset($recommendedImagePath) }}" alt="{{ $recommendedImage->alt_text ?: $recommendedProduct->name }}" loading="lazy">
                            @else
                                <img src="{{ asset('assets/img/food/delicious-burger.png') }}" alt="{{ $recommendedProduct->name }}" loading="lazy">
                            @endif
                        </a>
                        <div class="food-recommendation-body">
                            <h3><a href="{{ route('products.show', $recommendedProduct->slug) }}">{{ $recommendedProduct->name }}</a></h3>
                            <div class="food-recommendation-price">₹{{ number_format((float) $recommendedProduct->price, 2) }}</div>
                            <button type="button" class="food-recommendation-add" data-product-id="{{ $recommendedProduct->id }}">
                                <i class="fa fa-shopping-basket"></i> Add to Cart
                            </button>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <div id="recommendationMessage" role="status" aria-live="polite" style="margin-top:12px;font-size:13px"></div>
    </div>
</section>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const isLoggedIn = @json(auth()->check());
    let cart = @json($cartItems ?? []);

    cart = cart.map(function (item) {
        const product = item.product || {};
        return {
            id: item.id || null,
            product_id: item.product_id || product.id || null,
            quantity: Number(item.quantity || 1),
            product: product
        };
    });

    const emptyCart = document.getElementById('emptyCart');
    const cartContent = document.getElementById('cartContent');
    const cartItemsContainer = document.getElementById('cartItems');
    const cartItemText = document.getElementById('cartItemText');
    const clearCartBtn = document.getElementById('clearCartBtn');

    const summaryItems = document.getElementById('summaryItems');
    const summarySubtotal = document.getElementById('summarySubtotal');
    const summaryTotal = document.getElementById('summaryTotal');
    const summaryCustomerName = document.getElementById('summaryCustomerName');
    const summaryCustomerPhone = document.getElementById('summaryCustomerPhone');

    const customerName = document.getElementById('customerName');
    const customerEmail = document.getElementById('customerEmail');
    const customerPhone = document.getElementById('customerPhone');

    const deliveryName = document.getElementById('deliveryName');
    const deliveryPhone = document.getElementById('deliveryPhone');
    const customerAddress = document.getElementById('customerAddress');
    const customerCity = document.getElementById('customerCity');
    const customerState = document.getElementById('customerState');
    const customerPincode = document.getElementById('customerPincode');

    const checkoutBtn = document.getElementById('checkoutBtn');
    const savedAddressSelect = document.getElementById('savedAddressSelect');
    const savedAddressList = document.getElementById('savedAddressList');
    const newAddressForm = document.getElementById('newAddressForm');
    const saveNewAddress = document.getElementById('saveNewAddress');
    const showNewAddressBtn = document.getElementById('showNewAddressBtn');
    const cancelNewAddressBtn = document.getElementById('cancelNewAddressBtn');

    function formatPrice(price) {
        return '₹' + Number(price || 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function escapeHtml(value) {
        if (value === null || value === undefined) return '';
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function updateHeaderCartCount(count) {
        document.querySelectorAll('.header-cart-count').forEach(function (element) {
            element.textContent = Number(count || 0);
            element.style.display = Number(count || 0) > 0 ? 'inline-flex' : 'none';
        });
    }

    function updateCustomerSummary() {
        if (summaryCustomerName) {
            summaryCustomerName.textContent = customerName?.value?.trim() || 'Not entered';
        }
        if (summaryCustomerPhone) {
            summaryCustomerPhone.textContent = customerPhone?.value?.trim() || 'Not entered';
        }
    }

    function syncDeliveryContactToCustomer() {
        if (deliveryName && customerName) customerName.value = deliveryName.value;
        if (deliveryPhone && customerPhone) customerPhone.value = deliveryPhone.value;
        updateCustomerSummary();
    }

    function clearDeliveryAddress() {
        if (customerAddress) customerAddress.value = '';
        if (customerCity) customerCity.value = '';
        if (customerState) customerState.value = '';
        if (customerPincode) customerPincode.value = '';
    }

    function fillSavedAddress(option) {
        if (!option) return;

        const data = option.dataset;

        if (deliveryName) deliveryName.value = data.name || '';
        if (deliveryPhone) deliveryPhone.value = data.mobile || '';
        if (customerAddress) customerAddress.value = data.address || '';
        if (customerCity) customerCity.value = data.city || '';
        if (customerState) customerState.value = data.state || '';
        if (customerPincode) customerPincode.value = data.pincode || '';

        syncDeliveryContactToCustomer();
        highlightSelectedAddress(option.value);
    }

    function highlightSelectedAddress(id) {
        document.querySelectorAll('[data-address-card]').forEach(function (card) {
            const selected = String(card.dataset.addressCard) === String(id);
            card.classList.toggle('is-selected', selected);
            const button = card.querySelector('.useSavedAddress');
            if (button) {
                button.classList.toggle('active', selected);
                button.textContent = selected ? 'Selected' : 'Use Address';
            }
        });
    }

    function selectSavedAddress(id) {
        if (!savedAddressSelect) return;

        savedAddressSelect.value = String(id);
        const option = savedAddressSelect.options[savedAddressSelect.selectedIndex];

        if (!option || option.value === '' || option.value === 'new') return;

        if (newAddressForm) newAddressForm.hidden = true;
        if (showNewAddressBtn) showNewAddressBtn.style.display = 'inline-flex';
        if (saveNewAddress) saveNewAddress.checked = false;

        fillSavedAddress(option);
    }

    function showNewAddressForm() {
        if (savedAddressSelect) savedAddressSelect.value = 'new';
        if (newAddressForm) newAddressForm.hidden = false;
        if (showNewAddressBtn) showNewAddressBtn.style.display = 'none';
        if (saveNewAddress) saveNewAddress.checked = true;

        if (deliveryName && !deliveryName.value) {
            deliveryName.value = customerName?.value || @json(auth()->user()->name ?? '');
        }
        if (deliveryPhone && !deliveryPhone.value) {
            deliveryPhone.value = customerPhone?.value || @json(auth()->user()->mobile ?? '');
        }

        clearDeliveryAddress();
        syncDeliveryContactToCustomer();
    }

    if (savedAddressSelect) {
        savedAddressSelect.addEventListener('change', function () {
            const selectedValue = this.value;

            if (selectedValue === 'new') {
                showNewAddressForm();
                return;
            }

            if (selectedValue === '') {
                if (newAddressForm) newAddressForm.hidden = false;
                if (showNewAddressBtn) showNewAddressBtn.style.display = 'none';
                if (saveNewAddress) saveNewAddress.checked = false;
                clearDeliveryAddress();
                if (deliveryName) deliveryName.value = customerName?.value || '';
                if (deliveryPhone) deliveryPhone.value = customerPhone?.value || '';
                highlightSelectedAddress('');
                return;
            }

            fillSavedAddress(this.options[this.selectedIndex]);
            if (newAddressForm) newAddressForm.hidden = true;
            if (showNewAddressBtn) showNewAddressBtn.style.display = 'inline-flex';
            if (saveNewAddress) saveNewAddress.checked = false;
        });

        const initialOption = Array.from(savedAddressSelect.options).find(function (option) {
            return option.value !== '' && option.value !== 'new' && option.hasAttribute('selected');
        });

        const firstSavedOption = Array.from(savedAddressSelect.options).find(function (option) {
            return option.value !== '' && option.value !== 'new';
        });

        if (initialOption) {
            selectSavedAddress(initialOption.value);
        } else if (firstSavedOption) {
            selectSavedAddress(firstSavedOption.value);
        } else {
            savedAddressSelect.value = '';
            if (newAddressForm) newAddressForm.hidden = false;
            if (showNewAddressBtn) showNewAddressBtn.style.display = 'none';
        }
    }

    if (savedAddressList) {
        savedAddressList.addEventListener('click', function (event) {
            const button = event.target.closest('.useSavedAddress');
            if (!button) return;

            selectSavedAddress(button.dataset.addressId);
        });
    }

    if (showNewAddressBtn) {
        showNewAddressBtn.addEventListener('click', showNewAddressForm);
    }

    if (cancelNewAddressBtn) {
        cancelNewAddressBtn.addEventListener('click', function () {
            const selected = savedAddressSelect?.options[savedAddressSelect.selectedIndex];

            if (selected && selected.value !== '' && selected.value !== 'new') {
                selectSavedAddress(selected.value);
            } else {
                if (newAddressForm) newAddressForm.hidden = true;
                if (showNewAddressBtn) showNewAddressBtn.style.display = 'inline-flex';
                if (savedAddressSelect) savedAddressSelect.value = '';
            }
        });
    }

    if (deliveryName) {
        deliveryName.addEventListener('input', syncDeliveryContactToCustomer);
    }
    if (deliveryPhone) {
        deliveryPhone.addEventListener('input', syncDeliveryContactToCustomer);
    }
    if (customerName) customerName.addEventListener('input', updateCustomerSummary);
    if (customerPhone) customerPhone.addEventListener('input', updateCustomerSummary);

    function addSavedAddressCard(address) {
        if (!savedAddressList || !address) return;

        const noAddresses = document.getElementById('noSavedAddresses');
        if (noAddresses) noAddresses.remove();

        const card = document.createElement('div');
        card.className = 'food-saved-address-card';
        card.dataset.addressCard = address.id;

        const icon = document.createElement('div');
        icon.style.cssText = 'color:#ff8c1a;font-size:21px';
        icon.innerHTML = '<i class="fa fa-map-marker-alt"></i>';

        const details = document.createElement('div');
        details.className = 'food-saved-address-details';

        const title = document.createElement('strong');
        title.textContent = `${address.name || ''} · ${address.mobile || ''}`;

        const paragraph = document.createElement('p');
        paragraph.textContent = [
            address.address,
            address.city,
            address.state,
            address.pincode ? '- ' + address.pincode : '',
            address.country
        ].filter(Boolean).join(', ');

        details.appendChild(title);
        details.appendChild(paragraph);

        if (address.is_default === 'Yes') {
            card.classList.add('is-default');
            const badge = document.createElement('span');
            badge.className = 'food-address-badge';
            badge.textContent = 'Default Address';
            details.appendChild(badge);
        }

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'food-use-address useSavedAddress';
        button.dataset.addressId = address.id;
        button.textContent = 'Use Address';

        card.append(icon, details, button);
        savedAddressList.prepend(card);
    }

    function addAddressToDropdown(address) {
        if (!savedAddressSelect || !address) return null;

        let option = Array.from(savedAddressSelect.options).find(function (item) {
            return String(item.value) === String(address.id);
        });

        if (!option) {
            option = document.createElement('option');
            option.value = address.id;

            const newOption = Array.from(savedAddressSelect.options).find(function (item) {
                return item.value === 'new';
            });

            savedAddressSelect.insertBefore(option, newOption || null);
        }

        option.textContent = `${address.name || ''} - ${address.address || ''}${address.city ? ', ' + address.city : ''}`;
        option.dataset.name = address.name || '';
        option.dataset.mobile = address.mobile || '';
        option.dataset.address = address.address || '';
        option.dataset.city = address.city || '';
        option.dataset.state = address.state || '';
        option.dataset.pincode = address.pincode || '';
        option.dataset.country = address.country || 'India';

        return option;
    }

    function renderCart() {
        if (!cart || cart.length === 0) {
            if (emptyCart) emptyCart.style.display = 'block';
            if (cartContent) cartContent.style.display = 'none';
            if (cartItemText) cartItemText.textContent = '0 items';
            if (summaryItems) summaryItems.textContent = '0';
            if (summarySubtotal) summarySubtotal.textContent = '₹0.00';
            if (summaryTotal) summaryTotal.textContent = '₹0.00';
            updateHeaderCartCount(0);
            return;
        }

        if (emptyCart) emptyCart.style.display = 'none';
        if (cartContent) cartContent.style.display = '';
        if (!cartItemsContainer) return;

        let html = '';
        let subtotal = 0;
        let totalQuantity = 0;

        cart.forEach(function (item, index) {
            const product = item.product || {};
            const productId = Number(item.product_id || product.id || 0);
            const productName = product.name || 'Product';
            const price = Number(product.price || 0);
            const quantity = Number(item.quantity || 1);
            const itemTotal = price * quantity;

            subtotal += itemTotal;
            totalQuantity += quantity;

            let imageHtml = '<div class="food-cart-no-image"><i class="fa fa-utensils"></i></div>';

            if (Array.isArray(product.images) && product.images.length && product.images[0].image_path) {
                const imageUrl = "{{ asset('') }}" + product.images[0].image_path;
                imageHtml = `<img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(productName)}"
                    onerror="this.style.display='none';">`;
            } else if (product.image) {
                imageHtml = `<img src="${escapeHtml(product.image)}" alt="${escapeHtml(productName)}">`;
            }

            html += `
                <div class="food-cart-item" data-index="${index}" data-product-id="${productId}">
                    <div class="food-cart-product">
                        <div class="food-cart-image">${imageHtml}</div>
                        <div class="food-cart-product-info">
                            <h4>${escapeHtml(productName)}</h4>
                            <span>${formatPrice(price)} each</span>
                        </div>
                    </div>
                    <div class="food-cart-quantity">
                        <button type="button" class="cart-qty-btn decreaseQty" data-index="${index}" aria-label="Decrease quantity">−</button>
                        <span>${quantity}</span>
                        <button type="button" class="cart-qty-btn increaseQty" data-index="${index}" aria-label="Increase quantity">+</button>
                    </div>
                    <div class="food-cart-item-total"><strong>${formatPrice(itemTotal)}</strong></div>
                    <button type="button" class="food-remove-item removeCartItem" data-index="${index}" aria-label="Remove product">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = html;

        if (cartItemText) cartItemText.textContent = `${totalQuantity} ${totalQuantity === 1 ? 'item' : 'items'}`;
        if (summaryItems) summaryItems.textContent = `${totalQuantity} ${totalQuantity === 1 ? 'item' : 'items'}`;
        if (summarySubtotal) summarySubtotal.textContent = formatPrice(subtotal);
        if (summaryTotal) summaryTotal.textContent = formatPrice(subtotal);

        updateHeaderCartCount(totalQuantity);
        updateCustomerSummary();
    }

    async function cartRequest(url, data = {}) {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });

        let result = {};
        try {
            result = await response.json();
        } catch (error) {}

        if (!response.ok || result.success === false) {
            throw new Error(result.message || 'Something went wrong.');
        }

        return result;
    }

    document.addEventListener('click', async function (event) {
        const increaseButton = event.target.closest('.increaseQty');
        const decreaseButton = event.target.closest('.decreaseQty');
        const removeButton = event.target.closest('.removeCartItem');

        const button = increaseButton || decreaseButton || removeButton;
        if (!button) return;

        const index = Number(button.dataset.index);
        if (Number.isNaN(index) || !cart[index]) return;

        const item = cart[index];
        const productId = Number(item.product_id || item.product?.id || 0);
        const oldQuantity = Number(item.quantity || 1);

        button.disabled = true;

        try {
            if (increaseButton || decreaseButton) {
                const newQuantity = increaseButton ? oldQuantity + 1 : oldQuantity - 1;
                if (newQuantity < 1) return;

                const result = await cartRequest("{{ route('cart.update') }}", {
                    product_id: productId,
                    quantity: newQuantity
                });

                cart[index].quantity = newQuantity;
                if (result.cart_count !== undefined) updateHeaderCartCount(result.cart_count);
            } else {
                const result = await cartRequest("{{ route('cart.remove') }}", {
                    product_id: productId
                });

                cart.splice(index, 1);
                if (result.cart_count !== undefined) updateHeaderCartCount(result.cart_count);
            }

            renderCart();
        } catch (error) {
            console.error('Cart action error:', error);
            alert(error.message || 'Unable to update your cart.');
        } finally {
            button.disabled = false;
        }
    });

    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', async function () {
            if (!cart.length) return;
            if (!confirm('Are you sure you want to clear your cart?')) return;

            clearCartBtn.disabled = true;

            try {
                const result = await cartRequest("{{ route('cart.clear') }}", {});
                cart = [];
                if (result.cart_count !== undefined) updateHeaderCartCount(result.cart_count);
                renderCart();
            } catch (error) {
                console.error('Clear cart error:', error);
                alert(error.message || 'Unable to clear your cart.');
            } finally {
                clearCartBtn.disabled = false;
            }
        });
    }
    if (checkoutBtn) {
    checkoutBtn.addEventListener('click', async function () {

        if (!cart.length) {
            alert('Your cart is empty.');
            return;
        }

        if (!isLoggedIn) {
            alert('Please login before placing your order.');
            window.location.href = "{{ route('login') }}";
            return;
        }

        const name = customerName?.value?.trim() || '';
        const email = customerEmail?.value?.trim() || '';
        const phone = customerPhone?.value?.trim() || '';

        if (!name) {
            alert('Please enter your name.');
            customerName?.focus();
            return;
        }

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert('Please enter a valid email address.');
            customerEmail?.focus();
            return;
        }

        if (!phone) {
            alert('Please enter your phone number.');
            customerPhone?.focus();
            return;
        }

        let addressId = savedAddressSelect?.value || '';

        checkoutBtn.disabled = true;
        const originalText = checkoutBtn.innerHTML;
        checkoutBtn.innerHTML =
            '<i class="fa fa-spinner fa-spin"></i> Processing Order...';

        try {
            // Save a new address if no saved address is selected.
            if (!addressId || addressId === 'new') {

                const deliveryFullName =
                    deliveryName?.value?.trim() || name;

                const deliveryMobile =
                    deliveryPhone?.value?.trim() || phone;

                const address = customerAddress?.value?.trim() || '';
                const city = customerCity?.value?.trim() || '';
                const state = customerState?.value?.trim() || '';
                const pincode = customerPincode?.value?.trim() || '';

                if (!address || !city || !state || !pincode) {
                    throw new Error(
                        'Please enter your complete delivery address.'
                    );
                }

                if (!/^\d{6}$/.test(pincode)) {
                    throw new Error('Please enter a valid 6-digit pincode.');
                }

                const response = await fetch(
                    "{{ route('addresses.store') }}",
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name: deliveryFullName,
                            mobile: deliveryMobile,
                            address: address,
                            city: city,
                            state: state,
                            pincode: pincode,
                            country: 'India',
                            is_default: 'No'
                        })
                    }
                );

                let addressResult = {};

                try {
                    addressResult = await response.json();
                } catch (error) {
                    throw new Error('Unable to save your delivery address.');
                }

                if (
                    !response.ok ||
                    !addressResult.success ||
                    !addressResult.address?.id
                ) {
                    const errors = addressResult.errors
                        ? Object.values(addressResult.errors).flat().join('\n')
                        : '';

                    throw new Error(
                        errors ||
                        addressResult.message ||
                        'Unable to save your delivery address.'
                    );
                }

                const savedAddress = addressResult.address;
                addressId = String(savedAddress.id);

                const option = addAddressToDropdown(savedAddress);
                addSavedAddressCard(savedAddress);

                if (option && savedAddressSelect) {
                    savedAddressSelect.value = addressId;
                    fillSavedAddress(option);
                }

                if (newAddressForm) {
                    newAddressForm.hidden = true;
                }

                if (showNewAddressBtn) {
                    showNewAddressBtn.style.display = 'inline-flex';
                }

                if (saveNewAddress) {
                    saveNewAddress.checked = false;
                }
            }

            if (!addressId || !/^\d+$/.test(String(addressId))) {
                throw new Error('Please select a valid delivery address.');
            }

            // Place Cash on Delivery order.
            const orderResponse = await fetch(
                "{{ route('checkout.place-order') }}",
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        address_id: Number(addressId),
                        payment_method: 'cash'
                    })
                }
            );

            let orderResult = {};

            try {
                orderResult = await orderResponse.json();
            } catch (error) {
                throw new Error(
                    'Unexpected server response. Please check your order before retrying.'
                );
            }

            if (!orderResponse.ok || orderResult.success === false) {
                const errors = orderResult.errors
                    ? Object.values(orderResult.errors).flat().join('\n')
                    : '';

                throw new Error(
                    errors ||
                    orderResult.message ||
                    'Unable to place your order.'
                );
            }

            if (orderResult.redirect_url) {
                window.location.href = orderResult.redirect_url;
                return;
            }

            const orderNo =
                orderResult.order_no ||
                orderResult.order?.order_no;

            if (orderNo) {
                window.location.href =
                    "{{ url('/order-confirmation') }}/" +
                    encodeURIComponent(orderNo);
                return;
            }

            throw new Error(
                'Order confirmation was not returned by the server. Please check your order before trying again.'
            );

        } catch (error) {
            console.error('Checkout error:', error);
            alert(error.message || 'Unable to place your order.');
        } finally {
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = originalText;
        }
    });
}

    // Add a recommended product using the same existing cart endpoint.
    document.addEventListener('click', async function (event) {
        const button = event.target.closest('.food-recommendation-add');
        if (!button) return;

        const productId = Number(button.dataset.productId);
        if (!productId) return;

        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
        const message = document.getElementById('recommendationMessage');

        try {
            const result = await cartRequest("{{ route('cart.add') }}", {
                product_id: productId,
                quantity: 1
            });

            // Update the cart displayed on the page immediately.
            const existingIndex = cart.findIndex(item => Number(item.product_id) === productId);
            if (existingIndex >= 0) {
                cart[existingIndex].quantity = Number(cart[existingIndex].quantity || 1) + 1;
            } else {
                // Refresh to load the complete product model and updated recommendations.
                window.location.reload();
                return;
            }
            renderCart();
            if (message) {
                message.textContent = result.message || 'Product added to your cart.';
                message.style.color = 'var(--theme, #00813d)';
            }
        } catch (error) {
            if (message) {
                message.textContent = error.message || 'Could not add this product. Please try again.';
                message.style.color = '#d12525';
            }
        } finally {
            button.disabled = false;
            button.innerHTML = originalText;
        }
    });

    renderCart();
});
</script>

@endsection