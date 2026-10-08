<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Food Website')</title>

    <meta name="description" content="@yield('meta_description', 'Order delicious food online.')">
    <meta name="keywords" content="@yield('meta_keywords', 'food, restaurant, online food order')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo/favicon.svg') }}">

    {{-- Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    {{-- Page-specific CSS --}}
    @stack('styles')

    @yield('meta')
</head>

<body>

    {{-- Website Header --}}
    {{-- @include('partials.site-header') --}}

    @php
        $headerCartCount = auth()->check()
            ? \App\Models\Cart::where('user_id', auth()->id())->sum('quantity')
            : collect(session('food_cart', []))->sum('quantity');
    @endphp

    @include('partials.site-header', [
        'headerCartCount' => $headerCartCount,
    ])
    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Website Footer --}}
    @include('partials.site-footer')

    {{-- Theme JavaScript --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/countdowncustom.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/animation.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    {{-- Page-specific JavaScript --}}
    @stack('scripts')

    @include('auth.login')
    @include('auth.register')

    {{-- Modal Cleanup + Global Cart Count --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =========================================================
               GLOBAL HEADER CART COUNT
               ========================================================= */

            function updateHeaderCartCount(count) {

                count = parseInt(count || 0, 10);

                document.querySelectorAll('.header-cart-count').forEach(function(element) {

                    if (count > 0) {
                        element.textContent = count;
                        element.style.display = 'inline-flex';
                    } else {
                        element.textContent = '';
                        element.style.display = 'none';
                    }

                });
            }

            /*
             * Laravel Session / Database se initial cart count
             */
            updateHeaderCartCount(
                @json(auth()->check()
                        ? \App\Models\Cart::where('user_id', auth()->id())->sum('quantity')
                        : collect(session('food_cart', []))->sum('quantity'))
            );

            /*
             * Add To Cart / Cart JS ke liye globally available
             */
            window.updateHeaderCartCount = updateHeaderCartCount;


            /* =========================================================
               MODAL CLEANUP
               ========================================================= */

            document.querySelectorAll('.modal').forEach(function(modalElement) {

                modalElement.addEventListener('hidden.bs.modal', function() {

                    document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                        backdrop.remove();
                    });

                    document.body.classList.remove('modal-open');

                    document.body.style.removeProperty('padding-right');
                    document.body.style.removeProperty('overflow');

                });

            });

        });
    </script>
</body>

</html>
