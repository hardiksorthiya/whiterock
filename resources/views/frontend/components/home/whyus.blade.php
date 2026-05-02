@php
    $whyBlocks = [
        [
            'title' => 'Consistent product quality',
            'items' => [
                'Uniform finish across every batch',
                'High-strength materials for long-term durability',
                'Strict quality checks at every stage',
            ],
        ],
        [
            'title' => 'Efficient installation systems',
            'items' => [
                'Designed for fast and precise installation',
                'Reduces on-site errors and delays',
                'Compatible with standard frameworks',
            ],
        ],
        [
            'title' => 'Reliable supply & availability',
            'items' => [
                'Strong dealer network across regions',
                'Timely delivery for ongoing projects',
                'Scalable supply for bulk requirements',
            ],
        ],
        [
            'title' => 'Low maintenance performance',
            'items' => [
                'Moisture-resistant and termite-proof materials',
                'Long-lasting surface finish',
                'Minimal upkeep over time',
            ],
        ],
    ];
@endphp

<section class="why-modern why-pro py-5">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-6">
                <div class="why-pro__visual">
                    <div class="why-pro__accent" aria-hidden="true"></div>
                    <figure class="why-pro__figure why-pro__figure--primary">
                        <img src="{{ asset('images/home/f2.jpg') }}"
                            alt="Gypsum ceiling tiles in a finished interior"
                            class="why-pro__img" width="640" height="480" loading="lazy">
                    </figure>
                    <figure class="why-pro__figure why-pro__figure--secondary">
                        <img src="{{ asset('images/home/n3.jpg') }}"
                            alt="T-grid suspension ceiling system detail"
                            class="why-pro__img" width="480" height="360" loading="lazy">
                    </figure>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="sorath-section-header text-center text-lg-start mb-4">
                    <p class="sorath-small-title mb-2">Built for professionals</p>
                    <h2 class="sorath-title">Why Professionals Choose NIVOC</h2>
                    <p class="sorath-desc mb-0">
                        Performance-led ceiling and panel systems—consistent quality, faster installs, and supply you can plan around.
                    </p>
                </div>

                <div class="row g-3">
                    @foreach ($whyBlocks as $block)
                        <div class="col-md-6">
                            <article class="why-pro-card h-100">
                                <h3 class="why-pro-card__title">{{ $block['title'] }}</h3>
                                <ul class="why-pro-card__list">
                                    @foreach ($block['items'] as $line)
                                        <li>{{ $line }}</li>
                                    @endforeach
                                </ul>
                            </article>
                        </div>
                    @endforeach
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                    <a href="{{ route('products') }}" class="btn btn-lg why-pro__cta">
                        View catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
