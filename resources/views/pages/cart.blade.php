@extends('layouts.site-layout')

@section('title', 'Shopping Cart | Food Website')

@section('meta_description')
    Review your selected food items and manage your cart.
@endsection

@section('content')

<style>
    .food-cart-page{padding:70px 0;background:#f8f9fb}
    .food-cart-header{display:flex;align-items:center;justify-content:space-between;gap:25px;margin-bottom:32px}
    .food-cart-header-left{display:flex;align-items:center;gap:16px}
    .food-cart-header-icon{width:60px;height:60px;display:flex;align-items:center;justify-content:center;border-radius:15px;background:#ff8c1a;color:#fff;font-size:25px}
    .food-cart-label{display:block;color:#ff8c1a;font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase}
    .food-cart-header h1{margin:4px 0;color:#071b2c;font-size:32px;font-weight:800}
    .food-cart-header p{margin:0;color:#7b8490;font-size:14px}
    .food-continue-btn{display:inline-flex;align-items:center;gap:8px;padding:12px 18px;border:1px solid #e4e7eb;border-radius:10px;background:#fff;color:#071b2c;text-decoration:none;font-weight:700}
    .food-continue-btn:hover{background:#ff8c1a;color:#fff}
    .food-empty-cart{text-align:center;background:#fff;border:1px solid #eaecf0;border-radius:18px;padding:60px 25px}
    .food-empty-icon{width:80px;height:80px;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#fff3e5;color:#ff8c1a;font-size:32px}
    .food-empty-cart h2{color:#071b2c;font-weight:800}
    .food-empty-cart p{color:#7b8490;margin-bottom:22px}
    .food-shop-btn{display:inline-flex;gap:8px;padding:13px 22px;border-radius:10px;background:#ff8c1a;color:#fff;text-decoration:none;font-weight:700}
    .food-cart-items-card,.food-checkout-card,.food-cart-summary{background:#fff;border:1px solid #eaecf0;border-radius:16px;box-shadow:0 8px 30px rgba(7,27,44,.05);margin-bottom:20px;overflow:hidden}
    .food-cart-items-header{display:flex;align-items:center;justify-content:space-between;gap:15px;padding:20px 22px;border-bottom:1px solid #f0f1f3}
    .food-cart-items-title,.food-checkout-card-header,.food-summary-title{display:flex;align-items:center;gap:12px}
    .food-cart-items-title-icon,.food-checkout-icon,.food-summary-title-icon{width:43px;height:43px;display:flex;align-items:center;justify-content:center;border-radius:12px;background:#fff3e5;color:#ff8c1a;flex-shrink:0}
    .food-cart-items-header h3,.food-checkout-card-header h3,.food-summary-title h3{margin:0;color:#071b2c;font-size:18px;font-weight:800}
    .food-cart-items-header span,.food-checkout-card-header p{color:#8b929b;font-size:13px}
    .food-checkout-card-header{margin-bottom:22px}
    .food-checkout-card-header p{margin:3px 0 0}
    .food-clear-cart{border:0;background:none;color:#e74c3c;font-size:13px;font-weight:700;cursor:pointer}
    .food-cart-item{display:grid;grid-template-columns:minmax(180px,1fr) auto auto 36px;align-items:center;gap:16px;padding:20px 22px;border-bottom:1px solid #f0f1f3}
    .food-cart-item:last-child{border-bottom:0}
    .food-cart-product{display:flex;align-items:center;gap:13px;min-width:0}
    .food-cart-image{width:70px;height:70px;flex:0 0 70px;overflow:hidden;border-radius:11px;background:#f4f5f7}
    .food-cart-image img{width:100%;height:100%;object-fit:cover}
    .food-cart-no-image{height:100%;display:flex;align-items:center;justify-content:center;color:#ff8c1a;font-size:22px}
    .food-cart-product-info{min-width:0}
    .food-cart-product-info h4{margin:0 0 6px;color:#071b2c;font-size:15px;font-weight:800;overflow-wrap:anywhere}
    .food-cart-product-info span{color:#8b929b;font-size:13px}
    .food-cart-quantity{display:flex;align-items:center;gap:10px;padding:5px;border:1px solid #e7e9ed;border-radius:9px}
    .cart-qty-btn{width:29px;height:29px;border:0;border-radius:7px;background:#f5f6f8;color:#071b2c;font-size:17px;cursor:pointer}
    .cart-qty-btn:hover{background:#ff8c1a;color:#fff}
    .food-cart-item-total{text-align:right;white-space:nowrap}
    .food-cart-item-total strong{color:#071b2c;font-size:15px}
    .food-remove-item{width:34px;height:34px;border:0;border-radius:9px;background:#fff1f0;color:#e74c3c;cursor:pointer}
    .food-remove-item:hover{background:#e74c3c;color:#fff}
    .food-checkout-card{padding:23px}
    .food-form-label{display:block;margin-bottom:8px;color:#071b2c;font-size:13px;font-weight:700}
    .food-form-label span{color:#e74c3c}
    .food-form-input{width:100%;min-height:46px;padding:11px 13px;border:1px solid #e2e5e9;border-radius:9px;outline:none;background:#fff;color:#071b2c;font-size:14px;box-sizing:border-box}
    .food-form-input:focus{border-color:#ff8c1a;box-shadow:0 0 0 3px rgba(255,140,26,.1)}
    textarea.food-form-input{min-height:75px;resize:vertical}
    .food-address-select{padding-left:13px!important}
    .food-saved-address-list{display:grid;gap:12px;margin:16px 0 20px}
    .food-saved-address-card{display:flex;align-items:flex-start;gap:12px;padding:15px;border:1px solid #e5e8ed;border-radius:12px;background:#fff;transition:border-color .2s}
    .food-saved-address-card.is-default{border-color:#ffb45f;background:#fffaf4}
    .food-saved-address-card.is-selected{border:2px solid #ff8c1a;background:#fffaf4}
    .food-saved-address-details{flex:1;min-width:0;overflow-wrap:anywhere}
    .food-saved-address-details strong{display:block;color:#071b2c;margin-bottom:5px;font-size:14px}
    .food-saved-address-details p{margin:0;color:#727b86;font-size:13px;line-height:1.7}
    .food-address-badge{display:inline-block;margin-top:7px;padding:4px 9px;border-radius:20px;background:#fff0dc;color:#c96b00;font-size:11px;font-weight:700}
    .food-no-saved-addresses{padding:16px;border:1px dashed #d9dde3;border-radius:10px;color:#7b8490;font-size:13px;text-align:center}
    .food-use-address{flex-shrink:0;border:1px solid #ff8c1a;border-radius:8px;background:#fff;color:#d97500;padding:8px 12px;font-size:12px;font-weight:800;cursor:pointer}
    .food-use-address:hover,.food-use-address.active{background:#ff8c1a;color:#fff}
    .food-new-address-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 14px;border:1px solid #ff8c1a;border-radius:9px;background:#fff;color:#d97500;font-size:13px;font-weight:700;cursor:pointer}
    .food-new-address-btn:hover{background:#ff8c1a;color:#fff}
    #newAddressForm[hidden]{display:none!important}
    .food-payment-methods{display:grid;gap:12px}
    .food-payment-option{display:flex;align-items:center;gap:13px;padding:15px;border:1px solid #e3e6ea;border-radius:11px;cursor:pointer}
    .food-payment-option input{accent-color:#ff8c1a}
    .food-payment-content{flex:1}
    .food-payment-content strong{display:block;color:#071b2c;font-size:14px}
    .food-payment-content small{color:#8b929b;font-size:12px}
    .food-payment-option>i{color:#ff8c1a}
    .food-cart-summary{position:sticky;top:95px}
    .food-summary-top{padding:20px 22px;border-bottom:1px solid #f0f1f3}
    .food-summary-body{padding:22px}
    .food-summary-row{display:flex;justify-content:space-between;gap:12px;margin-bottom:14px;color:#7c858f;font-size:14px}
    .food-summary-row strong{color:#071b2c}
    .food-free{color:#21a366!important}
    .food-summary-divider{height:1px;margin:20px 0;background:#eceef1}
    .food-summary-total{display:flex;justify-content:space-between;gap:12px;margin-bottom:20px}
    .food-summary-total span{color:#071b2c;font-weight:800}
    .food-summary-total strong{color:#ff8c1a;font-size:23px}
    .food-mini-checkout-info{padding:15px;margin-bottom:18px;border-radius:11px;background:#f8f9fb}
    .food-mini-info-title{margin-bottom:12px;color:#071b2c;font-size:13px;font-weight:800}
    .food-mini-info-title i{margin-right:6px;color:#ff8c1a}
    .food-mini-info-row{display:flex;justify-content:space-between;gap:12px;margin-top:8px;color:#8b929b;font-size:12px}
    .food-mini-info-row strong{max-width:65%;overflow:hidden;color:#071b2c;text-align:right;text-overflow:ellipsis;white-space:nowrap}
    .food-checkout-btn{width:100%;min-height:51px;display:flex;align-items:center;justify-content:center;gap:10px;border:0;border-radius:10px;background:#ff8c1a;color:#fff;font-weight:800;cursor:pointer}
    .food-checkout-btn:hover{background:#071b2c}
    .food-checkout-btn:disabled{opacity:.6;cursor:not-allowed}
    .food-secure-text{margin-top:12px;color:#8b929b;text-align:center;font-size:11px}
    .food-secure-text i{color:#21a366}
    @media(max-width:991px){.food-cart-header{align-items:flex-start;flex-direction:column}.food-cart-summary{position:static}}
    @media(max-width:767px){.food-cart-page{padding:45px 0}.food-cart-header h1{font-size:27px}.food-cart-item{grid-template-columns:1fr auto;gap:12px;padding:17px}.food-cart-product{grid-column:1/-1}.food-cart-item-total{text-align:left}.food-checkout-card{padding:18px}}
    @media(max-width:480px){.food-cart-header-left{align-items:flex-start}.food-cart-header-icon{width:48px;height:48px;flex:0 0 48px}.food-cart-header h1{font-size:23px}.food-cart-image{width:58px;height:58px;flex-basis:58px}.food-cart-items-header{padding:17px}.food-saved-address-card{flex-wrap:wrap}.food-use-address{margin-left:auto}.food-summary-body{padding:18px}}

.food-form-input,
.food-form-input:focus {
    color: #071b2c !important;
    background: #fff !important;
    -webkit-text-fill-color: #071b2c !important;
    opacity: 1 !important;
    visibility: visible !important;
}
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
            const address = customerAddress?.value?.trim() || '';
            const city = customerCity?.value?.trim() || '';
            const state = customerState?.value?.trim() || '';
            const pincode = customerPincode?.value?.trim() || '';

            if (!name) {
                alert('Please enter your name.');
                customerName?.focus();
                return;
            }

            if (!email) {
                alert('Please enter your email.');
                customerEmail?.focus();
                return;
            }

            if (!phone) {
                alert('Please enter your phone number.');
                customerPhone?.focus();
                return;
            }

            if (!address) {
                alert('Please select a saved address or enter your delivery address.');
                if (newAddressForm) newAddressForm.hidden = false;
                customerAddress?.focus();
                return;
            }

            if (!city || !state || !pincode) {
                alert('Please enter your city, state and pincode.');
                if (newAddressForm) newAddressForm.hidden = false;
                if (!city) customerCity?.focus();
                else if (!state) customerState?.focus();
                else customerPincode?.focus();
                return;
            }

            const selectedAddressId = savedAddressSelect?.value || '';
            const isAddingNewAddress = !selectedAddressId || selectedAddressId === 'new';

            if (isAddingNewAddress && saveNewAddress?.checked) {
                checkoutBtn.disabled = true;

                try {
                    const response = await fetch("{{ route('addresses.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name: deliveryName?.value?.trim() || name,
                            mobile: deliveryPhone?.value?.trim() || phone,
                            address: address,
                            city: city,
                            state: state,
                            pincode: pincode,
                            country: 'India',
                            is_default: false
                        })
                    });

                    let result = {};
                    try {
                        result = await response.json();
                    } catch (error) {}

                    if (!response.ok || !result.success || !result.address) {
                        const errors = result.errors
                            ? Object.values(result.errors).flat().join('\n')
                            : (result.message || 'Unable to save address.');
                        throw new Error(errors);
                    }

                    const savedAddress = result.address;
                    const option = addAddressToDropdown(savedAddress);

                    addSavedAddressCard(savedAddress);

                    if (option && savedAddressSelect) {
                        savedAddressSelect.value = String(savedAddress.id);
                        fillSavedAddress(option);
                    }

                    if (saveNewAddress) saveNewAddress.checked = false;
                    if (newAddressForm) newAddressForm.hidden = true;
                    if (showNewAddressBtn) showNewAddressBtn.style.display = 'inline-flex';

                    alert('Address saved successfully! It is now visible below.');

                } catch (error) {
                    console.error('Save address error:', error);
                    alert(error.message || 'Unable to save address.');
                    return;
                } finally {
                    checkoutBtn.disabled = false;
                }
            }

            alert('Address details validated. Order placement backend is not connected yet.');
        });
    }

    renderCart();
});
</script>

@endsection