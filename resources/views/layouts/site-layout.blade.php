<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

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
    @include('partials.site-header')

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
    {{-- Modal Cleanup --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

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
