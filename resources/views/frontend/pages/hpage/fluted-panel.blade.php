@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'FLUTED PANELS',
        'image' => asset('images/cbre.jpeg'),
    ])

    <section class="gypsum-page-hero py-5 py-lg-5">
        <div class="container">
            <div class="gypsum-page-hero__inner mx-auto text-center">
                <p class="gypsum-page-hero__eyebrow mb-2">Fluted wall &amp; feature panels</p>
                <h1 class="gypsum-page-hero__title mb-3 mb-lg-4">
                    Modern Walls. Premium Finish. Faster Execution.
                </h1>
                <p class="gypsum-page-hero__lead mb-0 mx-auto">
                    Upgrade your interiors with NIVOC Fluted Panels—designed for contemporary spaces that demand both style
                    and durability.
                </p>
            </div>
        </div>
    </section>

    @php
        $flutedFeaturePoints = [
            ['icon' => 'bi-tree', 'label' => 'Wood look'],
            ['icon' => 'bi-cloud-sun', 'label' => 'Weather proof'],
            ['icon' => 'bi-droplet', 'label' => 'Water proof'],
            ['icon' => 'bi-lightning-charge', 'label' => 'Quick installation'],
            ['icon' => 'bi-tools', 'label' => 'Maintenance free'],
            ['icon' => 'bi-patch-check', 'label' => 'Mold & termite resistant'],
            ['icon' => 'bi-stars', 'label' => 'Easy to clean'],
        ];

        $flutedWhyPoints = [
            ['icon' => 'bi-award', 'label' => 'Consistent finish and quality'],
            ['icon' => 'bi-box-seam', 'label' => 'Ready-to-install solutions'],
            ['icon' => 'bi-speedometer2', 'label' => 'Ideal for fast project execution'],
            ['icon' => 'bi-people-fill', 'label' => 'Preferred by contractors and designers'],
        ];
    @endphp

    @include('frontend.components.home.product-grid', [
        'sectionTitle' => 'Fluted panels',
        'sectionDescription' => '',
        'products' => $flutedPageProducts,
        'viewAllUrl' => null,
        'sectionId' => 'fluted-page-products',
        'headerSplit' => true,
    ])

    <section class="gypsum-page-cta-bar py-4 py-lg-5">
        <div class="container text-center">
            <a href="{{ $flutedPageCategoryUrl }}" class="btn gypsum-page__view-all px-4 px-lg-5 py-3 text-decoration-none">
                View all products
            </a>
        </div>
    </section>

    <section class="gypsum-benefits py-5 py-lg-5" aria-labelledby="fluted-features-heading">
        <div class="container">
            <h2 id="fluted-features-heading" class="gypsum-benefits__title sorath-title text-center mx-auto mb-4 mb-lg-5">
                Performance you can see and specify with confidence
            </h2>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 gypsum-benefits__row justify-content-center">
                @foreach ($flutedFeaturePoints as $item)
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

    <section class="gypsum-why py-5 py-lg-5" aria-labelledby="fluted-why-heading">
        <div class="container">
            <header class="gypsum-why__header text-center mx-auto mb-4 mb-lg-5">
                <p class="gypsum-why__badge mb-3">Built for professionals</p>
                <h2 id="fluted-why-heading" class="gypsum-why__title sorath-title mb-3">
                    Why Choose NIVOC Fluted Panels?
                </h2>
                <p class="gypsum-why__lead mb-0 mx-auto">
                    Textured feature walls and reception zones—with supply and finish you can repeat across every batch.
                </p>
            </header>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 gypsum-why__points justify-content-center">
                @foreach ($flutedWhyPoints as $point)
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

    @if (!empty($flutedGallerySliderCategory))
        @include('frontend.components.gallery-category-slider', [
            'galleryCategory' => $flutedGallerySliderCategory,
            'sectionTitle' => 'Application images',
            'sectionSubtitle' => 'Feature walls, receptions, and commercial interiors using NIVOC fluted panels.',
            'sliderId' => 'fluted-page',
        ])
    @endif

    @include('frontend.components.faq', [
        'title' => 'Frequently asked questions (FAQ)',
        'description' => 'Quick answers on fluted panels, finishes, and typical interior applications.',
        'items' => [
            [
                'question' => 'What are fluted panels and where are they used?',
                'answer' => 'Fluted panels are decorative wall panels with a linear textured design, widely used for TV units, feature walls, office interiors, reception areas, and commercial spaces.',
            ],
            [
                'question' => 'Which is better: fluted panel or laminate?',
                'answer' => 'Fluted panels are a better choice for modern interiors as they offer a 3D textured finish, faster installation, and higher durability, whereas laminates provide a flat finish and require more carpentry work.',
            ],
            [
                'question' => 'What is the price of fluted panels in India?',
                'answer' => 'Fluted panel prices generally range between ₹120 to ₹400 per sq ft, depending on material (WPC/PVC), finish, and design.',
            ],
            [
                'question' => 'Are fluted panels waterproof and termite-proof?',
                'answer' => 'Yes, most fluted panels (especially WPC/PVC-based) are water-resistant, termite-proof, and suitable for long-term interior use.',
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
