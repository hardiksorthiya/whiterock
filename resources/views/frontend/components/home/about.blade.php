@php
    $aboutCarouselImages = [
        asset('images/home/n1.jpg'),
        asset('images/home/n2.jpg'),
        asset('images/home/n3.png'),
        asset('images/home/n4.jpg'),
    ];
    // Replace this YouTube video ID any time.
    $aboutReelVideoId = 'p9znelcArPM';
    $aboutReelEmbedUrl = 'https://www.youtube.com/embed/' . $aboutReelVideoId
        . '?autoplay=1&mute=1&loop=1&playlist=' . $aboutReelVideoId
        . '&controls=0&modestbranding=1&rel=0&playsinline=1';
@endphp

<section class="sorath-section home-about-redesign py-5">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-6">
                <div class="home-about-redesign__content">
                    <p class="sorath-small-title">WELCOME TO NIVOC</p>
                    <h3 class="sorath-title mb-3">
                        Complete Ceiling & Panel Solutions, Engineered For Modern Spaces
                    </h3>
                    <p class="sorath-desc text-start">
                        NIVOC is a trusted B2B ceiling & wall panel brand in India offering high-performance ceiling systems and interior panel solutions for commercial, residential, and large-scale interior projects. From gypsum tiles and precision T-grid systems to soffit and fluted panels, our products are built for durability and seamless installation. 
                    </p>
                    <p class="sorath-desc text-start mb-4">Backed by the strong legacy of WhiteRock, NIVOC provides reliable solutions for dealers, contractors, architects, and large-scale projects.</p>
                    <a href="{{ route('about') }}" class="btn btn-dark">Read More</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row g-3 align-items-stretch">
                    <div class="col-md-8">
                        <div id="homeAboutCarousel" class="carousel slide home-about-redesign__carousel h-100"
                            data-bs-ride="carousel"
                            data-bs-interval="2600">
                            <div class="carousel-inner h-100">
                                @foreach ($aboutCarouselImages as $img)
                                    <div class="carousel-item h-100 @if ($loop->first) active @endif">
                                        <img src="{{ $img }}" class="d-block w-100 h-100" alt="About NIVOC">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#homeAboutCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#homeAboutCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="home-about-redesign__reel d-flex flex-column justify-content-end">
                            <iframe
                                class="home-about-redesign__reel-iframe"
                                src="{{ $aboutReelEmbedUrl }}"
                                title="NIVOC Reel"
                                loading="lazy"
                                allow="autoplay; encrypted-media; picture-in-picture"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen>
                            </iframe>
                            <span class="home-about-redesign__reel-label">Live Reel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
