{{-- resources/views/partials/dash-header.blade.php --}}
<header class="ok-topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn sidebar-toggle-btn" id="sidebarToggle">
            <i class="bi bi-list fs-4" style="color: var(--lp-green);"></i>
        </button>
        <div class="search-box d-none d-md-flex">
            <i class="bi bi-search text-muted"></i>
            <input type="text" placeholder="Search orders, products, customers...">
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button class="icon-btn"><i class="bi bi-bell-fill"></i><span class="badge-dot"></span></button>
        <button class="icon-btn"><i class="bi bi-envelope-fill"></i></button>

        <div class="dropdown">
            <div class="profile-chip" data-bs-toggle="dropdown">
                <img src="https://placehold.co/72x72/1F3D2E/ffffff?text=A" alt="admin">
                <div class="d-none d-md-block text-start">
                    <div class="fw-semibold" style="font-size:.85rem;">Admin User</div>
                    <div class="text-muted" style="font-size:.72rem;">Super Admin</div>
                </div>
                <i class="bi bi-chevron-down text-muted"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end mt-2">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                {{-- <li>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</header>
{{-- <form id="logout-form" action="{{ route('logout') ?? '#' }}" method="POST" class="d-none">@csrf</form> --}}
