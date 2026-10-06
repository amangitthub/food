@extends('layouts.site-layout')

@section('title', 'Contact Us')

@section('content')

<style>

/* =========================================================
   FOOD CONTACT PAGE
   Premium Restaurant Theme
========================================================= */

.food-contact-page {
    --food-red: #e53935;
    --food-red-dark: #c62828;
    --food-orange: #ff8a00;
    --food-yellow: #ffc107;
    --food-dark: #181818;
    --food-text: #555;
    --food-light: #fff7f2;
    --food-border: #eeeeee;

    background: #fff;
    overflow: hidden;
}


/* =========================================================
   CONTACT HERO - PREMIUM FOOD THEME
========================================================= */

.food-contact-hero {
    position: relative;
    min-height: 410px;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            rgba(93, 0, 0, .96) 0%,
            rgba(175, 20, 15, .91) 42%,
            rgba(238, 82, 0, .86) 100%
        ),
        url('{{ asset('assets/img/breadcrumb/breadcrumb.jpg') }}')
        center center / cover no-repeat;
}


/* Main dark cinematic overlay */
.food-contact-hero::before {
    content: "";

    position: absolute;
    inset: 0;

    background:
        radial-gradient(
            circle at 15% 25%,
            rgba(255, 193, 7, .18),
            transparent 30%
        ),
        radial-gradient(
            circle at 85% 70%,
            rgba(255, 255, 255, .12),
            transparent 32%
        ),
        linear-gradient(
            180deg,
            rgba(0, 0, 0, .08),
            rgba(0, 0, 0, .42)
        );

    z-index: 1;
}


/* Large decorative circle */
.food-contact-hero::after {
    content: "";

    position: absolute;

    width: 460px;
    height: 460px;

    border: 1px solid rgba(255, 255, 255, .16);

    border-radius: 50%;

    right: -190px;
    top: -190px;

    box-shadow:
        0 0 0 35px rgba(255, 255, 255, .025),
        0 0 0 70px rgba(255, 255, 255, .018),
        0 0 0 105px rgba(255, 255, 255, .012);

    z-index: 1;
}


/* Hero content */
.food-contact-hero-content {
    position: relative;

    z-index: 5;

    text-align: center;

    padding: 45px 20px;
}


/* Small top badge */
.food-contact-hero .hero-small-title {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 12px;

    color: #ffd166;

    font-size: 13px;

    font-weight: 800;

    letter-spacing: 3px;

    text-transform: uppercase;

    margin-bottom: 20px;

    text-shadow:
        0 3px 12px rgba(0, 0, 0, .35);
}


/* Badge lines */
.food-contact-hero .hero-small-title::before,
.food-contact-hero .hero-small-title::after {
    content: "";

    width: 45px;
    height: 2px;

    background: #ffd166;

    border-radius: 10px;

    box-shadow:
        0 0 12px rgba(255, 209, 102, .7);
}


/* Main Hero Heading */
.food-contact-hero h1 {
    position: relative;

    color: #fff;

    font-size: 66px;

    line-height: 1.05;

    font-weight: 900;

    letter-spacing: -1.5px;

    margin: 0 0 16px;

    text-shadow:
        0 5px 20px rgba(0, 0, 0, .35);
}


/* Small orange underline */
.food-contact-hero h1::after {
    content: "";

    display: block;

    width: 70px;
    height: 4px;

    margin: 18px auto 0;

    border-radius: 20px;

    background:
        linear-gradient(
            90deg,
            #ffd166,
            #ff8a00
        );

    box-shadow:
        0 0 15px rgba(255, 193, 7, .45);
}


/* Hero Description */
.food-contact-hero p {
    max-width: 650px;

    margin: 22px auto 0;

    color: rgba(255, 255, 255, .92);

    font-size: 16px;

    line-height: 1.7;

    text-shadow:
        0 2px 8px rgba(0, 0, 0, .35);
}


/* Breadcrumb */
.food-contact-breadcrumb {
    display: inline-flex;

    align-items: center;

    margin-top: 25px;

    padding: 9px 20px;

    border-radius: 50px;

    background: rgba(0, 0, 0, .22);

    border: 1px solid rgba(255, 255, 255, .18);

    backdrop-filter: blur(8px);

    box-shadow:
        0 8px 25px rgba(0, 0, 0, .12);
}


.food-contact-breadcrumb a,
.food-contact-breadcrumb span {
    color: #fff;

    font-size: 14px;
}


.food-contact-breadcrumb a {
    color: #ffd166;

    font-weight: 700;

    text-decoration: none;

    transition: .3s ease;
}


.food-contact-breadcrumb a:hover {
    color: #fff;
}


.food-contact-breadcrumb span {
    margin: 0 9px;

    opacity: .65;
}


/* Floating decorative dots */
.food-contact-hero-content::before {
    content: "✦";

    position: absolute;

    left: -150px;
    top: 15px;

    color: rgba(255, 209, 102, .55);

    font-size: 30px;
}


.food-contact-hero-content::after {
    content: "✦";

    position: absolute;

    right: -150px;
    bottom: 20px;

    color: rgba(255, 255, 255, .35);

    font-size: 24px;
}


/* =========================================================
   MAIN CONTACT AREA
========================================================= */

.food-contact-section {
    position: relative;

    padding: 105px 0 95px;

    background:
        linear-gradient(
            180deg,
            #ffffff 0%,
            #fffaf7 100%
        );
}


.food-contact-section::before {
    content: "";

    position: absolute;

    width: 300px;
    height: 300px;

    border-radius: 50%;

    background:
        rgba(229, 57, 53, .035);

    left: -150px;
    top: 100px;
}


.food-contact-section::after {
    content: "";

    position: absolute;

    width: 220px;
    height: 220px;

    border-radius: 50%;

    background:
        rgba(255, 138, 0, .035);

    right: -100px;
    bottom: 150px;
}


.food-contact-section .container {
    position: relative;

    z-index: 2;
}


/* =========================================================
   LEFT CONTENT
========================================================= */

.food-contact-heading {
    margin-bottom: 35px;
}


.food-contact-heading .sub-title {
    display: inline-flex;

    align-items: center;

    gap: 9px;

    color: var(--food-red);

    font-size: 14px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: 1.5px;

    margin-bottom: 14px;
}


.food-contact-heading .sub-title i {
    font-size: 16px;
}


.food-contact-heading h2 {
    color: var(--food-dark);

    font-size: 43px;

    line-height: 1.16;

    font-weight: 800;

    margin-bottom: 17px;
}


.food-contact-heading h2 span {
    color: var(--food-red);

    position: relative;
}


.food-contact-heading h2 span::after {
    content: "";

    position: absolute;

    left: 0;
    right: 0;

    bottom: -4px;

    height: 3px;

    background: var(--food-orange);

    border-radius: 10px;
}


.food-contact-heading p {
    color: #777;

    font-size: 15px;

    line-height: 1.9;

    max-width: 550px;

    margin: 0;
}


/* =========================================================
   CONTACT INFO CARDS
========================================================= */

.food-contact-info {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 15px;
}


.food-contact-info-card {
    position: relative;

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 19px 16px;

    min-height: 94px;

    border: 1px solid #eeeeee;

    background: #fff;

    transition: all .3s ease;

    overflow: hidden;
}


.food-contact-info-card::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 3px;

    background:
        linear-gradient(
            180deg,
            var(--food-red),
            var(--food-orange)
        );

    transform: scaleY(0);

    transform-origin: bottom;

    transition: .3s ease;
}


.food-contact-info-card::after {
    content: "";

    position: absolute;

    width: 70px;
    height: 70px;

    border-radius: 50%;

    background:
        rgba(229, 57, 53, .035);

    right: -25px;
    bottom: -28px;

    transition: .3s ease;
}


.food-contact-info-card:hover {
    transform: translateY(-5px);

    border-color:
        rgba(229, 57, 53, .25);

    box-shadow:
        0 15px 35px rgba(0, 0, 0, .08);
}


.food-contact-info-card:hover::before {
    transform: scaleY(1);
}


.food-contact-info-card:hover::after {
    transform: scale(1.5);
}


.food-contact-info-icon {
    width: 50px;
    height: 50px;

    min-width: 50px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #fff0ed;

    color: var(--food-red);

    font-size: 19px;

    position: relative;

    z-index: 2;

    transition: .3s ease;
}


.food-contact-info-card:hover .food-contact-info-icon {
    background: var(--food-red);

    color: #fff;

    transform: rotate(8deg);
}


.food-contact-info-content {
    position: relative;

    z-index: 2;
}


.food-contact-info-content h5 {
    margin: 0 0 4px;

    color: #222;

    font-size: 15px;

    font-weight: 700;
}


.food-contact-info-content p {
    margin: 0;

    color: #777;

    font-size: 13px;

    line-height: 1.55;
}


/* =========================================================
   FORM CARD
========================================================= */

.food-contact-form-wrapper {
    position: relative;

    padding: 45px;

    background: #fff;

    border: 1px solid #eeeeee;

    box-shadow:
        0 20px 55px rgba(0, 0, 0, .09);

    overflow: hidden;
}


.food-contact-form-wrapper::before {
    content: "";

    position: absolute;

    height: 6px;

    left: 0;
    right: 0;

    top: 0;

    background:
        linear-gradient(
            90deg,
            var(--food-red),
            var(--food-orange),
            var(--food-yellow)
        );
}


.food-contact-form-wrapper::after {
    content: "";

    position: absolute;

    width: 170px;
    height: 170px;

    border-radius: 50%;

    border: 25px solid rgba(229, 57, 53, .035);

    right: -80px;
    bottom: -80px;
}


.food-contact-form-title {
    position: relative;

    z-index: 2;

    margin-bottom: 30px;
}


.food-contact-form-title h3 {
    color: #222;

    font-size: 30px;

    font-weight: 800;

    margin-bottom: 7px;
}


.food-contact-form-title p {
    color: #777;

    font-size: 14px;

    line-height: 1.7;

    margin: 0;
}


.food-contact-form {
    position: relative;

    z-index: 2;
}


.food-contact-form .form-group {
    margin-bottom: 20px;
}


.food-contact-form label {
    display: block;

    color: #333;

    font-size: 13px;

    font-weight: 700;

    margin-bottom: 8px;
}


.food-contact-form .form-control {
    width: 100%;

    height: 54px;

    border: 1px solid #e5e5e5;

    border-radius: 5px;

    padding: 0 16px;

    color: #333;

    background: #fff;

    box-shadow: none;

    font-size: 14px;

    transition: all .3s ease;
}


.food-contact-form textarea.form-control {
    height: 140px;

    padding: 14px 16px;

    resize: none;
}


.food-contact-form .form-control::placeholder {
    color: #aaa;
}


.food-contact-form .form-control:focus {
    border-color: var(--food-red);

    box-shadow:
        0 0 0 4px rgba(229, 57, 53, .08);
}


/* =========================================================
   SEND BUTTON
========================================================= */

.food-contact-submit {
    border: 0;

    border-radius: 5px;

    background:
        linear-gradient(
            135deg,
            var(--food-red),
            var(--food-orange)
        );

    color: #fff;

    padding: 15px 29px;

    font-size: 14px;

    font-weight: 800;

    transition: all .3s ease;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    cursor: pointer;

    box-shadow:
        0 10px 22px rgba(229, 57, 53, .20);
}


.food-contact-submit:hover {
    background:
        linear-gradient(
            135deg,
            #181818,
            #333
        );

    color: #fff;

    transform: translateY(-3px);

    box-shadow:
        0 12px 25px rgba(0, 0, 0, .18);
}


.food-contact-submit i {
    transition: .3s ease;
}


.food-contact-submit:hover i {
    transform: translateX(4px);
}


/* =========================================================
   BOTTOM FEATURES
========================================================= */

.food-contact-bottom {
    margin-top: 85px;
}


.food-contact-feature {
    position: relative;

    text-align: center;

    padding: 38px 25px;

    height: 100%;

    background:
        linear-gradient(
            145deg,
            #fff8f5,
            #fff
        );

    border: 1px solid #f1dfd7;

    transition: all .3s ease;

    overflow: hidden;
}


.food-contact-feature:hover {
    transform: translateY(-7px);

    background: #fff;

    box-shadow:
        0 18px 40px rgba(0, 0, 0, .08);

    border-color:
        #f0cfc1;
}


.food-contact-feature::after {
    content: "";

    position: absolute;

    width: 110px;
    height: 110px;

    border-radius: 50%;

    background:
        rgba(229, 57, 53, .035);

    right: -40px;
    bottom: -45px;
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

    background:
        linear-gradient(
            135deg,
            var(--food-red),
            var(--food-orange)
        );

    color: #fff;

    border-radius: 50%;

    font-size: 22px;

    box-shadow:
        0 10px 25px rgba(229, 57, 53, .22);

    transition: .3s ease;
}


.food-contact-feature:hover .food-contact-feature-icon {
    transform:
        translateY(-3px)
        rotate(8deg);
}


.food-contact-feature h4 {
    position: relative;

    z-index: 2;

    color: #222;

    font-size: 18px;

    font-weight: 800;

    margin-bottom: 9px;
}


.food-contact-feature p {
    position: relative;

    z-index: 2;

    color: #777;

    font-size: 14px;

    line-height: 1.7;

    margin: 0;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 991px) {

    .food-contact-hero {
        min-height: 340px;
    }

    .food-contact-hero h1 {
        font-size: 54px;
    }

    .food-contact-hero-content::before {
        left: -80px;
    }

    .food-contact-hero-content::after {
        right: -80px;
    }

    .food-contact-section {
        padding: 75px 0;
    }

    .food-contact-heading h2 {
        font-size: 36px;
    }

    .food-contact-form-wrapper {
        margin-top: 20px;
    }
}


@media (max-width: 767px) {

    .food-contact-hero {
        min-height: 310px;
    }

    .food-contact-hero-content {
        padding: 35px 15px;
    }

    .food-contact-hero h1 {
        font-size: 42px;
    }

    .food-contact-hero p {
        font-size: 14px;
    }

    .food-contact-hero .hero-small-title {
        font-size: 11px;
        letter-spacing: 2px;
    }

    .food-contact-hero .hero-small-title::before,
    .food-contact-hero .hero-small-title::after {
        width: 25px;
    }

    .food-contact-section {
        padding: 60px 0;
    }

    .food-contact-heading h2 {
        font-size: 30px;
    }

    .food-contact-heading p {
        font-size: 14px;
    }

    .food-contact-info {
        grid-template-columns: 1fr;
    }

    .food-contact-form-wrapper {
        padding: 32px 22px;
    }

    .food-contact-form-title h3 {
        font-size: 24px;
    }

    .food-contact-bottom {
        margin-top: 55px;
    }

    .food-contact-hero-content::before,
    .food-contact-hero-content::after {
        display: none;
    }
}


@media (max-width: 480px) {

    .food-contact-hero {
        min-height: 275px;
    }

    .food-contact-hero h1 {
        font-size: 35px;
    }

    .food-contact-hero p {
        font-size: 13px;
    }

    .food-contact-hero .hero-small-title {
        font-size: 10px;
        letter-spacing: 1.3px;
    }

    .food-contact-breadcrumb {
        padding: 7px 14px;
    }

    .food-contact-breadcrumb a,
    .food-contact-breadcrumb span {
        font-size: 12px;
    }

    .food-contact-heading h2 {
        font-size: 27px;
    }

    .food-contact-form-wrapper {
        padding: 30px 18px;
    }

    .food-contact-info-card {
        padding: 17px 14px;
    }

    .food-contact-info-content p {
        font-size: 12px;
    }

    .food-contact-submit {
        width: 100%;
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

                                <h5>
                                    Call Us
                                </h5>

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

                                <h5>
                                    Email Us
                                </h5>

                                <p>
                                    info@foodwebsite.com
                                </p>

                            </div>

                        </div>



                        {{-- OPENING HOURS --}}
                        <div class="food-contact-info-card">

                            <div class="food-contact-info-icon">

                                <i class="fa fa-clock"></i>

                            </div>


                            <div class="food-contact-info-content">

                                <h5>
                                    Opening Hours
                                </h5>

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

                            <h3>
                                Send Us A Message
                            </h3>

                            <p>
                                Fill in the form below and our team will
                                get back to you shortly.
                            </p>

                        </div>



                        {{-- FRONTEND ONLY FORM --}}

                        <form
                            class="food-contact-form"
                            onsubmit="return false;"
                        >

                            <div class="row">


                                {{-- NAME --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="contactName">
                                            Your Name
                                        </label>

                                        <input
                                            type="text"
                                            id="contactName"
                                            class="form-control"
                                            placeholder="Enter your name"
                                        >

                                    </div>

                                </div>



                                {{-- EMAIL --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="contactEmail">
                                            Email Address
                                        </label>

                                        <input
                                            type="email"
                                            id="contactEmail"
                                            class="form-control"
                                            placeholder="Enter your email"
                                        >

                                    </div>

                                </div>



                                {{-- PHONE --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="contactPhone">
                                            Phone Number
                                        </label>

                                        <input
                                            type="text"
                                            id="contactPhone"
                                            class="form-control"
                                            placeholder="Enter your phone number"
                                        >

                                    </div>

                                </div>



                                {{-- SUBJECT --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="contactSubject">
                                            Subject
                                        </label>

                                        <input
                                            type="text"
                                            id="contactSubject"
                                            class="form-control"
                                            placeholder="Enter subject"
                                        >

                                    </div>

                                </div>



                                {{-- MESSAGE --}}
                                <div class="col-12">

                                    <div class="form-group">

                                        <label for="contactMessage">
                                            Your Message
                                        </label>

                                        <textarea
                                            id="contactMessage"
                                            class="form-control"
                                            placeholder="Write your message here..."
                                        ></textarea>

                                    </div>

                                </div>



                                {{-- BUTTON --}}
                                <div class="col-12">

                                    <button
                                        type="button"
                                        class="food-contact-submit"
                                    >

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


                        <h4>
                            Made With Love
                        </h4>


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