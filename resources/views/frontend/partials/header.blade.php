
<nav class="navbar navbar-expand-lg fixed-top site-header">
    <div class="container">

        <!-- Toggle Button -->
        <button class="navbar-toggler border-0 d-lg-none" type="button" id="menuToggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
            <span class="hamburger"></span>
        </button>

        <!-- Logo -->
        <a class="navbar-brand" href="/">
        <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Whiterock" class="logo">
        </a>

        <!-- Desktop Menu -->
        <div class="collapse navbar-collapse justify-content-end d-none d-lg-flex">
            <ul class="navbar-nav gap-4">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>

    </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
    <ul class="list-unstyled">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('gallery') }}">Gallery</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
    </ul>
</div>

<!-- OVERLAY -->
<div class="menu-overlay" id="menuOverlay"></div>

