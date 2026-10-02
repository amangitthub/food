<!-- Footer Section Start -->
<footer class="footer-section fix section-bg">

    <div class="burger-shape">
        <img src="{{ asset('assets/img/shape/burger-shape-3.png') }}" alt="burger-shape">
    </div>

    <div class="fry-shape">
        <img src="{{ asset('assets/img/shape/fry-shape-2.png') }}" alt="fry-shape">
    </div>

    <div class="container">
        <div class="footer-widgets-wrapper">

            <div class="row">

                {{-- ==============================
                    COMPANY INFO
                =============================== --}}
                <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".2s">

                    <div class="single-footer-widget">

                        <div class="widget-head">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/logo/logo.svg') }}" alt="Food Website Logo">
                            </a>
                        </div>

                        <div class="footer-content">

                            <p>
                                Fresh food, delicious taste and <br>
                                quality you can trust.
                            </p>

                            <span>
                                Interested in working with us?
                            </span>

                            <br>

                            <a href="mailto:info@foodwebsite.in" class="link">
                                info@foodwebsite.in
                            </a>

                            <div class="social-icon d-flex align-items-center">

                                <a href="#" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>

                                <a href="#" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>

                                <a href="#" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>

                                <a href="#" aria-label="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>

                            </div>

                        </div>
                    </div>

                </div>


                {{-- ==============================
                    QUICK LINKS
                =============================== --}}
                <div class="col-xl-2 ps-lg-5 col-sm-6 col-md-3 col-lg-3 wow fadeInUp" data-wow-delay=".4s">

                    <div class="single-footer-widget">

                        <div class="widget-head">
                            <h4>Quick Links</h4>
                        </div>

                        <ul class="list-items">

                            <li>
                                <a href="{{ url('/about') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">About Us</span>
                                        <span class="effect-1">About Us</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/products') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">Our Menu</span>
                                        <span class="effect-1">Our Menu</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/blog') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">Latest News</span>
                                        <span class="effect-1">Latest News</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/contact') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">Contact Us</span>
                                        <span class="effect-1">Contact Us</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/faq') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">FAQ's</span>
                                        <span class="effect-1">FAQ's</span>
                                    </span>
                                </a>
                            </li>

                        </ul>

                    </div>
                </div>


                {{-- ==============================
                    MY ACCOUNT
                =============================== --}}
                <div class="col-xl-2 ps-lg-4 col-sm-6 col-md-3 col-lg-3 wow fadeInUp" data-wow-delay=".6s">

                    <div class="single-footer-widget">

                        <div class="widget-head">
                            <h4>My Account</h4>
                        </div>

                        <ul class="list-items">

                            <li>
                                <a href="{{ url('/profile') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">My Profile</span>
                                        <span class="effect-1">My Profile</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/orders') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">My Orders</span>
                                        <span class="effect-1">My Orders</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/wishlist') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">My Wishlist</span>
                                        <span class="effect-1">My Wishlist</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/order-tracking') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">Order Tracking</span>
                                        <span class="effect-1">Order Tracking</span>
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/cart') }}">
                                    <span class="text-effect">
                                        <span class="effect-1">Shopping Cart</span>
                                        <span class="effect-1">Shopping Cart</span>
                                    </span>
                                </a>
                            </li>

                        </ul>

                    </div>
                </div>


                {{-- ==============================
                    ADDRESS
                =============================== --}}
                <div class="col-xl-2 col-sm-6 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".8s">

                    <div class="single-footer-widget">

                        <div class="widget-head">
                            <h4>Address:</h4>
                        </div>

                        <div class="footer-address-text">

                            <h6>
                                Dehradun, Uttarakhand
                                <span>248001</span>
                                India
                            </h6>

                            <h5>Hours:</h5>

                            <h6>
                                10:00 AM – 10:00 PM <br>
                                Monday to Sunday
                            </h6>

                        </div>

                    </div>
                </div>


                {{-- ==============================
                    APP / SUPPORT
                =============================== --}}
                <div class="col-xl-3 ps-xl-5 col-sm-6 col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".9s">

                    <div class="single-footer-widget">

                        <div class="widget-head">
                            <h4>Download Our App</h4>
                        </div>

                        <div class="footer-apps-items">

                            <h5>
                                Available on App Store & Google Play
                            </h5>

                            <div class="apps-image d-flex align-items-center">

                                <a href="#">
                                    <img src="{{ asset('assets/img/app-store.png') }}" alt="Download on App Store">
                                </a>

                                <a href="#">
                                    <img src="{{ asset('assets/img/google-play.png') }}" alt="Get it on Google Play">
                                </a>

                            </div>


                            <div class="support-text">

                                <h5>
                                    Customer Support
                                </h5>

                                <h3>
                                    <a href="tel:+919876543210">
                                        +91 98765 43210
                                    </a>
                                </h3>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>


    {{-- ==============================
        FOOTER BOTTOM
    =============================== --}}
    <div class="footer-bottom">

        <div class="container">

            <div class="footer-bottom-wrapper d-flex align-items-center justify-content-between">

                <p class="wow fadeInLeft" data-wow-delay=".3s">

                    © Copyright
                    <span class="theme-color-3">
                        {{ date('Y') }}
                    </span>

                    <a href="{{ url('/') }}">
                        Food Website
                    </a>.

                    All Rights Reserved.

                </p>


                <div class="card-image wow fadeInRight" data-wow-delay=".5s">

                    <img src="{{ asset('assets/img/card.png') }}" alt="Payment Methods">

                </div>

            </div>

        </div>

    </div>

</footer>


<!-- Back To Top Start -->
<div class="scroll-up">

    <svg class="scroll-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">

        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />

    </svg>

</div>
<!-- Back To Top End -->
