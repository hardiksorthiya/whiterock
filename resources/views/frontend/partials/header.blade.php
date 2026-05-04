
<nav class="navbar navbar-expand-lg fixed-top site-header">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand" href="/">
            @php
                $hasMainLogo = !empty($setting->logo_path);
                $hasLightLogo = !empty($setting->light_logo_path);
            @endphp
            @if ($hasMainLogo && $hasLightLogo)
                <img src="{{ asset('storage/'.$setting->light_logo_path) }}" alt="Whiterock" class="logo logo--header-light">
                <img src="{{ asset('storage/'.$setting->logo_path) }}" alt="" class="logo logo--header-dark" aria-hidden="true">
            @elseif ($hasMainLogo)
                <img src="{{ asset('storage/'.$setting->logo_path) }}" alt="Whiterock" class="logo">
            @elseif ($hasLightLogo)
                <img src="{{ asset('storage/'.$setting->light_logo_path) }}" alt="Whiterock" class="logo">
            @endif
        </a>

        <!-- Toggle Button -->
        <button class="navbar-toggler border-0 d-lg-none" type="button" id="menuToggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
            <span class="hamburger"></span>
        </button>

        <!-- Desktop Menu -->
        <div class="collapse navbar-collapse justify-content-end d-none d-lg-flex">
            <ul class="navbar-nav gap-4">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Products</a></li>
                <li class="nav-item site-header__categories">
                    <button type="button" class="nav-link site-header__cat-trigger" id="headerCategories" aria-haspopup="menu" aria-expanded="false">
                        Categories
                        <i class="bi bi-chevron-down site-header__cat-chevron" aria-hidden="true"></i>
                    </button>
                    <div class="site-header__cat-panel" role="menu" aria-labelledby="headerCategories">
                        <div class="site-header__cat-panel-inner">
                            <ul class="site-header__cat-list list-unstyled mb-0">
                                <li>
                                    <a class="site-header__cat-card" href="{{ route('gypsum-tiles') }}" role="menuitem">
                                        <span class="site-header__cat-card-title">Gypsum tiles</span>
                                        <span class="site-header__cat-card-desc">Ceiling tiles for commercial &amp; residential spaces</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="site-header__cat-card" href="{{ route('ceiling-t-grid') }}" role="menuitem">
                                        <span class="site-header__cat-card-title">Ceiling T-grid</span>
                                        <span class="site-header__cat-card-desc">Suspended ceiling grid systems</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="site-header__cat-card" href="{{ route('soffit-panels') }}" role="menuitem">
                                        <span class="site-header__cat-card-title">Soffit panels</span>
                                        <span class="site-header__cat-card-desc">Soffits, canopies &amp; exterior details</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="site-header__cat-card" href="{{ route('fluted-panels') }}" role="menuitem">
                                        <span class="site-header__cat-card-title">Fluted panels</span>
                                        <span class="site-header__cat-card-desc">Architectural linear wall &amp; feature surfaces</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('catalogue') }}">Catalogue</a></li>
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
        <li><a href="{{ route('products') }}">Products</a></li>
        <li>
            <details class="mobile-menu__expand">
                <summary>Categories</summary>
                <ul class="list-unstyled mobile-menu__sub">
                    <li><a href="{{ route('gypsum-tiles') }}">Gypsum tiles</a></li>
                    <li><a href="{{ route('ceiling-t-grid') }}">Ceiling T-grid</a></li>
                    <li><a href="{{ route('soffit-panels') }}">Soffit panels</a></li>
                    <li><a href="{{ route('fluted-panels') }}">Fluted panels</a></li>
                </ul>
            </details>
        </li>
        <li><a href="{{ route('catalogue') }}">Catalogue</a></li>
        <li><a href="{{ route('gallery') }}">Gallery</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
    </ul>
</div>

<!-- OVERLAY -->
<div class="menu-overlay" id="menuOverlay"></div>

