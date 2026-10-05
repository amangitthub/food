<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo/favicon.svg') }}">

    <title>
        @yield('title', 'Dashboard') | FOODKING Admin
    </title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lora:ital,wght@0,400;0,500;0,600;1,400&display=swap"
        rel="stylesheet">
    {{-- Admin Theme --}}
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">
    {{-- Page Specific CSS --}}
    @yield('styles')

</head>


<body>
    {{-- Sidebar --}}
    @include('partials.dash-sidebar')

    {{-- Header --}}
    @include('partials.dash-header')

    {{-- Main Content --}}
    <main class="ok-main">

        @yield('content')

    </main>

    {{-- Footer --}}
    @include('partials.dash-footer')

    {{-- =========================== JQUERY==================== --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- =======================BOOTSTRAP JS===================== --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ======================= SIDEBAR SCRIPT==================== --}}
    <script>
        const sidebar =
            document.getElementById('okSidebar');

        const overlay =
            document.getElementById('sidebarOverlay');


        function openSidebar() {
            sidebar ? .classList.add('show');

            overlay ? .classList.add('show');
        }


        function closeSidebar() {
            sidebar ? .classList.remove('show');

            overlay ? .classList.remove('show');
        }


        document
            .getElementById('sidebarToggle') ?
            .addEventListener(
                'click', openSidebar
            );


        document
            .getElementById('sidebarClose') ?
            .addEventListener(
                'click', closeSidebar
            );


        overlay ? .addEventListener(
            'click', closeSidebar
        );


        sidebar
            ?
            .querySelectorAll('.nav-link')
            .forEach(function(link) {

                link.addEventListener(
                    'click',
                    function() {

                        if (window.innerWidth <= 991) {
                            closeSidebar();
                        }

                    }
                );

            });
    </script>
    @yield('scripts')
</body>

</html>
