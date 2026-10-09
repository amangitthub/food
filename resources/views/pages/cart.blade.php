@extends('layouts.site-layout')

@section('title', 'Shopping Cart | Food Website')

@section('meta_description')
    Review your selected food items and manage your cart.
@endsection

@section('content')

    <style>
        /* =========================================================
               ORIGINAL CART DESIGN
            ========================================================= */

        .food-cart-page {
            padding: 80px 0;
            background: #f8f9fb;
        }

        .food-cart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 35px;
        }

        .food-cart-header-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .food-cart-header-icon {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: #ff8c1a;
            color: #fff;
            font-size: 25px;
            box-shadow: 0 8px 20px rgba(255, 140, 26, .20);
        }

        .food-cart-label {
            display: block;
            color: #ff8c1a;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .food-cart-header h1 {
            margin: 0;
            color: #071b2c;
            font-size: 34px;
            font-weight: 800;
        }

        .food-cart-header p {
            margin: 5px 0 0;
            color: #7b8490;
            font-size: 14px;
        }

        .food-continue-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border: 1px solid #e4e7eb;
            border-radius: 10px;
            background: #fff;
            color: #071b2c;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: .25s ease;
        }

        .food-continue-btn:hover {
            color: #fff;
            background: #ff8c1a;
            border-color: #ff8c1a;
        }

        .food-empty-cart {
            text-align: center;
            background: #fff;
            border: 1px solid #eaecf0;
            border-radius: 18px;
            padding: 70px 30px;
            box-shadow: 0 10px 35px rgba(7, 27, 44, .06);
        }

        .food-empty-icon {
            width: 85px;
            height: 85px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff3e5;
            color: #ff8c1a;
            font-size: 34px;
        }

        .food-empty-cart h2 {
            margin-bottom: 8px;
            color: #071b2c;
            font-size: 25px;
            font-weight: 800;
        }

        .food-empty-cart p {
            margin-bottom: 25px;
            color: #7b8490;
        }

        .food-shop-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 22px;
            border-radius: 10px;
            background: #ff8c1a;
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        .food-shop-btn:hover {
            color: #fff;
            background: #071b2c;
        }

        .food-cart-items-card,
        .food-checkout-card {
            background: #fff;
            border: 1px solid #eaecf0;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(7, 27, 44, .06);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .food-cart-items-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid #f0f1f3;
        }

        .food-cart-items-title {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .food-cart-items-title-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #fff3e5;
            color: #ff8c1a;
        }

        .food-cart-items-header h3 {
            margin: 0 0 3px;
            color: #071b2c;
            font-size: 18px;
            font-weight: 800;
        }

        .food-cart-items-header span {
            color: #8b929b;
            font-size: 13px;
        }

        .food-clear-cart {
            border: 0;
            background: transparent;
            color: #e74c3c;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .food-clear-cart:hover {
            color: #c0392b;
        }

        .food-cart-item {
            display: grid;
            grid-template-columns: minmax(250px, 1fr) auto auto 40px;
            align-items: center;
            gap: 20px;
            padding: 21px 24px;
            border-bottom: 1px solid #f0f1f3;
        }

        .food-cart-item:last-child {
            border-bottom: 0;
        }

        .food-cart-product {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
        }

        .food-cart-image {
            width: 72px;
            height: 72px;
            flex: 0 0 72px;
            overflow: hidden;
            border-radius: 12px;
            background: #f4f5f7;
        }

        .food-cart-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .food-cart-no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ff8c1a;
            font-size: 22px;
        }

        .food-cart-product-info {
            min-width: 0;
        }

        .food-cart-product-info h4 {
            margin: 0 0 6px;
            color: #071b2c;
            font-size: 15px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .food-cart-product-info span {
            color: #8b929b;
            font-size: 13px;
        }

        .food-cart-quantity {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px;
            border: 1px solid #e7e9ed;
            border-radius: 9px;
        }

        .cart-qty-btn {
            width: 30px;
            height: 30px;
            border: 0;
            border-radius: 7px;
            background: #f5f6f8;
            color: #071b2c;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
        }

        .cart-qty-btn:hover {
            background: #ff8c1a;
            color: #fff;
        }

        .food-cart-quantity span {
            min-width: 18px;
            text-align: center;
            color: #071b2c;
            font-size: 14px;
            font-weight: 700;
        }

        .food-cart-item-total {
            min-width: 90px;
            text-align: right;
        }

        .food-cart-item-total strong {
            color: #071b2c;
            font-size: 15px;
            font-weight: 800;
        }

        .food-remove-item {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 9px;
            background: #fff1f0;
            color: #e74c3c;
            cursor: pointer;
        }

        .food-remove-item:hover {
            background: #e74c3c;
            color: #fff;
        }

        .food-checkout-card {
            padding: 24px;
        }

        .food-checkout-card-header {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 24px;
        }

        .food-checkout-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #fff3e5;
            color: #ff8c1a;
        }

        .food-checkout-card-header h3 {
            margin: 0 0 3px;
            color: #071b2c;
            font-size: 18px;
            font-weight: 800;
        }

        .food-checkout-card-header p {
            margin: 0;
            color: #8b929b;
            font-size: 13px;
        }

        .food-form-label {
            display: block;
            margin-bottom: 8px;
            color: #071b2c;
            font-size: 13px;
            font-weight: 700;
        }

        .food-form-label span {
            color: #e74c3c;
        }

        .food-input-box {
            position: relative;
        }

        .food-input-box>i {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #9aa1aa;
            z-index: 2;
        }

        .food-form-input {
            width: 100%;
            height: 48px;
            padding: 0 14px 0 40px;
            border: 1px solid #e2e5e9;
            border-radius: 9px;
            outline: none;
            color: #071b2c;
            background: #fff;
            font-size: 14px;
            transition: .2s ease;
        }

        .food-form-input:focus {
            border-color: #ff8c1a;
            box-shadow: 0 0 0 3px rgba(255, 140, 26, .10);
        }

        .food-address-input {
            width: 100%;
            height: 65px;
            min-height: 65px;
            padding: 12px 14px 12px 40px;
            resize: none;
            line-height: 1.4;
            box-sizing: border-box;
        }

        .food-textarea-box>i {
            top: 15px;
            transform: none;
        }

        .food-payment-methods {
            display: grid;
            gap: 12px;
        }

        .food-payment-option {
            position: relative;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 15px;
            border: 1px solid #e3e6ea;
            border-radius: 12px;
            cursor: pointer;
            transition: .2s ease;
        }

        .food-payment-option:hover {
            border-color: #ff8c1a;
        }

        .food-payment-option input {
            position: absolute;
            opacity: 0;
        }

        .food-payment-custom {
            width: 20px;
            height: 20px;
            flex: 0 0 20px;
            border: 2px solid #cfd4da;
            border-radius: 50%;
        }

        .food-payment-option input:checked+.food-payment-custom {
            border: 6px solid #ff8c1a;
        }

        .food-payment-content {
            flex: 1;
        }

        .food-payment-content strong {
            display: block;
            color: #071b2c;
            font-size: 14px;
        }

        .food-payment-content small {
            display: block;
            margin-top: 3px;
            color: #8b929b;
            font-size: 12px;
        }

        .food-payment-option>i {
            color: #ff8c1a;
        }

        .food-cart-summary {
            position: sticky;
            top: 95px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #eaecf0;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(7, 27, 44, .08);
        }

        .food-summary-top {
            padding: 22px 24px;
            border-bottom: 1px solid #f0f1f3;
        }

        .food-summary-title {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .food-summary-title-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #fff3e5;
            color: #ff8c1a;
        }

        .food-summary-title h3 {
            margin: 0;
            color: #071b2c;
            font-size: 18px;
            font-weight: 800;
        }

        .food-summary-body {
            padding: 24px;
        }

        .food-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 14px;
            color: #7c858f;
            font-size: 14px;
        }

        .food-summary-row strong {
            color: #071b2c;
        }

        .food-free {
            color: #21a366 !important;
        }

        .food-summary-divider {
            height: 1px;
            margin: 20px 0;
            background: #eceef1;
        }

        .food-summary-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .food-summary-total span {
            color: #071b2c;
            font-size: 16px;
            font-weight: 800;
        }

        .food-summary-total strong {
            color: #ff8c1a;
            font-size: 23px;
            font-weight: 800;
        }

        .food-mini-checkout-info {
            padding: 15px;
            margin-bottom: 18px;
            border-radius: 12px;
            background: #f8f9fb;
        }

        .food-mini-info-title {
            margin-bottom: 12px;
            color: #071b2c;
            font-size: 13px;
            font-weight: 800;
        }

        .food-mini-info-title i {
            margin-right: 6px;
            color: #ff8c1a;
        }

        .food-mini-info-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 8px;
            color: #8b929b;
            font-size: 12px;
        }

        .food-mini-info-row strong {
            max-width: 65%;
            overflow: hidden;
            color: #071b2c;
            text-align: right;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .food-checkout-btn {
            width: 100%;
            min-height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 11px;
            background: #ff8c1a;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: .25s ease;
        }

        .food-checkout-btn:hover {
            background: #071b2c;
        }

        .food-secure-text {
            margin-top: 13px;
            color: #8b929b;
            text-align: center;
            font-size: 11px;
        }

        .food-secure-text i {
            margin-right: 4px;
            color: #21a366;
        }

        @media (max-width: 991px) {

            .food-cart-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .food-cart-summary {
                position: static;
            }

        }

        @media (max-width: 767px) {

            .food-cart-page {
                padding: 50px 0;
            }

            .food-cart-header h1 {
                font-size: 28px;
            }

            .food-cart-item {
                grid-template-columns: 1fr auto;
                gap: 15px;
            }

            .food-cart-product {
                grid-column: 1 / -1;
            }

            .food-cart-item-total {
                text-align: left;
                min-width: auto;
            }

            .food-checkout-card {
                padding: 20px;
            }

        }

        @media (max-width: 575px) {

            .food-cart-header-left {
                align-items: flex-start;
            }

            .food-cart-header-icon {
                width: 52px;
                height: 52px;
                flex: 0 0 52px;
            }

            .food-cart-header h1 {
                font-size: 24px;
            }

            .food-cart-image {
                width: 62px;
                height: 62px;
                flex-basis: 62px;
            }

            .food-cart-items-header,
            .food-cart-item {
                padding-left: 16px;
                padding-right: 16px;
            }

            .food-summary-body {
                padding: 20px;
            }

        }
    </style>


    <section class="food-cart-page">

        <div class="container">

            {{-- PAGE HEADER --}}
            <div class="food-cart-header">

                <div class="food-cart-header-left">

                    <div class="food-cart-header-icon">
                        <i class="fa fa-shopping-basket"></i>
                    </div>

                    <div>
                        <span class="food-cart-label">Your Order</span>

                        <h1>Shopping Cart</h1>

                        <p>
                            Review your delicious selections before checkout.
                        </p>
                    </div>

                </div>

                <a href="{{ route('site.products') }}" class="food-continue-btn">

                    <i class="fa fa-arrow-left"></i>

                    Continue Shopping

                </a>

            </div>


            {{-- EMPTY CART --}}
            <div id="emptyCart" class="food-empty-cart" style="display:none;">

                <div class="food-empty-icon">
                    <i class="fa fa-shopping-basket"></i>
                </div>

                <h2>Your Cart is Empty</h2>

                <p>
                    Looks like you haven't added any delicious food yet.
                </p>

                <a href="{{ route('site.products') }}" class="food-shop-btn">

                    <i class="fa fa-utensils"></i>

                    Explore Menu

                </a>

            </div>


            {{-- CART CONTENT --}}
            <div id="cartContent" class="row g-4 align-items-start" style="display:none;">

                {{-- LEFT --}}
                <div class="col-12 col-lg-8 food-cart-left">

                    {{-- CART ITEMS --}}
                    <div class="food-cart-items-card">

                        <div class="food-cart-items-header">

                            <div class="food-cart-items-title">

                                <div class="food-cart-items-title-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </div>

                                <div>

                                    <h3>Your Items</h3>

                                    <span id="cartItemText">
                                        0 items
                                    </span>

                                </div>

                            </div>

                            <button type="button" id="clearCartBtn" class="food-clear-cart">

                                <i class="fa fa-trash"></i>

                                Clear Cart

                            </button>

                        </div>

                        <div id="cartItems"></div>

                    </div>


                    {{-- CUSTOMER DETAILS --}}
                    <div class="food-checkout-card">

                        <div class="food-checkout-card-header">

                            <div class="food-checkout-icon">
                                <i class="fa fa-user"></i>
                            </div>

                            <div>

                                <h3>Customer Details</h3>

                                <p>
                                    Enter your contact information for delivery.
                                </p>

                            </div>

                        </div>


                        <div class="row g-3">

                            {{-- NAME --}}
                            <div class="col-12 col-md-6">

                                <label class="food-form-label">
                                    Full Name <span>*</span>
                                </label>

                                <div class="food-input-box">

                                    <i class="fa fa-user"></i>

                                    <input type="text" id="customerName" class="food-form-input"
                                        placeholder="Enter your full name" autocomplete="name"
                                        value="{{ old('name', auth()->user()->name ?? '') }}">

                                </div>

                            </div>


                            {{-- EMAIL --}}
                            <div class="col-12 col-md-6">

                                <label class="food-form-label">
                                    Email Address <span>*</span>
                                </label>

                                <div class="food-input-box">

                                    <i class="fa fa-envelope"></i>

                                    <input type="email" id="customerEmail" class="food-form-input"
                                        placeholder="Enter your email" autocomplete="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}">

                                </div>

                            </div>


                            {{-- PHONE --}}
                            <div class="col-12 col-md-6">

                                <label class="food-form-label">
                                    Phone Number <span>*</span>
                                </label>

                                <div class="food-input-box">

                                    <i class="fa fa-phone"></i>

                                    <input type="tel" id="customerPhone" class="food-form-input"
                                        placeholder="Enter your phone number" maxlength="15" autocomplete="tel"
                                        value="{{ old('mobile', auth()->user()->mobile ?? '') }}">

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- DELIVERY ADDRESS --}}
                    <div class="food-checkout-card">

                        <div class="food-checkout-card-header">

                            <div class="food-checkout-icon">
                                <i class="fa fa-map-marker-alt"></i>
                            </div>

                            <div>

                                <h3>Delivery Address</h3>

                                <p>
                                    Tell us where you want your food delivered.
                                </p>

                            </div>

                        </div>


                        <div class="row g-3">

                            <div class="col-12">

                                <label class="food-form-label">
                                    Full Address <span>*</span>
                                </label>

                                <div class="food-input-box food-textarea-box">

                                    <i class="fa fa-home"></i>

                                    <textarea id="customerAddress" class="food-form-input food-address-input" rows="2"
                                        placeholder="House / Flat No., Street, Area"></textarea>

                                </div>

                            </div>


                            <div class="col-12 col-md-6">

                                <label class="food-form-label">
                                    City <span>*</span>
                                </label>

                                <div class="food-input-box">

                                    <i class="fa fa-city"></i>

                                    <input type="text" id="customerCity" class="food-form-input"
                                        placeholder="Enter city">

                                </div>

                            </div>


                            <div class="col-12 col-md-6">

                                <label class="food-form-label">
                                    State <span>*</span>
                                </label>

                                <div class="food-input-box">

                                    <i class="fa fa-map"></i>

                                    <input type="text" id="customerState" class="food-form-input"
                                        placeholder="Enter state">

                                </div>

                            </div>


                            <div class="col-12 col-md-6">

                                <label class="food-form-label">
                                    Pincode <span>*</span>
                                </label>

                                <div class="food-input-box">

                                    <i class="fa fa-map-pin"></i>

                                    <input type="text" id="customerPincode" class="food-form-input"
                                        placeholder="Enter pincode" maxlength="6">

                                </div>

                            </div>

                        </div>

                    </div>

{{-- DELIVERY ADDRESS
<div class="food-checkout-card">

    <div class="food-checkout-card-header">
        <div class="food-checkout-icon">
            <i class="fa fa-map-marker-alt"></i>
        </div>
        <div>
            <h3>Delivery Address</h3>
            <p>Select a saved address or add a new one.</p>
        </div>
    </div>

    @auth
        <div class="mb-3">
            <label for="savedAddressSelect" class="food-form-label">
                Select Delivery Address
            </label>

            <select id="savedAddressSelect"
                    class="food-form-input"
                    style="padding-left:14px;">

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
                        @selected($savedAddress->is_default === 'Yes')
                    >
                        {{ $savedAddress->name }} -
                        {{ $savedAddress->address }},
                        {{ $savedAddress->city }}
                        @if($savedAddress->is_default === 'Yes')
                            (Default)
                        @endif
                    </option>
                @endforeach

                <option value="new">+ Add New Address</option>
            </select>

            <a href="{{ route('addresses.index') }}"
               class="d-inline-block mt-2"
               style="color:#ff8c1a;font-weight:600;">
                <i class="fa fa-plus-circle"></i>
                Manage Saved Addresses
            </a>
        </div>
    @endauth

    <div id="newAddressForm">
        <div class="row g-3">

            <div class="col-12">
                <label for="customerName" class="food-form-label">
                    Full Name <span>*</span>
                </label>
                <input type="text"
                       id="customerName"
                       class="food-form-input"
                       value="{{ auth()->user()->name ?? '' }}"
                       placeholder="Enter full name">
            </div>

            <div class="col-12 col-md-6">
                <label for="customerPhone" class="food-form-label">
                    Mobile Number <span>*</span>
                </label>
                <input type="tel"
                       id="customerPhone"
                       class="food-form-input"
                       value="{{ auth()->user()->mobile ?? '' }}"
                       placeholder="Enter mobile number">
            </div>

            <div class="col-12">
                <label for="customerAddress" class="food-form-label">
                    Full Address <span>*</span>
                </label>
                <textarea id="customerAddress"
                          class="food-form-input"
                          rows="2"
                          placeholder="House / Flat No., Street, Area"></textarea>
            </div>

            <div class="col-12 col-md-6">
                <label for="customerCity" class="food-form-label">
                    City <span>*</span>
                </label>
                <input type="text"
                       id="customerCity"
                       class="food-form-input"
                       placeholder="Enter city">
            </div>

            <div class="col-12 col-md-6">
                <label for="customerState" class="food-form-label">
                    State <span>*</span>
                </label>
                <input type="text"
                       id="customerState"
                       class="food-form-input"
                       placeholder="Enter state">
            </div>

            <div class="col-12 col-md-6">
                <label for="customerPincode" class="food-form-label">
                    Pincode <span>*</span>
                </label>
                <input type="text"
                       id="customerPincode"
                       class="food-form-input"
                       maxlength="6"
                       placeholder="Enter pincode">
            </div>

            @auth
                <div class="col-12">
                    <label style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" id="saveNewAddress" checked>
                        Save this address to my account
                    </label>
                </div>
            @endauth

        </div>
    </div>
</div> --}}

                    {{-- PAYMENT --}}
                    <div class="food-checkout-card">

                        <div class="food-checkout-card-header">

                            <div class="food-checkout-icon">
                                <i class="fa fa-credit-card"></i>
                            </div>

                            <div>

                                <h3>Payment Method</h3>

                                <p>
                                    Select your preferred payment method.
                                </p>

                            </div>

                        </div>


                        <div class="food-payment-methods">

                            <label class="food-payment-option">

                                <input type="radio" name="payment_method" value="cod" checked>

                                <span class="food-payment-custom"></span>

                                <span class="food-payment-content">

                                    <strong>
                                        Cash on Delivery
                                    </strong>

                                    <small>
                                        Pay when your order arrives.
                                    </small>

                                </span>

                                <i class="fa fa-money-bill-wave"></i>

                            </label>


                            {{-- <label class="food-payment-option">

                                <input type="radio" name="payment_method" value="online">

                                <span class="food-payment-custom"></span>

                                <span class="food-payment-content">

                                    <strong>
                                        Online Payment
                                    </strong>

                                    <small>
                                        Pay securely online.
                                    </small>

                                </span>

                                <i class="fa fa-credit-card"></i>

                            </label> --}}

                        </div>

                    </div>

                </div>


                {{-- RIGHT - ORDER SUMMARY --}}
                <div class="col-12 col-lg-4 food-cart-right">

                    <div class="food-cart-summary">

                        <div class="food-summary-top">

                            <div class="food-summary-title">

                                <div class="food-summary-title-icon">
                                    <i class="fa fa-receipt"></i>
                                </div>

                                <h3>
                                    Order Summary
                                </h3>

                            </div>

                        </div>


                        <div class="food-summary-body">

                            <div class="food-summary-row">

                                <span>Items</span>

                                <strong id="summaryItems">
                                    0
                                </strong>

                            </div>


                            <div class="food-summary-row">

                                <span>Subtotal</span>

                                <strong id="summarySubtotal">
                                    ₹0.00
                                </strong>

                            </div>


                            <div class="food-summary-row">

                                <span>Delivery</span>

                                <strong class="food-free">
                                    FREE
                                </strong>

                            </div>


                            <div class="food-summary-divider"></div>


                            <div class="food-summary-total">

                                <span>Total</span>

                                <strong id="summaryTotal">
                                    ₹0.00
                                </strong>

                            </div>


                            <div class="food-mini-checkout-info">

                                <div class="food-mini-info-title">

                                    <i class="fa fa-user"></i>

                                    Customer Information

                                </div>


                                <div class="food-mini-info-row">

                                    <span>Name</span>

                                    <strong id="summaryCustomerName">
                                        Not entered
                                    </strong>

                                </div>


                                <div class="food-mini-info-row">

                                    <span>Phone</span>

                                    <strong id="summaryCustomerPhone">
                                        Not entered
                                    </strong>

                                </div>

                            </div>


                            <button type="button" class="food-checkout-btn" id="checkoutBtn">

                                Place Order

                                <i class="fa fa-arrow-right"></i>

                            </button>


                            <div class="food-secure-text">

                                <i class="fa fa-shield-alt"></i>

                                Secure & safe ordering

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');


            let cart = @json($cartItems ?? []);


            cart = cart.map(function(item) {

                const product = item.product || {};

                return {
                    id: item.id || null,
                    product_id: item.product_id || product.id || null,
                    quantity: Number(item.quantity || 1),
                    product: product
                };

            });


            const emptyCart =
                document.getElementById('emptyCart');

            const cartContent =
                document.getElementById('cartContent');

            const cartItemsContainer =
                document.getElementById('cartItems');

            const cartItemText =
                document.getElementById('cartItemText');

            const clearCartBtn =
                document.getElementById('clearCartBtn');

            const summaryItems =
                document.getElementById('summaryItems');

            const summarySubtotal =
                document.getElementById('summarySubtotal');

            const summaryTotal =
                document.getElementById('summaryTotal');

            const summaryCustomerName =
                document.getElementById('summaryCustomerName');

            const summaryCustomerPhone =
                document.getElementById('summaryCustomerPhone');

            const customerName =
                document.getElementById('customerName');

            const customerEmail =
                document.getElementById('customerEmail');

            const customerPhone =
                document.getElementById('customerPhone');

            const customerAddress =
                document.getElementById('customerAddress');

            const customerCity =
                document.getElementById('customerCity');

            const customerState =
                document.getElementById('customerState');

            const customerPincode =
                document.getElementById('customerPincode');

            const checkoutBtn =
                document.getElementById('checkoutBtn');


            function formatPrice(price) {

                return '₹' +
                    Number(price || 0).toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

            }


            function updateHeaderCartCount(count) {

    const headerCartCounts =
        document.querySelectorAll('.header-cart-count');

    if (!headerCartCounts.length) {
        return;
    }

    count = Number(count || 0);

    headerCartCounts.forEach(function(headerCartCount) {

        headerCartCount.textContent = count;

        headerCartCount.style.display =
            count > 0 ? 'inline-flex' : 'none';

    });

}


            function escapeHtml(value) {

                if (value === null || value === undefined) {
                    return '';
                }

                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');

            }


            function updateCustomerSummary() {

                if (summaryCustomerName && customerName) {

                    summaryCustomerName.textContent =
                        customerName.value || 'Guest';

                }

                if (summaryCustomerPhone && customerPhone) {

                    summaryCustomerPhone.textContent =
                        customerPhone.value || '-';

                }

            }


            function renderCart() {

                if (!cart || cart.length === 0) {

                    if (emptyCart) {
                        emptyCart.style.display = 'block';
                    }

                    if (cartContent) {
                        cartContent.style.display = 'none';
                    }

                    if (cartItemText) {
                        cartItemText.textContent = '0 items';
                    }

                    if (summaryItems) {
                        summaryItems.textContent = '0';
                    }

                    if (summarySubtotal) {
                        summarySubtotal.textContent = '₹0.00';
                    }

                    if (summaryTotal) {
                        summaryTotal.textContent = '₹0.00';
                    }

                    updateHeaderCartCount(0);

                    return;
                }


                if (emptyCart) {
                    emptyCart.style.display = 'none';
                }

                if (cartContent) {
                    cartContent.style.display = '';
                }


                if (!cartItemsContainer) {
                    return;
                }


                let html = '';
                let subtotal = 0;
                let totalQuantity = 0;


                cart.forEach(function(item, index) {

                    const product =
                        item.product || {};

                    const productId =
                        Number(
                            item.product_id ||
                            product.id ||
                            0
                        );

                    const productName =
                        product.name || 'Product';

                    const price =
                        Number(product.price || 0);

                    const quantity =
                        Number(item.quantity || 1);

                    const itemTotal =
                        price * quantity;


                    subtotal += itemTotal;
                    totalQuantity += quantity;


                    let imageHtml = `
                        <div class="food-cart-no-image">
                            <i class="fa fa-utensils"></i>
                        </div>
                    `;


                    if (
                        product.images &&
                        Array.isArray(product.images) &&
                        product.images.length > 0 &&
                        product.images[0].image_path
                    ) {

                        const imageUrl =
                            "{{ asset('') }}" +
                            product.images[0].image_path;


                        imageHtml = `
                            <img
                                src="${imageUrl}"
                                alt="${escapeHtml(productName)}"
                                onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=&quot;food-cart-no-image&quot;><i class=&quot;fa fa-utensils&quot;></i></div>';"
                            >
                        `;

                    } else if (product.image) {

                        imageHtml = `
                            <img
                                src="${product.image}"
                                alt="${escapeHtml(productName)}"
                            >
                        `;

                    }


                    html += `

                        <div
                            class="food-cart-item"
                            data-index="${index}"
                            data-product-id="${productId}"
                        >

                            <div class="food-cart-product">

                                <div class="food-cart-image">
                                    ${imageHtml}
                                </div>

                                <div class="food-cart-product-info">

                                    <h4>
                                        ${escapeHtml(productName)}
                                    </h4>

                                    <span>
                                        ${formatPrice(price)} each
                                    </span>

                                </div>

                            </div>


                            <div class="food-cart-quantity">

                                <button
                                    type="button"
                                    class="cart-qty-btn decreaseQty"
                                    data-index="${index}"
                                    aria-label="Decrease quantity"
                                >
                                    −
                                </button>

                                <span>
                                    ${quantity}
                                </span>

                                <button
                                    type="button"
                                    class="cart-qty-btn increaseQty"
                                    data-index="${index}"
                                    aria-label="Increase quantity"
                                >
                                    +
                                </button>

                            </div>


                            <div class="food-cart-item-total">

                                <strong>
                                    ${formatPrice(itemTotal)}
                                </strong>

                            </div>


                            <button
                                type="button"
                                class="food-remove-item removeCartItem"
                                data-index="${index}"
                                aria-label="Remove product"
                            >
                                <i class="fa fa-trash"></i>
                            </button>

                        </div>

                    `;

                });


                cartItemsContainer.innerHTML = html;


                if (cartItemText) {

                    cartItemText.textContent =
                        totalQuantity +
                        (
                            totalQuantity === 1 ?
                            ' item' :
                            ' items'
                        );

                }


                if (summaryItems) {

                    summaryItems.textContent =
                        totalQuantity +
                        (
                            totalQuantity === 1 ?
                            ' item' :
                            ' items'
                        );

                }


                if (summarySubtotal) {
                    summarySubtotal.textContent =
                        formatPrice(subtotal);
                }


                if (summaryTotal) {
                    summaryTotal.textContent =
                        formatPrice(subtotal);
                }


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
                } catch (error) {
                    result = {};
                }


                if (!response.ok || result.success === false) {

                    throw new Error(
                        result.message ||
                        'Something went wrong.'
                    );

                }


                return result;

            }


            /* =========================================================
               INCREASE
            ========================================================= */

            document.addEventListener('click', async function(event) {

                const button =
                    event.target.closest('.increaseQty');

                if (!button) {
                    return;
                }


                const index =
                    Number(button.dataset.index);


                if (
                    Number.isNaN(index) ||
                    !cart[index]
                ) {
                    return;
                }


                const item =
                    cart[index];


                const productId =
                    Number(
                        item.product_id ||
                        item.product?.id ||
                        0
                    );


                const newQuantity =
                    Number(item.quantity || 1) + 1;


                button.disabled = true;


                try {

                    const result =
                        await cartRequest(
                            "{{ route('cart.update') }}", {
                                product_id: productId,
                                quantity: newQuantity
                            }
                        );


                    cart[index].quantity =
                        newQuantity;


                    if (result.cart_count !== undefined) {

                        updateHeaderCartCount(
                            result.cart_count
                        );

                    }


                    renderCart();

                } catch (error) {

                    console.error(
                        'Increase Quantity Error:',
                        error
                    );

                    alert(
                        error.message ||
                        'Unable to update quantity.'
                    );

                } finally {

                    button.disabled = false;

                }

            });


            /* =========================================================
               DECREASE
            ========================================================= */

            document.addEventListener('click', async function(event) {

                const button =
                    event.target.closest('.decreaseQty');

                if (!button) {
                    return;
                }


                const index =
                    Number(button.dataset.index);


                if (
                    Number.isNaN(index) ||
                    !cart[index]
                ) {
                    return;
                }


                const item =
                    cart[index];


                const productId =
                    Number(
                        item.product_id ||
                        item.product?.id ||
                        0
                    );


                const currentQuantity =
                    Number(item.quantity || 1);


                if (currentQuantity <= 1) {
                    return;
                }


                const newQuantity =
                    currentQuantity - 1;


                button.disabled = true;


                try {

                    const result =
                        await cartRequest(
                            "{{ route('cart.update') }}", {
                                product_id: productId,
                                quantity: newQuantity
                            }
                        );


                    cart[index].quantity =
                        newQuantity;


                    if (result.cart_count !== undefined) {

                        updateHeaderCartCount(
                            result.cart_count
                        );

                    }


                    renderCart();

                } catch (error) {

                    console.error(
                        'Decrease Quantity Error:',
                        error
                    );

                    alert(
                        error.message ||
                        'Unable to update quantity.'
                    );

                } finally {

                    button.disabled = false;

                }

            });


            /* =========================================================
               REMOVE
            ========================================================= */

            document.addEventListener('click', async function(event) {

                const button =
                    event.target.closest('.removeCartItem');

                if (!button) {
                    return;
                }


                const index =
                    Number(button.dataset.index);


                if (
                    Number.isNaN(index) ||
                    !cart[index]
                ) {
                    return;
                }


                const item =
                    cart[index];


                const productId =
                    Number(
                        item.product_id ||
                        item.product?.id ||
                        0
                    );


                button.disabled = true;


                try {

                    const result =
                        await cartRequest(
                            "{{ route('cart.remove') }}", {
                                product_id: productId
                            }
                        );


                    cart.splice(index, 1);


                    if (result.cart_count !== undefined) {

                        updateHeaderCartCount(
                            result.cart_count
                        );

                    }


                    renderCart();

                } catch (error) {

                    console.error(
                        'Remove Cart Error:',
                        error
                    );

                    alert(
                        error.message ||
                        'Unable to remove product.'
                    );

                    button.disabled = false;

                }

            });


            /* =========================================================
               CLEAR CART
            ========================================================= */

            if (clearCartBtn) {

                clearCartBtn.addEventListener(
                    'click',
                    async function() {

                        if (cart.length === 0) {
                            return;
                        }


                        const confirmed =
                            confirm(
                                'Are you sure you want to clear your cart?'
                            );


                        if (!confirmed) {
                            return;
                        }


                        clearCartBtn.disabled = true;


                        try {

                            const result =
                                await cartRequest(
                                    "{{ route('cart.clear') }}", {}
                                );


                            cart = [];


                            if (result.cart_count !== undefined) {

                                updateHeaderCartCount(
                                    result.cart_count
                                );

                            }


                            renderCart();

                        } catch (error) {

                            console.error(
                                'Clear Cart Error:',
                                error
                            );

                            alert(
                                error.message ||
                                'Unable to clear cart.'
                            );

                        } finally {

                            clearCartBtn.disabled = false;

                        }

                    }
                );

            }


            /* =========================================================
               CUSTOMER SUMMARY
            ========================================================= */

            if (customerName) {

                customerName.addEventListener(
                    'input',
                    updateCustomerSummary
                );

            }


            if (customerPhone) {

                customerPhone.addEventListener(
                    'input',
                    updateCustomerSummary
                );

            }


            /* =========================================================
               CHECKOUT
            ========================================================= */

            if (checkoutBtn) {

                checkoutBtn.addEventListener(
                    'click',
                    function() {

                        if (!cart || cart.length === 0) {

                            alert(
                                'Your cart is empty.'
                            );

                            return;

                        }


                        const isLoggedIn =
                            @json(auth()->check());


                        if (!isLoggedIn) {

                            alert(
                                'Please login before placing your order.'
                            );

                            window.location.href =
                                "{{ route('login') }}";

                            return;

                        }


                        const name =
                            customerName?.value?.trim() || '';

                        const email =
                            customerEmail?.value?.trim() || '';

                        const phone =
                            customerPhone?.value?.trim() || '';

                        const address =
                            customerAddress?.value?.trim() || '';

                        const city =
                            customerCity?.value?.trim() || '';

                        const state =
                            customerState?.value?.trim() || '';

                        const pincode =
                            customerPincode?.value?.trim() || '';


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

                            alert('Please enter your delivery address.');

                            customerAddress?.focus();

                            return;

                        }


                        if (!city) {

                            alert('Please enter your city.');

                            customerCity?.focus();

                            return;

                        }


                        if (!state) {

                            alert('Please enter your state.');

                            customerState?.focus();

                            return;

                        }


                        if (!pincode) {

                            alert('Please enter your pincode.');

                            customerPincode?.focus();

                            return;

                        }


                        alert(
                            'Cart is ready. Place Order backend will be connected next.'
                        );

                    }
                );

            }


            /* =========================================================
               INITIAL RENDER
            ========================================================= */

            renderCart();

        });
    </script>

@endsection
