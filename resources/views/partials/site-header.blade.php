<header class="section-bg">

    {{-- ======================HEADER TOP======================== --}}
    {{-- <div class="header-top">
        <div class="container">
            <div class="header-top-wrapper">

                <ul>
                    <li>
                        <span>100%</span>
                        Secure delivery without contacting the courier
                    </li>

                    <li>
                        <i class="fas fa-truck"></i>
                        Track Your Order
                    </li>
                </ul>

                <div class="top-right">
                    <div class="search-wrp">
                        <form action="{{ route('site.products') }}" method="GET">

                            <button type="submit" id="searchBtn">
                                <i class="far fa-search"></i>
                            </button>

                            <input type="text" name="search" id="searchInput" placeholder="Search" aria-label="Search"
                                value="{{ request('search') }}">

                        </form>
                    </div>

                    <div class="social-icon d-flex align-items-center">

                        <a href="#" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="#" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>

                        <a href="#" aria-label="Vimeo">
                            <i class="fab fa-vimeo-v"></i>
                        </a>

                        <a href="#" aria-label="Pinterest">
                            <i class="fab fa-pinterest-p"></i>
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </div> --}}


    {{-- ===================== MAIN HEADER ======================== --}}
    <div id="header-sticky" class="header-1">

        <div class="container">
            <div class="mega-menu-wrapper">
                <div class="header-main">
                    {{-- ================= LOGO ================= --}}
                    <div class="logo">
                        <a href="{{ url('/') }}" class="header-logo">
                            <img src="{{ asset('assets/img/logo/logo.svg') }}" alt="Food Website Logo">
                        </a>
                    </div>

                    {{-- ================= DESKTOP MENU ================= --}}
                    <div class="header-left">

                        <div class="mean__menu-wrapper d-none d-lg-block">

                            <div class="main-menu">

                                <nav id="mobile-menu">

                                    <ul>
                                        {{-- HOME --}}
                                        <li class="active">
                                            <a href="{{ url('/') }}">
                                                Home
                                            </a>
                                        </li>

                                        {{-- PRODUCTS --}}
                                        <li class="has-dropdown">
                                            <a href="{{ route('site.products') }}">
                                                Products
                                            </a>
                                        </li>

                                        {{-- CATEGORIES --}}
                                        {{-- <li class="has-dropdown">

                                            <a href="#">
                                                Categories
                                                <i class="fas fa-angle-down"></i>
                                            </a>

                                            <ul class="submenu">

                                                <li>
                                                    <a href="{{ url('/category/pizza') }}">
                                                        Pizza
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/category/burgers') }}">
                                                        Burgers
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/category/snacks') }}">
                                                        Snacks
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/category/desserts') }}">
                                                        Desserts
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/category/drinks') }}">
                                                        Drinks
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/category/meals') }}">
                                                        Meals
                                                    </a>
                                                </li>

                                            </ul>

                                        </li>
                                        --}}

                                        {{-- COMBOS --}}
                                        <li class="has-dropdown">

                                            <a href="{{ url('/combos') }}">
                                                Combos
                                                {{-- <i class="fas fa-angle-down"></i> --}}
                                            </a>

                                            {{-- <ul class="submenu">

                                                <li>
                                                    <a href="{{ url('/combos') }}">
                                                        All Combos
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#">
                                                        Burger Combos
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#">
                                                        Pizza Combos
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#">
                                                        Family Combos
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#">
                                                        Meal Combos
                                                    </a>
                                                </li>

                                            </ul> --}}

                                        </li>


                                        {{-- POPULAR --}}
                                        {{-- <li>

                                            <a href="{{ url('/popular') }}">
                                                Popular
                                            </a>

                                        </li> --}}


                                        {{-- NEW ARRIVALS --}}
                                        {{-- <li>

                                            <a href="{{ url('/products/new-arrivals') }}">
                                                New Arrivals
                                            </a>

                                        </li> --}}


                                        {{-- OFFERS --}}
                                        {{-- <li class="has-dropdown">

                                            <a href="{{ url('/offers') }}">
                                                Offers
                                                <i class="fas fa-angle-down"></i>
                                            </a>

                                            <ul class="submenu">

                                                <li>
                                                    <a href="{{ url('/offers') }}">
                                                        All Offers
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/offers/today') }}">
                                                        Today's Deals
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/offers/discounts') }}">
                                                        Discounts
                                                    </a>
                                                </li>

                                            </ul>

                                        </li> --}}

                                        {{-- ABOUT --}}
                                        {{-- <li>

                                            <a href="{{ url('/about') }}">
                                                About
                                            </a>

                                        </li> --}}

                                        {{-- CONTACT --}}
                                        <li>

                                            <a href="{{ route('contact') }}">
                                                Contact
                                            </a>

                                        </li>
                                        <li> <a href="{{ route('orders.my') }}">My Orders</a> </li>


                                    </ul>

                                </nav>

                            </div>

                        </div>

                    </div>

                    <div class="mobile-menu"></div>

                    {{-- ================= RIGHT SIDE ================= --}}
                    <div class="header-right d-flex justify-content-end align-items-center">

                        {{-- CART --}}
                        <div class="menu-cart">
                            <a href="{{ route('cart') }}" class="cart-icon" aria-label="Shopping Cart">
                                <i class="far fa-shopping-basket"></i>

                                <span class="header-cart-count"
                                    style="{{ ($headerCartCount ?? 0) > 0 ? 'display:inline-flex;' : 'display:none;' }}">
                                    {{ $headerCartCount ?? 0 }}
                                </span>
                            </a>
                        </div>

                        {{-- Login / Logout --}}
                        <div class="header-button">
                            @auth
                            {{-- Logged In User --}}
                            <div class="dropdown">

                                <a href="#" class="text-danger dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                    <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>

                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>
                                        <span class="dropdown-item-text">
                                            Hi, {{ auth()->user()->name }}
                                        </span>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a href="{{ url('/profile') }}" class="dropdown-item">
                                            <i class="fa fa-user-circle me-2"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a href="#" class="dropdown-item"
                                            onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();">

                                            <i class="fa fa-sign-out-alt me-2"></i>
                                            Logout
                                        </a>
                                    </li>

                                </ul>

                            </div>

                            {{-- Logout Form --}}
                            <form id="header-logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">

                                @csrf

                            </form>
                            @else
                            {{-- Login --}}
                            <a href="javascript:void(0);" class="text-danger" data-bs-toggle="modal"
                                data-bs-target="#loginModal">

                                <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>

                            </a>

                            @endauth

                        </div>


                        {{-- MOBILE HAMBURGER --}}
                        <div class="header__hamburger d-xl-block my-auto">
                            <div class="sidebar__toggle" id="foodMobileMenuBtn">
                                <div class="header-bar">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- =========================================================
     FOODKING MOBILE SIDEBAR
     ========================================================= -->

    <div class="food-mobile-overlay" id="foodMobileOverlay"></div>

    <aside class="food-mobile-sidebar" id="foodMobileSidebar">

        <!-- Sidebar Header -->
        <div class="food-mobile-header">

            <a href="{{ url('/') }}" class="food-mobile-logo">
                <img src="{{ asset('assets/img/logo/logo.svg') }}" alt="Foodking">
            </a>

            <button type="button" class="food-mobile-close" id="foodMobileClose" aria-label="Close Menu">
                <i class="fas fa-times"></i>
            </button>

        </div>
        <!-- Navigation -->
        <nav class="food-mobile-nav">

            <ul>

                {{-- HOME --}}
                <li>
                    <a href="{{ url('/') }}">
                        Home
                    </a>
                </li>


                {{-- PRODUCTS --}}
                <li>
                    <a href="{{ route('site.products') }}">
                        Products
                    </a>
                </li>


                {{-- COMBOS --}}
                <li class="food-mobile-dropdown">

                    <a href="javascript:void(0);">
                        <span>Combos</span>
                        <span class="food-mobile-arrow">+</span>
                    </a>

                    <ul>

                        <li>
                            <a href="{{ url('/combos') }}">
                                All Combos
                            </a>
                        </li>

                    </ul>
                </li>
               {{-- CONTACT --}}
                <li> <a href="{{ route('contact') }}"> Contact </a> </li>

                {{-- Orders--}}

                <li> <a href="{{ route('orders.my') }}">My Orders</a> </li>


                {{-- CART --}}
                <li>
                    <a href="{{ route('cart') }}" class="cart-icon" aria-label="Shopping Cart">
                        <i class="far fa-shopping-basket"> <span>Cart</span></i>

                        <span class="header-cart-count"
                            style="{{ ($headerCartCount ?? 0) > 0 ? 'display:inline-flex;' : 'display:none;' }}">
                            {{ $headerCartCount ?? 0 }}
                        </span>
                    </a>

                </li>

                {{-- PROFILE & LOGOUT --}}
                @auth

                {{-- PROFILE --}}
                <li>
                    <a href="{{ url('/profile') }}">
                        <i class="fa fa-user-circle me-3"> Profile</i>
                        <span></span>
                    </a>
                </li>

                {{-- LOGOUT --}}
                <li>
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('mobile-profile-logout-form').submit();">

                        <i class="fa fa-sign-out-alt me-3"> Logout</i>
                        <span></span>
                    </a>

                    <form id="mobile-profile-logout-form" action="{{ route('logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>

                @else

                {{-- LOGIN --}}
                <li>
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fa fa-user-circle me-3"> Login </i>
                        <span></span>
                    </a>
                </li>

                @endauth


            </ul>

        </nav>

        <!-- Contact Info -->
        <div class="food-mobile-contact">

            <h4>CONTACT INFO</h4>

            <div class="food-mobile-contact-row">
                <i class="fas fa-map-marker-alt"></i>
                <span>Dehradun, Uttarakhand</span>
            </div>

            <div class="food-mobile-contact-row">
                <i class="fas fa-envelope"></i>
                <span>info@foodking.com</span>
            </div>

            <div class="food-mobile-contact-row">
                <i class="fas fa-clock"></i>
                <span>10:00 AM - 10:00 PM</span>
            </div>

            <div class="food-mobile-contact-row">
                <i class="fas fa-phone-alt"></i>
                <span>+91 98765 43210</span>
            </div>

        </div>

        <!-- Order Button -->
        <div class="food-mobile-order">
            <a href="{{ route('site.products') }}">
                <i class="fas fa-truck"></i>
                ORDER NOW
            </a>
        </div>

        <!-- Social Icons -->
        <div class="food-mobile-social">

            <a href="#">
                <i class="fab fa-facebook-f"></i>
            </a>

            <a href="#">
                <i class="fab fa-twitter"></i>
            </a>

            <a href="#">
                <i class="fab fa-youtube"></i>
            </a>

            <a href="#">
                <i class="fab fa-linkedin-in"></i>
            </a>

        </div>

    </aside>
</header>