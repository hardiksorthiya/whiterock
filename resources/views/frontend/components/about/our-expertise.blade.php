@php
    $expertiseCards = [
        [
            'image' => asset('images/n1.jpeg'),
            'title' => 'Ceiling System Expertise',
            'description' => 'From gypsum boards to advanced suspension grids, we design practical ceiling solutions built for durability, precision, and clean finishes.',
            'button' => 'Explore ceiling systems',
            'url' => route('products'),
        ],
        [
            'image' => asset('images/n2.jpeg'),
            'title' => 'Facade & Panel Expertise',
            'description' => 'Our team delivers modern panel and facade applications that balance aesthetics, weather resistance, and long-term performance.',
            'button' => 'Discover panel solutions',
            'url' => route('products'),
        ],
    ];
@endphp

<section class="about-expertise py-5">
    <div class="container">
        <div class="text-center mb-4">
            <p class="sorath-small-title mb-2 text-uppercase small">Our Expertise</p>
            <h2 class="sorath-title mb-2">Built Through Materials, Methods & Experience</h2>
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
