@php
    $blocks = [
        [
            'title' => 'Consistent Product Quality',
            'text' => 'Every batch is manufactured with strict quality control, ensuring uniform finish, strength, and reliability across projects.',
            'img' => asset('images/h1.jpeg'),
            'alt' => 'Consistent product quality',
        ],
        [
            'title' => 'Faster Installation',
            'text' => 'Engineered systems that reduce installation time, helping contractors complete projects efficiently without compromising quality.',
            'img' => asset('images/h1.jpeg'),
            'alt' => 'Faster installation',
        ],
        [
            'title' => 'Wide Product Range',
            'text' => 'From gypsum ceiling tiles to T-grid systems and decorative panels, we offer complete solutions under one roof.',
            'img' => asset('images/h1.jpeg'),
            'alt' => 'Wide product range',
        ],
        [
            'title' => 'Reliable Supply Network',
            'text' => 'With a strong dealer network, we ensure consistent availability and timely delivery across multiple locations.',
            'img' => asset('images/h1.jpeg'),
            'alt' => 'Reliable supply network',
        ],
    ];
@endphp

<section class="block-grid-section py-5">
    <div class="container">
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
