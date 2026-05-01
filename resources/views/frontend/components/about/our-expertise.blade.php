@php
    $expertiseCards = [
        [
            'image' => asset('images/about/c1.jpeg'),
            'title' => 'Ceiling Material Solutions',
            'description' => 'From T-grid systems to gypsum tiles, we offer reliable ceiling materials designed for durability, precision, and efficient installation across projects of every scale.',
            'button' => 'Explore Ceiling Materials',
            'url' => route('products'),
        ],
        [
            'image' => asset('images/about/d1.jpeg'),
            'title' => 'Decorative Panel Solutions',
            'description' => 'Our range of fluted and soffit panels combines modern aesthetics with long-lasting performance—ideal for enhancing both interior and exterior spaces.',
            'button' => 'Explore Panel Solutions',
            'url' => route('products'),
        ],
    ];
@endphp

<section class="about-expertise py-5">
    <div class="container">
        <div class="text-center mb-4">
            <p class="sorath-small-title mb-2 text-uppercase small">Our Expertise</p>
            <h2 class="sorath-title mb-2">Built for Performance. Designed for Scale.</h2>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($expertiseCards as $card)
                <div class="col-lg-6 col-md-10">
                    <article class="about-expertise__card h-100">
                        <div class="about-expertise__image-wrap">
                            <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="about-expertise__image">
                        </div>
                        <div class="about-expertise__body">
                            <h3 class="about-expertise__title">{{ $card['title'] }}</h3>
                            <p class="about-expertise__desc">{{ $card['description'] }}</p>
                            <a href="{{ $card['url'] }}" class="btn btn-dark btn-sm about-expertise__btn">
                                {{ $card['button'] }}
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
