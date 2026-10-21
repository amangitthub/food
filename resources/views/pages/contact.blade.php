@extends('layouts.site-layout')

@section('title', 'Contact Us')

@section('content')

<style>
    /* Uses your website variables (--theme, --theme3, --bg ...) with safe fallbacks */
    .food-contact-page {
        --g: var(--theme, #02af53);
        --gd: #006a32;
        --y: var(--theme3, #ffb936);
        --dark: var(--header, #212121);
        --txt: var(--text, #5c5c5b);
        --ln: var(--border, #d9d9d9);
        --cream: var(--bg, #f4f1ea);
        --soft: #e6f4ec;
        background: #fff;
        overflow: hidden
    }

    .food-contact-page * {
        box-sizing: border-box
    }

    /* =============== HERO =============== */
    .food-contact-hero {
        position: relative;
        min-height: 410px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(1, 105, 48, 0.96) 0%, rgba(0, 116, 54, 0.92) 45%, rgba(0, 90, 42, 0.86) 100%),
        url('{{ asset('assets/img/breadcrumb/breadcrumb.jpg') }}') center/cover no-repeat
    }

    /* cinematic overlay */
    .food-contact-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        background: radial-gradient(circle at 15% 25%, rgba(255, 185, 54, .2), transparent 30%), radial-gradient(circle at 85% 70%, rgba(255, 255, 255, .12), transparent 32%), linear-gradient(180deg, rgba(0, 0, 0, .08), rgba(0, 0, 0, .42))
    }

    /* big decorative circle */
    .food-contact-hero::after {
        content: "";
        position: absolute;
        z-index: 1;
        width: 460px;
        height: 460px;
        right: -190px;
        top: -190px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 50%;
        box-shadow: 0 0 0 35px rgba(255, 255, 255, .025), 0 0 0 70px rgba(255, 255, 255, .018), 0 0 0 105px rgba(255, 255, 255, .012)
    }

    .food-contact-hero-content {
        position: relative;
        z-index: 5;
        text-align: center;
        padding: 45px 20px
    }

    .food-contact-hero .hero-small-title {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 20px;
        color: var(--y);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 3px;
        text-transform: uppercase;
        text-shadow: 0 3px 12px rgba(0, 0, 0, .35)
    }

    .food-contact-hero .hero-small-title::before,
    .food-contact-hero .hero-small-title::after {
        content: "";
        width: 45px;
        height: 2px;
        background: var(--y);
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(255, 185, 54, .7)
    }

    .food-contact-hero h1 {
        position: relative;
        margin: 0 0 16px;
        color: #fff;
        font-size: 66px;
        line-height: 1.05;
        font-weight: 900;
        letter-spacing: -1.5px;
        text-shadow: 0 5px 20px rgba(0, 0, 0, .35)
    }

    .food-contact-hero h1::after {
        content: "";
        display: block;
        width: 70px;
        height: 4px;
        margin: 18px auto 0;
        border-radius: 20px;
        background: linear-gradient(90deg, var(--y), #ff8a00);
        box-shadow: 0 0 15px rgba(255, 185, 54, .5)
    }

    .food-contact-hero p {
        max-width: 650px;
        margin: 22px auto 0;
        color: rgba(255, 255, 255, .92);
        font-size: 16px;
        line-height: 1.7;
        text-shadow: 0 2px 8px rgba(0, 0, 0, .35)
    }

    .food-contact-breadcrumb {
        display: inline-flex;
        align-items: center;
        margin-top: 25px;
        padding: 9px 22px;
        border-radius: 50px;
        background: rgba(0, 0, 0, .24);
        border: 1px solid rgba(255, 255, 255, .2);
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, .14)
    }

    .food-contact-breadcrumb a,
    .food-contact-breadcrumb span {
        color: #fff;
        font-size: 14px
    }

    .food-contact-breadcrumb a {
        color: var(--y);
        font-weight: 700;
        text-decoration: none;
        transition: .3s
    }

    .food-contact-breadcrumb a:hover {
        color: #fff
    }

    .food-contact-breadcrumb span {
        margin: 0 9px;
        opacity: .65
    }

    /* floating stars */
    .food-contact-hero-content::before,
    .food-contact-hero-content::after {
        content: "✦";
        position: absolute
    }

    .food-contact-hero-content::before {
        left: -150px;
        top: 15px;
        color: rgba(255, 185, 54, .6);
        font-size: 30px
    }

    .food-contact-hero-content::after {
        right: -150px;
        bottom: 20px;
        color: rgba(255, 255, 255, .35);
        font-size: 24px
    }

    /* =============== MAIN SECTION =============== */
    .food-contact-section {
        position: relative;
        padding: 105px 0 95px;
        background: linear-gradient(180deg, #fff 0%, var(--cream) 100%)
    }

    .food-contact-section::before,
    .food-contact-section::after {
        content: "";
        position: absolute;
        border-radius: 50%
    }

    .food-contact-section::before {
        width: 300px;
        height: 300px;
        left: -150px;
        top: 100px;
        background: rgba(0, 129, 61, .05)
    }

    .food-contact-section::after {
        width: 220px;
        height: 220px;
        right: -100px;
        bottom: 150px;
        background: rgba(255, 185, 54, .09)
    }

    .food-contact-section .container {
        position: relative;
        z-index: 2
    }

    /* left heading */
    .food-contact-heading {
        margin-bottom: 35px
    }

    .food-contact-heading .sub-title {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 14px;
        padding: 6px 16px;
        background: var(--soft);
        color: var(--g);
        border-radius: 99px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px
    }

    .food-contact-heading .sub-title i {
        font-size: 15px
    }

    .food-contact-heading h2 {
        margin: 0 0 17px;
        color: var(--dark);
        font-size: 43px;
        line-height: 1.16;
        font-weight: 800
    }

    .food-contact-heading h2 span {
        position: relative;
        color: var(--g)
    }

    .food-contact-heading h2 span::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -4px;
        height: 4px;
        background: var(--y);
        border-radius: 10px
    }

    .food-contact-heading p {
        max-width: 550px;
        margin: 0;
        color: var(--txt);
        font-size: 15px;
        line-height: 1.9
    }

    /* info cards */
    .food-contact-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px
    }

    .food-contact-info-card {
        position: relative;
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 94px;
        padding: 19px 16px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #ece8de;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(33, 33, 33, .04);
        transition: .3s
    }

    .food-contact-info-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--g), var(--y));
        transform: scaleY(0);
        transform-origin: bottom;
        transition: .3s
    }

    .food-contact-info-card::after {
        content: "";
        position: absolute;
        width: 70px;
        height: 70px;
        right: -25px;
        bottom: -28px;
        border-radius: 50%;
        background: rgba(0, 129, 61, .05);
        transition: .3s
    }

    .food-contact-info-card:hover {
        transform: translateY(-5px);
        border-color: rgba(0, 129, 61, .3);
        box-shadow: 0 15px 35px rgba(33, 33, 33, .1)
    }

    .food-contact-info-card:hover::before {
        transform: scaleY(1)
    }

    .food-contact-info-card:hover::after {
        transform: scale(1.5)
    }

    .food-contact-info-icon {
        position: relative;
        z-index: 2;
        width: 50px;
        height: 50px;
        min-width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--soft);
        color: var(--g);
        font-size: 19px;
        transition: .3s
    }

    .food-contact-info-card:hover .food-contact-info-icon {
        background: var(--g);
        color: #fff;
        transform: rotate(8deg)
    }

    .food-contact-info-content {
        position: relative;
        z-index: 2;
        min-width: 0
    }

    .food-contact-info-content h5 {
        margin: 0 0 4px;
        color: var(--dark);
        font-size: 15px;
        font-weight: 700
    }

    .food-contact-info-content p {
        margin: 0;
        color: var(--txt);
        font-size: 13px;
        line-height: 1.55;
        overflow-wrap: anywhere
    }

    /* form card */
    .food-contact-form-wrapper {
        position: relative;
        padding: 45px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #ece8de;
        border-radius: 22px;
        box-shadow: 0 20px 55px rgba(33, 33, 33, .1)
    }

    .food-contact-form-wrapper::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--g), #2fb36b, var(--y))
    }

    .food-contact-form-wrapper::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        right: -80px;
        bottom: -80px;
        border-radius: 50%;
        border: 25px solid rgba(0, 129, 61, .05)
    }

    .food-contact-form-title {
        position: relative;
        z-index: 2;
        margin-bottom: 30px
    }

    .food-contact-form-title h3 {
        margin: 0 0 7px;
        color: var(--dark);
        font-size: 30px;
        font-weight: 800
    }

    .food-contact-form-title p {
        margin: 0;
        color: var(--txt);
        font-size: 14px;
        line-height: 1.7
    }

    .food-contact-form {
        position: relative;
        z-index: 2
    }

    .food-contact-form .form-group {
        margin-bottom: 20px
    }

    .food-contact-form label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark);
        font-size: 13px;
        font-weight: 700
    }

    .food-contact-form .form-control {
        width: 100%;
        height: 54px;
        padding: 0 16px;
        background: #fff;
        border: 1px solid var(--ln);
        border-radius: 12px;
        box-shadow: none;
        color: var(--dark);
        font-size: 14px;
        transition: .3s
    }

    .food-contact-form textarea.form-control {
        height: 140px;
        padding: 14px 16px;
        resize: none
    }

    .food-contact-form .form-control::placeholder {
        color: #a3a3a0
    }

    .food-contact-form .form-control:focus {
        border-color: var(--g);
        box-shadow: 0 0 0 4px rgba(0, 129, 61, .12);
        outline: none
    }

    /* send button */
    .food-contact-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px 30px;
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--g), #2fb36b);
        color: #fff;
        font-size: 14.5px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 10px 22px rgba(0, 129, 61, .25);
        transition: .3s
    }

    .food-contact-submit:hover {
        background: linear-gradient(135deg, #181818, #333);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, .18)
    }

    .food-contact-submit i {
        transition: .3s
    }

    .food-contact-submit:hover i {
        transform: translateX(4px)
    }

    /* bottom features */
    .food-contact-bottom {
        margin-top: 85px
    }

    .food-contact-feature {
        position: relative;
        height: 100%;
        padding: 38px 25px;
        text-align: center;
        overflow: hidden;
        background: linear-gradient(145deg, #f7fbf8, #fff);
        border: 1px solid #e1eee6;
        border-radius: 20px;
        transition: .3s
    }

    .food-contact-feature:hover {
        transform: translateY(-7px);
        background: #fff;
        border-color: #c9e3d5;
        box-shadow: 0 18px 40px rgba(33, 33, 33, .09)
    }

    .food-contact-feature::after {
        content: "";
        position: absolute;
        width: 110px;
        height: 110px;
        right: -40px;
        bottom: -45px;
        border-radius: 50%;
        background: rgba(0, 129, 61, .05)
    }

    .food-contact-feature-icon {
        position: relative;
        z-index: 2;
        width: 65px;
        height: 65px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--g), #2fb36b);
        color: #fff;
        font-size: 22px;
        box-shadow: 0 10px 25px rgba(0, 129, 61, .25);
        transition: .3s
    }

    .food-contact-feature:hover .food-contact-feature-icon {
        transform: translateY(-3px) rotate(8deg)
    }

    .food-contact-feature h4 {
        position: relative;
        z-index: 2;
        margin: 0 0 9px;
        color: var(--dark);
        font-size: 18px;
        font-weight: 800
    }

    .food-contact-feature p {
        position: relative;
        z-index: 2;
        margin: 0;
        color: var(--txt);
        font-size: 14px;
        line-height: 1.7
    }

    @media(prefers-reduced-motion:reduce) {
        .food-contact-page * {
            transition: none !important
        }
    }

    /* =============== RESPONSIVE =============== */
    @media(max-width:991px) {
        .food-contact-hero {
            min-height: 340px
        }

        .food-contact-hero h1 {
            font-size: 54px
        }

        .food-contact-hero-content::before {
            left: -80px
        }

        .food-contact-hero-content::after {
            right: -80px
        }

        .food-contact-section {
            padding: 75px 0
        }

        .food-contact-heading h2 {
            font-size: 36px
        }

        .food-contact-form-wrapper {
            margin-top: 20px
        }
    }

    @media(max-width:767px) {
        .food-contact-hero {
            min-height: 310px
        }

        .food-contact-hero-content {
            padding: 35px 15px
        }

        .food-contact-hero h1 {
            font-size: 42px
        }

        .food-contact-hero p {
            font-size: 14px
        }

        .food-contact-hero .hero-small-title {
            font-size: 11px;
            letter-spacing: 2px
        }

        .food-contact-hero .hero-small-title::before,
        .food-contact-hero .hero-small-title::after {
            width: 25px
        }

        .food-contact-hero-content::before,
        .food-contact-hero-content::after {
            display: none
        }

        .food-contact-section {
            padding: 60px 0
        }

        .food-contact-heading h2 {
            font-size: 30px
        }

        .food-contact-heading p {
            font-size: 14px
        }

        .food-contact-info {
            grid-template-columns: 1fr
        }

        .food-contact-form-wrapper {
            padding: 32px 22px;
            border-radius: 18px
        }

        .food-contact-form-title h3 {
            font-size: 24px
        }

        .food-contact-bottom {
            margin-top: 55px
        }
    }

    @media(max-width:480px) {
        .food-contact-hero {
            min-height: 275px
        }

        .food-contact-hero h1 {
            font-size: 35px
        }

        .food-contact-hero p {
            font-size: 13px
        }

        .food-contact-hero .hero-small-title {
            font-size: 10px;
            letter-spacing: 1.3px
        }

        .food-contact-breadcrumb {
            padding: 7px 14px
        }

        .food-contact-breadcrumb a,
        .food-contact-breadcrumb span {
            font-size: 12px
        }

        .food-contact-heading h2 {
            font-size: 27px
        }

        .food-contact-form-wrapper {
            padding: 30px 18px
        }

        .food-contact-info-card {
            padding: 17px 14px
        }

        .food-contact-info-content p {
            font-size: 12px
        }

        .food-contact-submit {
            width: 100%
        }
    }

</style>

<div class="food-contact-page">
    {{-- =====================================================
    CONTACT HERO - PREMIUM FOOD THEME
    ====================================================== --}}
    <section class="food-contact-hero">
        <div class="container">
            <div class="food-contact-hero-content">
                <div class="hero-small-title">
                    <span>Welcome To Our Kitchen</span>
                </div>
                <h1>
                    Contact Us
                </h1>
                <p>
                    We'd love to hear from you.
                    Let's make something delicious together.
                </p>
                <div class="food-contact-breadcrumb">

                    <a href="{{ route('home') }}">
                        Home
                    </a>
                    <span>/</span>
                    <span>
                        Contact Us
                    </span>
                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
    MAIN CONTACT SECTION
    ====================================================== --}}

    <section class="food-contact-section">
        <div class="container">
            <div class="row align-items-start g-5">
                {{-- =================================================
                LEFT CONTENT
                ================================================== --}}
                <div class="col-lg-5">
                    <div class="food-contact-heading">
                        <div class="sub-title">
                            <i class="fa fa-comments"></i>
                            Get In Touch
                        </div>

                        <h2>
                            Let's Talk About
                            <br>
                            Something
                            <span>Delicious</span>
                        </h2>
                        <p>
                            Have a question about our menu, products or
                            services? Our team is always happy to help.
                            Send us a message and we'll get back to you
                            as soon as possible.
                        </p>
                    </div>

                    <div class="food-contact-info">
                        {{-- ADDRESS --}}
                        <div class="food-contact-info-card">

                            <div class="food-contact-info-icon">

                                <i class="fa fa-map-marker-alt"></i>

                            </div>
                            <div class="food-contact-info-content">
                                <h5>
                                    Our Location
                                </h5>
                                <p>
                                    Dehradun, Uttarakhand, India
                                </p>
                            </div>
                        </div>



                        {{-- PHONE --}}
                        <div class="food-contact-info-card">
                            <div class="food-contact-info-icon">
                                <i class="fa fa-phone-alt"></i>
                            </div>
                            <div class="food-contact-info-content">
                                <h5>   call Us       </h5>
                                <p>
                                    +91 98765 43210
                                </p>
                            </div>
                        </div>
                        {{-- EMAIL --}}
                        <div class="food-contact-info-card">
                            <div class="food-contact-info-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="food-contact-info-content">

                                <h5>  Email Us   </h5>
                               <p>  info@foodwebsite.com     </p>

                            </div>

                        </div>

                        {{-- OPENING HOURS --}}
                        <div class="food-contact-info-card">
                            <div class="food-contact-info-icon">
                                <i class="fa fa-clock"></i>
                            </div>


                            <div class="food-contact-info-content">
                                <h5>      Opening Hours          </h5>
                                <p>
                                    Monday - Sunday : 10:00 AM - 10:00 PM
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- =================================================
                CONTACT FORM
                ================================================== --}}

                <div class="col-lg-7">
                    <div class="food-contact-form-wrapper">
                        <div class="food-contact-form-title">

                            <h3>             Send Us A Message                       </h3>
                            <p>
                                Fill in the form below and our team will
                                get back to you shortly.
                            </p>
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {{-- FRONTEND ONLY FORM --}}
                        <form class="food-contact-form" action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- NAME --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contactName">
                                            Your Name
                                        </label>
                                      <input type="text" id="contactName" name="name" class="form-control" placeholder="Enter your name"
                                        value="{{ old('name') }}" required>

                                    </div>

                                </div>
                                {{-- EMAIL --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contactEmail">
                                            Email Address
                                        </label>
                                    <input type="email" id="contactEmail" name="email" class="form-control" placeholder="Enter your email"
                                        value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                {{-- PHONE --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contactPhone">
                                            Phone Number
                                        </label>
                                   <input type="text" id="contactPhone" name="phone" class="form-control" placeholder="Enter your phone number"
                                            value="{{ old('phone') }}" required>
                                    </div>
                                </div>

                                {{-- SUBJECT --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contactSubject">
                                            Subject
                                        </label>
                                      <input type="text" id="contactSubject" name="subject" class="form-control" placeholder="Enter subject"
                                        value="{{ old('subject') }}" required>
                                    </div>
                                </div>

                                {{-- MESSAGE --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contactMessage">
                                            Your Message
                                        </label>
                                      <textarea id="contactMessage" name="message" class="form-control" placeholder="Write your message here..."
                                        required>{{ old('message') }}</textarea>
                                    </div>

                                </div>

                                {{-- BUTTON --}}
                                <div class="col-12">
                                  <button type="submit" class="food-contact-submit">
                                        Send Message
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>

            </div>

            {{-- =================================================
            BOTTOM FEATURES
            ================================================== --}}

            <div class="row g-4 food-contact-bottom">
                {{-- QUICK SUPPORT --}}
                <div class="col-lg-4 col-md-6">
                    <div class="food-contact-feature">
                        <div class="food-contact-feature-icon">
                            <i class="fa fa-headset"></i>
                        </div>
                        <h4>
                            Quick Support
                        </h4>
                        <p>
                            Our friendly team is always ready to
                            answer your questions.
                        </p>
                    </div>

                </div>

                {{-- FRESH --}}
                <div class="col-lg-4 col-md-6">
                    <div class="food-contact-feature">
                        <div class="food-contact-feature-icon">
                            <i class="fa fa-utensils"></i>
                        </div>
                        <h4>
                            Fresh & Delicious
                        </h4>
                        <p>
                            We believe every meal should be fresh,
                            delicious and memorable.
                        </p>
                    </div>
                </div>



                {{-- LOVE --}}
                <div class="col-lg-4 col-md-6">
                    <div class="food-contact-feature">
                        <div class="food-contact-feature-icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h4>       Made With Love                </h4>
                        <p>
                            Every dish is prepared with care,
                            passion and attention to detail.
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </section>

</div>
@endsection
