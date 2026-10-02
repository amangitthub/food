@extends('layouts.site-layout')

@section('title', 'Home | Food Website')

@section('meta_description', 'Discover delicious food and order your favourite meals online.')

@section('content')
<!-- Hero Section Start -->
<section class="hero-section">

    <div class="swiper hero-slider">

        <div class="swiper-wrapper">

            {{-- =========================  SLIDE 1   ========================== --}}
            <div class="swiper-slide">

                <div class="hero-2 bg-cover"
                    style="background-image: url('{{ asset('assets/img/hero/hero-bg-2.jpg') }}');">

                    <div class="left-shape" data-animation="fadeInUp" data-delay="2.2s">

                        <img src="{{ asset('assets/img/hero/left-shape.png') }}" alt="Indian food decoration">

                    </div>

                    <div class="chili-shape" data-animation="fadeInUp" data-delay="2.4s">

                        <img src="{{ asset('assets/img/hero/leaves%2bchilli.png') }}" alt="Fresh chilli">

                    </div>

                    <div class="vagetable-shape" data-animation="fadeInUp" data-delay="2.8s">

                        <img src="{{ asset('assets/img/hero/onion%2btomato.png') }}" alt="Fresh vegetables">

                    </div>

                    <div class="container">

                        <div class="row justify-content-between align-items-center">

                            <div class="col-xl-6 col-lg-6">

                                <div class="hero-content">

                                    <p data-animation="fadeInUp" data-delay="1.3s">
                                        Fresh, tasty & made with love
                                    </p>

                                    <h1 data-animation="fadeInUp" data-delay="1.5s">

                                        Delicious
                                        <br>
                                        Chicken Burger

                                    </h1>

                                    <div data-animation="fadeInUp" data-delay="1.7s" class="price-text">

                                        <h3>Special Offer /</h3>

                                        <h2>₹149</h2>

                                    </div>

                                    <div class="hero-button">

                                        <a href="{{ url('/products') }}" class="theme-btn" data-animation="fadeInUp"
                                            data-delay="1.9s">

                                            <span class="button-content-wrapper d-flex align-items-center">

                                                <span class="button-icon">
                                                    <i class="flaticon-delivery"></i>
                                                </span>

                                                <span class="button-text">
                                                    Order Now
                                                </span>

                                            </span>

                                        </a>

                                    </div>

                                </div>

                            </div>


                            <div class="col-xl-6 col-lg-6 mt-5 mt-lg-0">

                                <div class="burger-image" data-animation="fadeInUp" data-delay="1.4s">

                                    <img src="{{ asset('assets/img/hero/burger.png') }}" alt="Chicken Burger">

                                    <div class="burger-text" data-animation="fadeInUp" data-delay="1.6s">

                                        <img src="{{ asset('assets/img/hero/burger-text.png') }}" alt="Best burger">

                                    </div>

                                    <div class="hero-text" data-animation="fadeInUp" data-delay="1.8s">

                                        <img src="{{ asset('assets/img/hero/today_best_deals.png') }}"
                                            alt="Today's best deals">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================     SLIDE 2       ========================== --}}
            <div class="swiper-slide">

                <div class="hero-2 bg-cover"
                    style="background-image: url('{{ asset('assets/img/hero/hero-bg-2.jpg') }}');">

                    <div class="left-shape" data-animation="fadeInUp" data-delay="2.2s">

                        <img src="{{ asset('assets/img/hero/left-shape.png') }}" alt="Food decoration">

                    </div>

                    <div class="chili-shape" data-animation="fadeInUp" data-delay="2.4s">

                        <img src="{{ asset('assets/img/hero/leaves%2bchilli.png') }}" alt="Fresh chilli">

                    </div>

                    <div class="vagetable-shape" data-animation="fadeInUp" data-delay="2.8s">

                        <img src="{{ asset('assets/img/hero/onion%2btomato.png') }}" alt="Fresh vegetables">

                    </div>

                    <div class="container">

                        <div class="row justify-content-between align-items-center">

                            <div class="col-xl-6 col-lg-6">

                                <div class="hero-content">

                                    <p data-animation="fadeInUp" data-delay="1.3s">
                                        Authentic Indian flavours
                                    </p>

                                    <h1 data-animation="fadeInUp" data-delay="1.5s">

                                        Crispy
                                        <br>
                                        Chicken Burger

                                    </h1>

                                    <div data-animation="fadeInUp" data-delay="1.7s" class="price-text">

                                        <h3>Starting From /</h3>

                                        <h2>₹129</h2>

                                    </div>

                                    <div class="hero-button">

                                        <a href="{{ url('/products') }}" class="theme-btn" data-animation="fadeInUp"
                                            data-delay="1.9s">

                                            <span class="button-content-wrapper d-flex align-items-center">

                                                <span class="button-icon">
                                                    <i class="flaticon-delivery"></i>
                                                </span>

                                                <span class="button-text">
                                                    Order Now
                                                </span>

                                            </span>

                                        </a>

                                    </div>

                                </div>

                            </div>


                            <div class="col-xl-6 col-lg-6 mt-5 mt-lg-0">

                                <div class="burger-image" data-animation="fadeInUp" data-delay="1.4s">

                                    <img src="{{ asset('assets/img/hero/burger.png') }}" alt="Crispy Chicken Burger">

                                    <div class="burger-text" data-animation="fadeInUp" data-delay="1.6s">

                                        <img src="{{ asset('assets/img/hero/burger-text.png') }}"
                                            alt="Fresh and crispy">

                                    </div>

                                    <div class="hero-text" data-animation="fadeInUp" data-delay="1.8s">

                                        <img src="{{ asset('assets/img/hero/today_best_deals.png') }}"
                                            alt="Best food deals">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================
            SLIDE 3
            ========================== --}}
            <div class="swiper-slide">

                <div class="hero-2 bg-cover"
                    style="background-image: url('{{ asset('assets/img/hero/hero-bg-2.jpg') }}');">

                    <div class="left-shape" data-animation="fadeInUp" data-delay="2.2s">

                        <img src="{{ asset('assets/img/hero/left-shape.png') }}" alt="Food decoration">

                    </div>

                    <div class="chili-shape" data-animation="fadeInUp" data-delay="2.4s">

                        <img src="{{ asset('assets/img/hero/leaves%2bchilli.png') }}" alt="Fresh chilli">

                    </div>

                    <div class="vagetable-shape" data-animation="fadeInUp" data-delay="2.8s">

                        <img src="{{ asset('assets/img/hero/onion%2btomato.png') }}" alt="Fresh vegetables">

                    </div>

                    <div class="container">

                        <div class="row justify-content-between align-items-center">

                            <div class="col-xl-6 col-lg-6">

                                <div class="hero-content">

                                    <p data-animation="fadeInUp" data-delay="1.3s">
                                        Great taste at great prices
                                    </p>

                                    <h1 data-animation="fadeInUp" data-delay="1.5s">

                                        Hot & Spicy
                                        <br>
                                        Chicken Burger

                                    </h1>

                                    <div data-animation="fadeInUp" data-delay="1.7s" class="price-text">

                                        <h3>Today's Deal /</h3>

                                        <h2>₹159</h2>

                                    </div>

                                    <div class="hero-button">

                                        <a href="{{ url('/products') }}" class="theme-btn" data-animation="fadeInUp"
                                            data-delay="1.9s">

                                            <span class="button-content-wrapper d-flex align-items-center">

                                                <span class="button-icon">
                                                    <i class="flaticon-delivery"></i>
                                                </span>

                                                <span class="button-text">
                                                    Order Now
                                                </span>

                                            </span>

                                        </a>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 mt-5 mt-lg-0">

                                <div class="burger-image" data-animation="fadeInUp" data-delay="1.4s">

                                    <img src="{{ asset('assets/img/hero/burger.png') }}" alt="Hot Spicy Chicken Burger">

                                    <div class="burger-text" data-animation="fadeInUp" data-delay="1.6s">

                                        <img src="{{ asset('assets/img/hero/burger-text.png') }}" alt="Special burger">

                                    </div>

                                    <div class="hero-text" data-animation="fadeInUp" data-delay="1.8s">

                                        <img src="{{ asset('assets/img/hero/today_best_deals.png') }}"
                                            alt="Today's best deals">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

            {{-- =========================
            SLIDE 4
            ========================== --}}
            <div class="swiper-slide">

                <div class="hero-2 bg-cover"
                    style="background-image: url('{{ asset('assets/img/hero/hero-bg-2.jpg') }}');">

                    <div class="left-shape" data-animation="fadeInUp" data-delay="2.2s">

                        <img src="{{ asset('assets/img/hero/left-shape.png') }}" alt="Food decoration">

                    </div>

                    <div class="chili-shape" data-animation="fadeInUp" data-delay="2.4s">

                        <img src="{{ asset('assets/img/hero/leaves%2bchilli.png') }}" alt="Fresh chilli">

                    </div>

                    <div class="vagetable-shape" data-animation="fadeInUp" data-delay="2.8s">

                        <img src="{{ asset('assets/img/hero/onion%2btomato.png') }}" alt="Fresh vegetables">

                    </div>

                    <div class="container">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-xl-6 col-lg-6">
                                <div class="hero-content">
                                    <p data-animation="fadeInUp" data-delay="1.3s">
                                        Order fresh food at your doorstep
                                    </p>

                                    <h1 data-animation="fadeInUp" data-delay="1.5s">
                                        Fresh Food
                                        <br>
                                        Delivered Fast
                                    </h1>

                                    <div data-animation="fadeInUp" data-delay="1.7s" class="price-text">
                                        <h3>Meals Starting /</h3>
                                        <h2>₹99</h2>

                                    </div>

                                    <div class="hero-button">

                                        <a href="{{ url('/products') }}" class="theme-btn" data-animation="fadeInUp"
                                            data-delay="1.9s">

                                            <span class="button-content-wrapper d-flex align-items-center">

                                                <span class="button-icon">
                                                    <i class="flaticon-delivery"></i>
                                                </span>
                                                <span class="button-text">
                                                    Order Now
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-6 mt-5 mt-lg-0">
                                <div class="burger-image" data-animation="fadeInUp" data-delay="1.4s">

                                    <img src="{{ asset('assets/img/hero/burger.png') }}" alt="Fresh Food">
                                    <div class="burger-text" data-animation="fadeInUp" data-delay="1.6s">
                                        <img src="{{ asset('assets/img/hero/burger-text.png') }}" alt="Fresh food">
                                    </div>

                                    <div class="hero-text" data-animation="fadeInUp" data-delay="1.8s">
                                        <img src="{{ asset('assets/img/hero/today_best_deals.png') }}"
                                            alt="Today's best deals">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Slider Dots --}}
    <div class="swiper-dot text-center pt-5">
        <div class="dot"></div>
    </div>

</section>
<!-- Hero Section End -->
{{-- =========================================================
FOOD CATEGORY SECTION
Popular food categories
========================================================= --}}
<section class="food-category-section fix section-padding section-bg">

    {{-- Decorative Tomato Shape --}}
    <div class="tomato-shape">
        <img src="{{ asset('assets/img/shape/tomato-shape.png') }}" alt="Tomato Shape">
    </div>

    {{-- Decorative Burger Shape --}}
    <div class="burger-shape-2">
        <img src="{{ asset('assets/img/shape/burger-shape-2.png') }}" alt="Burger Shape">
    </div>

    <div class="container">

        {{-- Section Heading --}}
        <div class="row">

            <div class="col-md-7 col-9">

                <div class="section-title">

                    <span class="wow fadeInUp">
                        Fresh, tasty & made with love
                    </span>

                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        Popular Food Items
                    </h2>

                </div>

            </div>

            {{-- Slider Navigation --}}
            <div class="col-md-5 ps-0 col-3 text-end wow fadeInUp" data-wow-delay=".5s">

                <div class="array-button">

                    <button class="array-prev" aria-label="Previous">
                        <i class="far fa-long-arrow-left"></i>
                    </button>

                    <button class="array-next" aria-label="Next">
                        <i class="far fa-long-arrow-right"></i>
                    </button>

                </div>

            </div>

        </div>


        {{-- =====================================================
        FOOD CATEGORY SLIDER
        ====================================================== --}}
        <div class="swiper food-catagory-slider">

            <div class="swiper-wrapper">
                {{-- ========================= CATEGORY 1 - PIZZA ========================== --}}
                <div class="swiper-slide">

                    <div class="catagory-product-card bg-cover"
                        style="background-image: url('{{ asset('assets/img/shape/catagory-card-shape.jpg') }}');">

                        <h5> 12+ Products </h5>

                        <div class="catagory-product-image text-center">

                            <a href="{{ url('/products') }}">

                                <img src="{{ asset('assets/img/food/pizza.png') }}" alt="Pizza">

                                <div class="decor-leaf">
                                    <img src="{{ asset('assets/img/shape/decor-leaf.svg') }}" alt="Decoration">
                                </div>

                                <div class="decor-leaf-2">
                                    <img src="{{ asset('assets/img/shape/decor-leaf-2.svg') }}" alt="Decoration">
                                </div>

                                <div class="burger-shape">
                                    <img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt="Decoration">
                                </div>
                            </a>
                        </div>

                        <div class="catagory-product-content text-center">

                            <div class="catagory-product-icon">
                                <img src="{{ asset('assets/img/shape/food-shape.svg') }}" alt="Food Shape">
                            </div>

                            <h3>
                                <a href="{{ url('/products') }}">Pizza </a>
                            </h3>

                            <p> Fresh & Cheesy Pizza </p>

                        </div>

                    </div>

                </div>


                {{-- =========================
                CATEGORY 2 - PASTA
                ========================== --}}
                <div class="swiper-slide">

                    <div class="catagory-product-card bg-cover"
                        style="background-image: url('{{ asset('assets/img/shape/catagory-card-shape.jpg') }}');">
                        <h5> 10+ Products </h5>
                        <div class="catagory-product-image text-center">

                            <a href="{{ url('/products') }}">
                                <img src="{{ asset('assets/img/food/pasta.png') }}" alt="Pasta">
                                <div class="decor-leaf">
                                    <img src="{{ asset('assets/img/shape/decor-leaf.svg') }}" alt="Decoration">
                                </div>
                                <div class="decor-leaf-2">
                                    <img src="{{ asset('assets/img/shape/decor-leaf-2.svg') }}" alt="Decoration">
                                </div>
                                <div class="burger-shape">
                                    <img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt="Decoration">
                                </div>
                            </a>

                        </div>

                        <div class="catagory-product-content text-center">

                            <div class="catagory-product-icon">

                                <img src="{{ asset('assets/img/shape/food-shape.svg') }}" alt="Food Shape">

                            </div>

                            <h3>
                                <a href="{{ url('/products') }}">
                                    Pasta
                                </a>
                            </h3>

                            <p>
                                Delicious Pasta
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ====================== CATEGORY 3 - BURGER ========================== --}}
                <div class="swiper-slide">

                    <div class="catagory-product-card bg-cover"
                        style="background-image: url('{{ asset('assets/img/shape/catagory-card-shape.jpg') }}');">

                        <h5>
                            15+ Products
                        </h5>

                        <div class="catagory-product-image text-center">

                            <a href="{{ url('/products') }}">

                                <img src="{{ asset('assets/img/food/burger.png') }}" alt="Burger">

                                <div class="decor-leaf">
                                    <img src="{{ asset('assets/img/shape/decor-leaf.svg') }}" alt="Decoration">
                                </div>

                                <div class="decor-leaf-2">
                                    <img src="{{ asset('assets/img/shape/decor-leaf-2.svg') }}" alt="Decoration">
                                </div>

                                <div class="burger-shape">
                                    <img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt="Decoration">
                                </div>

                            </a>

                        </div>

                        <div class="catagory-product-content text-center">

                            <div class="catagory-product-icon">

                                <img src="{{ asset('assets/img/shape/food-shape.svg') }}" alt="Food Shape">

                            </div>

                            <h3>
                                <a href="{{ url('/products') }}">
                                    Burgers
                                </a>
                            </h3>

                            <p>
                                Juicy & Crispy Burgers
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ========================= CATEGORY 4 - FRENCH FRIES ========================== --}}
                <div class="swiper-slide">

                    <div class="catagory-product-card bg-cover"
                        style="background-image: url('{{ asset('assets/img/shape/catagory-card-shape.jpg') }}');">

                        <h5>
                            8+ Products
                        </h5>

                        <div class="catagory-product-image text-center">

                            <a href="{{ url('/products') }}">

                                <img src="{{ asset('assets/img/food/french-fry.png') }}" alt="French Fries">

                                <div class="decor-leaf">
                                    <img src="{{ asset('assets/img/shape/decor-leaf.svg') }}" alt="Decoration">
                                </div>

                                <div class="decor-leaf-2">
                                    <img src="{{ asset('assets/img/shape/decor-leaf-2.svg') }}" alt="Decoration">
                                </div>

                                <div class="burger-shape">
                                    <img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt="Decoration">
                                </div>

                            </a>

                        </div>

                        <div class="catagory-product-content text-center">

                            <div class="catagory-product-icon">

                                <img src="{{ asset('assets/img/shape/food-shape.svg') }}" alt="Food Shape">

                            </div>

                            <h3>
                                <a href="{{ url('/products') }}">
                                    Snacks
                                </a>
                            </h3>

                            <p> Crispy & Delicious Snacks </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
{{-- ============================= FOOD CATEGORY SECTION END ======================== --}}

{{-- =================== FOOD OFFER / BANNER SECTION ====================== --}}
<section class="food-banner-section section-padding fix section-bg pt-0">

    {{-- Decorative Chilli --}}
    <div class="chili-shape">
        <img src="{{ asset('assets/img/shape/chili-shape.png') }}" alt="Chilli Shape">
    </div>

    {{-- Decorative Fries --}}
    <div class="fry-shape">
        <img src="{{ asset('assets/img/shape/fry-shape.png') }}" alt="French Fries Shape">
    </div>

    <div class="container">

        <div class="row">
            {{-- ========================= SPECIAL OFFER BANNER ========================== --}}
            <div class="col-xl-5 wow fadeInUp" data-wow-delay=".3s">

                <div class="single-offer-items bg-cover"
                    style="background-image: url('{{ asset('assets/img/banner/offer-bg.png') }}');">

                    <div class="offer-content">
                        <h5> Fresh & Delicious </h5>
                        <h3> SUPER <br> DEALS </h3>

                    </div>

                    <div class="offer-image">
                        <img src="{{ asset('assets/img/offer/50percent-off.png') }}" alt="50 Percent Discount">
                    </div>

                    <div class="burger-text">
                        <img src="{{ asset('assets/img/shape/burger-text.png') }}" alt="Burger Special">
                    </div>

                    <div class="main-food">
                        <img src="{{ asset('assets/img/food/main-food.png') }}" alt="Special Food">
                    </div>

                </div>

            </div>


            {{-- ========================= PIZZA OFFER BANNER ========================== --}}
            <div class="col-xl-7 mt-5 mt-xl-0 wow fadeInUp" data-wow-delay=".5s">

                <div class="pizza-banner-items bg-cover"
                    style="background-image: url('{{ asset('assets/img/banner/pizza-bg.png') }}');">

                    <div class="pizza-text">
                        <img src="{{ asset('assets/img/shape/pizza-text.png') }}" alt="Pizza Special">
                    </div>

                    <div class="pizza-text-2">
                        <img src="{{ asset('assets/img/shape/pizza-text-2.png') }}" alt="Pizza Offer">
                    </div>

                    <div class="pizza-image">
                        <img src="{{ asset('assets/img/food/pizza-2.png') }}" alt="Delicious Pizza">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- =======================FOOD OFFER / BANNER SECTION END ============================= --}

{{-- ================ BRAND / TRUST SECTION ================= --}}
<section class="brand-shape section-padding fix section-bg pt-0">

    <div class="container">
        <div class="brand-wrapper">
            <div class="brand-title">
                <h4>
                    Trusted by
                    <span>5K+</span>
                    Happy Customers
                </h4>
            </div>


            {{-- Brand Slider --}}
            <div class="swiper brand-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="brand-image">
                            <img src="{{ asset('assets/img/brand/01.svg') }}" alt="Partner">
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="brand-image">
                            <img src="{{ asset('assets/img/brand/02.svg') }}" alt="Partner">
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="brand-image">
                            <img src="{{ asset('assets/img/brand/03.svg') }}" alt="Partner">
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="brand-image">
                            <img src="{{ asset('assets/img/brand/04.svg') }}" alt="Partner">
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="brand-image">
                            <img src="{{ asset('assets/img/brand/05.svg') }}" alt="Partner">
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="brand-image">
                            <img src="{{ asset('assets/img/brand/06.svg') }}" alt="Partner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- ==============BRAND / TRUST SECTION END============== --}}


{{-- =============GRILLED FOOD OFFER SECTION ============== --}}
<section class="grilled-banner fix section-padding bg-cover"
    style="background-image: url('{{ asset('assets/img/banner/main-bg.jpg') }}');">
    {{-- Decorative Potato --}}
    <div class="patato-shape">
        <img src="{{ asset('assets/img/shape/patato-shape.png') }}" alt="Potato Shape">
    </div>

    {{-- Discount Badge --}}
    <div class="offer-shape float-bob-y">
        <img src="{{ asset('assets/img/offer/50percent-off-2.png') }}" alt="Special Discount">
    </div>

    {{-- Decorative Text --}}
    <div class="text-shape">
        <img src="{{ asset('assets/img/shape/pizza-text-2.png') }}" alt="Food Text">
    </div>
    {{-- Spicy Badge --}}
    <div class="spicy-shape">
        <img src="{{ asset('assets/img/shape/spicy.png') }}" alt="Spicy Food">
    </div>
    {{-- Tomato --}}
    <div class="tomato-shape">
        <img src="{{ asset('assets/img/shape/tomato-shape-2.png') }}" alt="Tomato Shape">
    </div>


    <div class="container">

        <div class="grilled-wrapper">
            <div class="row align-items-center">

                {{-- ==================GRILLED FOOD CONTENT====================== --}}
                <div class="col-xl-6 col-lg-6">

                    <div class="grilled-content">

                        <h4 class="wow fadeInUp">
                            Save 20%
                        </h4>

                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            TODAY'S
                            <span>DELICIOUS</span>
                            DEAL
                        </h2>

                        <h3 class="wow fadeInUp" data-wow-delay=".5s">

                            <a href="{{ url('/products') }}">
                                Grilled
                                <span class="text-1">
                                    Chicken
                                </span>

                            </a>
                            <span class="text-2">
                                ₹299
                            </span>
                        </h3>

                        {{-- Order Button --}}
                        <div class="grilled-button wow fadeInUp" data-wow-delay=".7s">
                            <a href="{{ url('/products') }}" class="theme-btn">
                                <span class="button-content-wrapper d-flex align-items-center">
                                    <span class="button-icon">
                                        <i class="flaticon-delivery"></i>
                                    </span>
                                    <span class="button-text">
                                        Order Now
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ===================== GRILLED FOOD IMAGE==================== --}}
                <div class="col-xl-6 col-lg-6 mt-5 mt-lg-0 wow fadeInUp" data-wow-delay=".4s">

                    <div class="grilled-image">

                        <img src="{{ asset('assets/img/food/grilled.png') }}" alt="Grilled Chicken">

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
{{-- =========================================================
GRILLED FOOD OFFER SECTION END
========================================================= --}}

@endsection