<footer class="site-footer">
    <div class="site-footer__top text-center">
        <p class="site-footer__brand mb-3">
            <a href="/" class="site-footer__brand-link">
                @if (!empty($setting->logo_path))
                    <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Whiterock">
                @elseif (!empty($setting->light_logo_path))
                    <img src="{{ asset('storage/' . $setting->light_logo_path) }}" alt="Whiterock">
                @else
                    <span class="h3 m-0 d-inline-block site-footer__brand-text">Whiterock</span>
                @endif
            </a>
        </p>
        <p class="site-footer__lead mx-auto">
            {!! $setting->footer_text ?: 'Quality interiors and trusted service for every project.' !!}
        </p>
        <div class="site-footer__social d-flex justify-content-center gap-2">
            @if (!empty($setting->facebook_url))
                <a href="{{ $setting->facebook_url }}" target="_blank" rel="noopener"
                    class="site-footer__social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            @endif
            @if (!empty($setting->twitter_url))
                <a href="{{ $setting->twitter_url }}" target="_blank" rel="noopener"
                    class="site-footer__social-btn" aria-label="Twitter / X"><i class="bi bi-twitter-x"></i></a>
            @endif
            @if (!empty($setting->instagram_url))
                <a href="{{ $setting->instagram_url }}" target="_blank" rel="noopener"
                    class="site-footer__social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            @endif
            @if (!empty($setting->whatsapp_url))
                <a href="{{ $setting->whatsapp_url }}" target="_blank" rel="noopener"
                    class="site-footer__social-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            @endif
        </div>
    </div>

    <div class="container site-footer__middle">
        <div class="row g-4 g-lg-5">
            <div class="col-md-3">
                <h3 class="site-footer__heading">Information</h3>
                <ul class="site-footer__links list-unstyled mb-0">
                    <li><a href="{{ route('gypsum-tiles') }}">Gypsum Ceiling Tiles</a></li>
                    <li><a href="{{ route('ceiling-t-grid') }}">Ceiling T-Grid</a></li>
                    <li><a href="{{ route('soffit-panels') }}">Soffit panels</a></li>
                    <li><a href="{{ route('fluted-panels') }}">Fluted panels</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3 class="site-footer__heading">Categories</h3>
                <ul class="site-footer__links list-unstyled mb-0">
                    @forelse (($footerProductCategories ?? collect()) as $footerCategory)
                        <li>
                            <a href="{{ route('product-category.show', $footerCategory->slug) }}">
                                {{ $footerCategory->name }}
                            </a>
                        </li>
                    @empty
                        <li><span class="text-muted">No categories yet</span></li>
                    @endforelse
                </ul>
            </div>
            <div class="col-md-3">
                <h3 class="site-footer__heading">Quick links</h3>
                <ul class="site-footer__links list-unstyled mb-0">
                    <li><a href="{{ route('faq') }}">FAQ</a></li>

                    @forelse (($footerPages ?? collect()) as $footerPage)
                        <li>
                            <a href="{{ route('pages.show', $footerPage->slug) }}">
                                {{ $footerPage->title }}
                            </a>
                        </li>
                    @empty
                        <li><span class="text-muted">No pages yet</span></li>
                    @endforelse
                </ul>
            </div>
            <div class="col-md-3">
                <h3 class="site-footer__heading">Catalogue</h3>
                <a href="{{ route('catalogue') }}" class="btn btn-lg site-footer__cta">
                   <img src="{{ asset('images/a3.png') }}" alt="Catalogue" width="100" height="100">
                </a>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-md-between align-items-center gap-2 text-center text-md-start">
            <div class="site-footer__meta mb-0">{!! $setting->footer_copyright_text ?: 'Copyright &copy; '.date('Y').'. All rights reserved.' !!}</div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/lenis.min.js') }}" defer></script>
<script src="{{ asset('js/frontend/script.js') }}" defer></script>
