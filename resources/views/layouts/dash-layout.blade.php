<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Little Pause Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lora:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">

    @yield('styles')
</head>
<body>

    @include('partials.dash-sidebar')
    @include('partials.dash-header')

    <main class="ok-main">
        @yield('content')
    </main>

    @include('partials.dash-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('okSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() { sidebar.classList.add('show'); overlay.classList.add('show'); }
        function closeSidebar() { sidebar.classList.remove('show'); overlay.classList.remove('show'); }

        document.getElementById('sidebarToggle')?.addEventListener('click', openSidebar);
        document.getElementById('sidebarClose')?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        sidebar?.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => { if (window.innerWidth <= 991) closeSidebar(); });
        });
    </script>
    @yield('scripts')
</body>
</html>
