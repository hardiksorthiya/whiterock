<section class="sorath-section py-5">
    <div class="container">
        <div class="row align-items-center position-relative">

            <!-- Left Content -->
            <div class="col-lg-6 col-md-6">
                <div class="sorath-image-wrapper">
                    @if (! empty($about->about_image))
                        <img src="{{ asset('storage/' . $about->about_image) }}" class="img-fluid" alt="About image">
                    @else
                        <img src="{{ asset('images/h1.jpeg') }}" class="img-fluid" alt="Interior">
                    @endif
                </div>
            </div>
           
            <!-- Right Founder Image -->
             <div class="col-lg-6 col-md-6">
                <div class="sorath-content-box shadow">
                    <img src="{{ asset('images/logo_white.png') }}" class="img-fluid mb-3 about-logo-hp" alt="About image">
                    <h2 class="sorath-title">
                        Built for Stronger Ceilings.<br>Designed for Modern Spaces.
                    </h2>
                    <div class="sorath-desc">
                        {!! $about->description ?? 'About content coming soon.' !!}
                    </div>
                    
                </div>
            </div>


        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h3 class="sorath-title mb-2">About NIVOC</h3>
                    <p class="sorath-desc mb-0">Watch our journey and product story.</p>
                </div>
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                    <video controls autoplay muted loop playsinline preload="metadata">
                        <source src="{{ asset('images/about.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
</section>
