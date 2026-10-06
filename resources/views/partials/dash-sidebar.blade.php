{{-- resources/views/partials/dash-sidebar.blade.php --}}

<aside class="ok-sidebar" id="okSidebar">

    <div class="brand">

        <img
            src="{{ asset('assets/img/logo/logoo.png') }}"
            alt="Food Website Logo"
        >

        {{-- <div>
            <span>FOODKING</span>
            <small>a moment worth pausing for</small>
        </div> --}}

        <button
            class="sidebar-close-btn"
            id="sidebarClose"
            aria-label="Close sidebar"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>


    <div class="nav-section-title">Overview</div>

    <nav class="nav flex-column">

        <a
            href="{{ route('dashboard') }}"
            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>


        <a
            href="{{ route('orders.index') }}"
            class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
        >
            <i class="bi bi-bag-check-fill"></i>
            Orders
        </a>


        <a
            href="{{ route('products.index') }}"
            class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
        >
            <i class="bi bi-cup-hot-fill"></i>
            Products
        </a>


        <a
            href="{{ route('categories.index') }}"
            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
        >
            <i class="bi bi-tags-fill"></i>
            Categories
        </a>


        <a
            href="{{ route('customers.index') }}"
            class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
        >
            <i class="bi bi-people-fill"></i>
            Customers
        </a>

    </nav>


    <div class="nav-section-title">System</div>

    <nav class="nav flex-column mb-3">

        <a
            href="{{ route('settings.index') }}"
            class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
        >
            <i class="bi bi-gear-fill"></i>
            Settings
        </a>


        {{-- Logout --}}
        <a
            href="#"
            class="nav-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>

    </nav>

</aside>


{{-- ================== Logout Form ================== --}}

<form
    id="logout-form"
    action="{{ route('logout') }}"
    method="POST"
    style="display: none;"
>
    @csrf
</form>


{{-- Dark overlay for mobile, tap outside to close sidebar --}}
<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>