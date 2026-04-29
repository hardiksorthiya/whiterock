@php
    $blocks = [
        [
            'title' => 'T-Grid Ceiling Systems',
            'text' => 'Every batch is manufactured with strict quality control, ensuring uniform finish, strength, and reliability across projects.',
            'img' => asset('images/n1.jpeg'),
            'alt' => 'T-Grid Ceiling Systems',
        ],
        [
            'title' => 'Gypsum Ceiling Tiles',
            'text' => 'Engineered systems that reduce installation time, helping contractors complete projects efficiently without compromising quality.',
            'img' => asset('images/n2.jpeg'),
            'alt' => 'Gypsum Ceiling Tiles',
        ],
        [
            'title' => 'Fluted Wall Panels',
            'text' => 'From gypsum ceiling tiles to T-grid systems and decorative panels, we offer complete solutions under one roof.',
            'img' => asset('images/n3.jpeg'),
            'alt' => 'Fluted Wall Panels',
        ],
        [
            'title' => 'Soffit Ceiling Panels',
            'text' => 'With a strong dealer network, we ensure consistent availability and timely delivery across multiple locations.',
            'img' => asset('images/n4.jpeg'),
            'alt' => 'Soffit Ceiling Panels',
        ],
    ];
@endphp

<section class="block-grid-section pb-4">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="sorath-title mb-2">We offer a complete range of products including</h3>
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
                            <p class="card-text text-muted small mb-0 flex-grow-1">{{ $block['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
