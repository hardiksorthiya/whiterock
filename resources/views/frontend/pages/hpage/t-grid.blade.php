@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'CEILING T-GRID',
        'image' => asset('images/cbre.jpeg'),
    ])

    <section class="gypsum-page-hero py-5 py-lg-5">
        <div class="container">
            <div class="gypsum-page-hero__inner mx-auto text-center">
                <p class="gypsum-page-hero__eyebrow mb-2">T-Grid ceiling systems</p>
                <h1 class="gypsum-page-hero__title mb-3 mb-lg-4">
                    High-Strength T-Grid Ceiling System for False Ceilings
                </h1>
                <p class="gypsum-page-hero__lead mb-0 mx-auto">
                    Engineered for durability and precision, NIVOC T-Grid systems provide a reliable foundation for gypsum
                    ceiling tiles and modular false ceilings in commercial and residential spaces.
                </p>
            </div>
        </div>
    </section>

    @php
        $tGridStrengthPoints = [
            ['icon' => 'bi-shield-fill-check', 'label' => 'High-grade steel with accurate thickness'],
            ['icon' => 'bi-droplet-half', 'label' => 'Corrosion resistance'],
            ['icon' => 'bi-boxes', 'label' => 'Strong load-bearing capacity'],
            ['icon' => 'bi-intersect', 'label' => 'Smooth locking system'],
        ];

        $tGridWhyPoints = [
            ['icon' => 'bi-palette-fill', 'label' => 'Clean finish with premium powder coating'],
            ['icon' => 'bi-shield-lock', 'label' => 'No rusting, no shade difference'],
            ['icon' => 'bi-grid-3x3', 'label' => 'Zero bending, zero alignment issues'],
            ['icon' => 'bi-layers-half', 'label' => 'Consistent colour shade in every batch'],
        ];
    @endphp

    @include('frontend.components.home.product-grid', [
        'sectionTitle' => 'T-Grid products',
        'sectionDescription' => '',
        'products' => $tGridPageProducts,
        'viewAllUrl' => null,
        'sectionId' => 't-grid-page-products',
        'headerSplit' => true,
    ])

    <section class="gypsum-page-cta-bar py-4 py-lg-5">
        <div class="container text-center">
            <a href="{{ $tGridPageCategoryUrl }}" class="btn gypsum-page__view-all px-4 px-lg-5 py-3 text-decoration-none">
                View all products
            </a>
        </div>
    </section>

    <section class="gypsum-benefits py-5 py-lg-5" aria-labelledby="t-grid-strength-heading">
        <div class="container">
            <h2 id="t-grid-strength-heading" class="gypsum-benefits__title sorath-title text-center mx-auto mb-4 mb-lg-5">
                Engineered for Strength, Precision &amp; Performance
            </h2>
            <div class="row row-cols-2 row-cols-md-4 g-4 gypsum-benefits__row justify-content-center">
                @foreach ($tGridStrengthPoints as $item)
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

    <section class="gypsum-why py-5 py-lg-5" aria-labelledby="t-grid-why-heading">
        <div class="container">
            <header class="gypsum-why__header text-center mx-auto mb-4 mb-lg-5">
                <p class="gypsum-why__badge mb-3">Built for professionals</p>
                <h2 id="t-grid-why-heading" class="gypsum-why__title sorath-title mb-3">
                    Why Choose NIVOC T-Grid?
                </h2>
                <p class="gypsum-why__lead mb-0 mx-auto">
                    Precision manufacturing and consistent batches—so your false ceiling lines stay straight, strong, and
                    on schedule.
                </p>
            </header>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 gypsum-why__points justify-content-center">
                @foreach ($tGridWhyPoints as $point)
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
                    Download catalogue
                </a>
            </div>
        </div>
    </section>

    <section class="py-5 py-lg-5 bg-light border-top border-bottom" aria-labelledby="t-grid-contractors-heading">
        <div class="container">
            <div class="mx-auto text-center" style="max-width: 48rem">
                <h2 id="t-grid-contractors-heading" class="sorath-title mb-3 mb-lg-4">
                    Built for Contractors, Trusted for Projects
                </h2>
                <p class="gypsum-page-hero__lead mb-0 mx-auto text-secondary">
                    NIVOC T-Grid systems are widely used in office ceilings, retail stores, hospitals, educational
                    institutions, and commercial buildings, where clean finish, easy maintenance, and scalability are
                    essential.
                </p>
            </div>
        </div>
    </section>

    @if (!empty($tGridGallerySliderCategory))
        @include('frontend.components.gallery-category-slider', [
            'galleryCategory' => $tGridGallerySliderCategory,
            'sectionTitle' => 'Application photos',
            'sectionSubtitle' => 'Real installations and references using NIVOC T-Grid systems.',
            'sliderId' => 't-grid-page',
        ])
    @endif

    @include('frontend.components.faq', [
        'title' => 'Frequently asked questions (FAQ)',
        'description' => 'Quick answers on T-Grid systems, compatibility, and typical project use.',
        'items' => [
            [
                'question' => 'What is a T-Grid ceiling system?',
                'answer' => 'A T-Grid system is a metal framework used to support ceiling tiles like gypsum or mineral fiber tiles in false ceiling installations.',
            ],
            [
                'question' => 'Why is T-Grid used in false ceilings?',
                'answer' => 'T-Grid provides structural support, alignment, and easy access for maintenance, making it essential for modular ceiling systems.',
            ],
            [
                'question' => 'What is the cost of T-Grid ceiling system in India?',
                'answer' => 'T-Grid system cost typically ranges between ₹15 to ₹40 per sq ft, depending on material quality and brand.',
            ],
            [
                'question' => 'Which ceiling tiles can be used with T-Grid?',
                'answer' => 'T-Grid systems are compatible with gypsum tiles, mineral fiber tiles, and other modular ceiling panels.',
            ],
            [
                'question' => 'Is T-Grid ceiling suitable for commercial spaces?',
                'answer' => 'Yes, it is widely used in offices, hospitals, retail stores, and large commercial projects due to its scalability and maintenance benefits.',
            ],
        ],
    ])

    @include('frontend.components.contact', [
        'title' => 'Enquire Now for Bulk Orders & Dealer Pricing',
        'description' => 'Reliable materials. Scalable supply. Trusted partnership.',
        'eyebrow' => 'CONTACT US',
        'formNote' => 'Please include your phone number and city so we can respond with accurate logistics and pricing.',
    ])

    @include('frontend.components.home.sticky-enquiry')
@endsection
