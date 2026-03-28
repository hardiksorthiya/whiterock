<aside class="sidebar" id="sidebar" aria-label="Main navigation">

    <div class="logo text-center py-3 border-bottom border-secondary border-opacity-25 position-relative">
        <x-sorath-logo size="40px" />
        <button type="button" class="btn btn-link text-white-50 p-0 position-absolute top-0 end-0 mt-2 me-2 d-lg-none"
            onclick="document.getElementById('sidebarToggle').click()" aria-label="Close menu">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>

    <nav class="sidebar-nav menu py-2">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span class="nav-label">Dashboard</span>
        </a>

        <!-- Products Dropdown -->
        <a href="#productMenu" data-bs-toggle="collapse" class="d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-box"></i>
                <span class="nav-label">Products</span>
            </div>
            <i class="bi bi-chevron-down small"></i>
        </a>

        <div class="collapse {{ request()->routeIs('products.*') ? 'show' : '' }}" id="productMenu">

            <a href="{{ route('backend.product-categories.index') }}" class="ps-5">
                <span class="nav-label">Categories</span>
            </a>

            <a href="{{ route('backend.products.index') }}" class="ps-5">
                <span class="nav-label">Products</span>
            </a>

        </div>

        {{-- users --}}
       @can('user-list')
           <a href="{{ route('backend.users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                <span class="nav-label">Users</span>
            </a>
       @endcan
            
      

       


        {{-- roles --}}
        @can('role-list')
            <a href="{{ route('backend.roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="bi bi-shield"></i>
                <span class="nav-label">Roles</span>
            </a>
        @endcan

        {{-- sliders --}}
        
            <a href="{{ route('backend.sliders.index') }}" class="{{ request()->routeIs('backend.sliders.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i>
                <span class="nav-label">Sliders</span>
            </a>

        <a href="{{ route('backend.settings.edit') }}" class="{{ request()->routeIs('backend.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i>
            <span class="nav-label">Settings</span>
        </a>

    </nav>
</aside>
