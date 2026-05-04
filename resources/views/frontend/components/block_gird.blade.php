@php
    $blocks = [
        [
            'title' => 'T-Grid Ceiling Systems',
            'img' => asset('images/about/tg.jpg'),
            'alt' => 'T-Grid Ceiling Systems',
        ],
        [
            'title' => 'Gypsum Ceiling Tiles',
            'img' => asset('images/about/gy.jpg'),
            'alt' => 'Gypsum Ceiling Tiles',
        ],
        [
            'title' => 'Fluted Wall Panels',
           'img' => asset('images/about/fl.jpg'),
            'alt' => 'Fluted Wall Panels',
        ],
        [
            'title' => 'Soffit Ceiling Panels',
            'img' => asset('images/about/sf.jpg'),
            'alt' => 'Soffit Ceiling Panels',
        ],
    ];
@endphp

<section class="block-grid-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h4 class="mb-2">We offer a complete range of products including</h4>
            </div>
        <div class="row g-4">
            @foreach ($blocks as $block)
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="ratio ratio-4x3 bg-light block-grid-media">
                            <img src="{{ $block['img'] }}"
                                class="w-100 h-100 object-fit-cover block-grid-media__img"
                                alt="{{ $block['alt'] }}">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-semibold mb-3">{{ $block['title'] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
