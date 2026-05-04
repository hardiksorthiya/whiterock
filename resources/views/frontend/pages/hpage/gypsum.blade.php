@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'GYPSUM TILES',
        'image' => asset('images/cbre.jpeg'),
    ])

    <section class="gypsum-page-hero py-5 py-lg-5">
        <div class="container">
            <div class="gypsum-page-hero__inner mx-auto text-center">
                <p class="gypsum-page-hero__eyebrow mb-2">Gypsum ceiling systems</p>
                <h1 class="gypsum-page-hero__title mb-3 mb-lg-4">
                    High-performance gypsum ceiling tiles for commercial &amp; residential spaces
                </h1>
                <p class="gypsum-page-hero__lead mb-0 mx-auto">
                    NIVOC Gypsum Ceiling Tiles are built for modular false ceilings — clean sightlines, straightforward
                    maintenance, and reliable performance for offices, retail, hospitality, and homes.
                </p>
            </div>
        </div>
    </section>

    @php
        $gypsumBenefits = [
            ['icon' => 'bi-clock-history', 'label' => 'On-time supply'],
            ['icon' => 'bi-layers-half', 'label' => 'No variation in batches'],
            ['icon' => 'bi-sparkles', 'label' => 'Smooth finish for a premium ceiling'],
            ['icon' => 'bi-tools', 'label' => 'Zero installation hassle'],
            ['icon' => 'bi-shield-fill-check', 'label' => 'Long-lasting durability'],
        ];

        $gypsumWhyPoints = [
            ['icon' => 'bi-box-seam-fill', 'label' => 'High-quality gypsum core'],
            ['icon' => 'bi-stars', 'label' => 'Perfect finish, zero complaints'],
            ['icon' => 'bi-grid-3x3-gap', 'label' => 'Compatible with all T-grids'],
            ['icon' => 'bi-soundwave', 'label' => 'Excellent sound absorption'],
            ['icon' => 'bi-shield-fill-check', 'label' => 'Fire-resistant performance'],
            ['icon' => 'bi-columns-gap', 'label' => 'No sagging or bending'],
        ];
    @endphp

   

    @include('frontend.components.home.product-grid', [
        'sectionTitle' => 'Gypsum ceiling tiles',
        'sectionDescription' => '',
        'products' => $gypsumPageProducts,
        'viewAllUrl' => null,
        'sectionId' => 'gypsum-page-products',
        'headerSplit' => true,
    ])
    <section class="gypsum-page-cta-bar py-4 py-lg-5">
        <div class="container text-center">
            <a href="{{ $gypsumPageCategoryUrl }}" class="btn gypsum-page__view-all px-4 px-lg-5 py-3 text-decoration-none">
                View all gypsum products
            </a>
        </div>
    </section>

    <section class="gypsum-benefits py-5 py-lg-5" aria-labelledby="gypsum-benefits-heading">
        <div class="container">
            <h2 id="gypsum-benefits-heading" class="gypsum-benefits__title sorath-title text-center mx-auto mb-4 mb-lg-5">
                Clean Ceilings. Smart Spaces. Efficient Solutions.
            </h2>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4 gypsum-benefits__row justify-content-center">
                @foreach ($gypsumBenefits as $item)
                    <div class="col">
                        <div class="gypsum-benefits__item text-center h-100">
                            <div class="gypsum-benefits__icon-wrap mx-auto mb-3" aria-hidden="true">
                                <i class="bi {{ $item['icon'] }} gypsum-benefits__icon"></i>
                            </div>
                            <p class="gypsum-benefits__text mb-0">{{ $item['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="gypsum-why py-5 py-lg-5" aria-labelledby="gypsum-why-heading">
        <div class="container">
            <header class="gypsum-why__header text-center mx-auto mb-4 mb-lg-5">
                <p class="gypsum-why__badge mb-3">Built for professionals</p>
                <h2 id="gypsum-why-heading" class="gypsum-why__title sorath-title mb-3">
                    Why Choose NIVOC Gypsum Tiles?
                </h2>
                <p class="gypsum-why__lead mb-0 mx-auto">
                    Performance-led ceiling and panel systems—consistent quality, faster installs, and supply you can plan around.
                </p>
            </header>

            <div class="row row-cols-2 row-cols-md-3 g-4 gypsum-why__points justify-content-center">
                @foreach ($gypsumWhyPoints as $point)
                    <div class="col">
                        <article class="gypsum-why__card gypsum-why__card--point h-100">
                            <div class="gypsum-why__card-icon mx-auto mb-3" aria-hidden="true">
                                <i class="bi {{ $point['icon'] }}"></i>
                            </div>
                            <p class="gypsum-why__point-label mb-0">{{ $point['label'] }}</p>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4 mt-lg-5 pt-lg-2">
                <a href="{{ route('catalogue') }}" class="btn gypsum-why__cta px-4 px-xl-5 py-3 text-decoration-none">
                    View catalogue
                </a>
            </div>
        </div>
    </section>

    @if (!empty($gypsumGallerySliderCategory))
        @include('frontend.components.gallery-category-slider', [
            'galleryCategory' => $gypsumGallerySliderCategory,
            'sectionTitle' => 'Gypsum ceiling gallery',
            'sectionSubtitle' => 'A glimpse of real installations and finishes from this gallery category.',
            'sliderId' => 'gypsum-page',
        ])
    @endif

    @include('frontend.components.faq', [
        'title' => 'Frequently asked questions (FAQ)',
        'description' => 'Quick answers on compatibility, supply, and what to expect from NIVOC gypsum ceiling tiles.',
        'items' => [
            [
                'question' => 'What are gypsum ceiling tiles and where are they used?',
                'answer' => 'Gypsum ceiling tiles are lightweight panels used in false ceilings for offices, hospitals, retail stores, and commercial spaces to create a clean and uniform ceiling finish.',
            ],
            [
                'question' => 'What is the cost of gypsum ceiling per sq ft in India?',
                'answer' => 'Gypsum ceiling tile systems typically cost between ₹60 to ₹150 per sq ft, depending on tile quality, T-grid system, and installation.',
            ],
            [
                'question' => 'Which is better: gypsum ceiling tiles or POP ceiling?',
                'answer' => 'Gypsum ceiling tiles are better for commercial spaces as they offer faster installation, easy maintenance, and tile replacement, whereas POP is more time-consuming and permanent.',
            ],
            [
                'question' => 'Are gypsum ceiling tiles fire-resistant and durable?',
                'answer' => 'Yes, gypsum tiles are fire-resistant, lightweight, and durable, making them ideal for commercial and institutional spaces.',
            ],
            [
                'question' => 'Are gypsum ceiling tiles suitable for homes?',
                'answer' => 'Yes, they can be used in homes, but they are more commonly preferred for offices and commercial areas due to their grid system design.',
            ],
            [
                'question' => 'What are the advantages of gypsum ceiling tiles?',
                'answer' => 'Clean and professional look
                Easy maintenance
                Quick installation
                Good thermal and sound insulation',
            ],
        ],
    ])

    @include('frontend.components.contact', [
        'title' => 'Enquire Now for Bulk Orders & Dealer Pricing ',
        'description' => 'Reliable materials. Scalable supply. Trusted partnership.',
        'eyebrow' => 'CONTACT US',
    ])

    @include('frontend.components.home.sticky-enquiry')
@endsection
