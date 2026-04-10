@php
    $items = [
        [
            'title' => 'Mission',
            'icon' => 'bi-bullseye',
            'content' => $about->mission ?? '',
            'fallback' => 'Our mission details will be updated soon.',
        ],
        [
            'title' => 'Vision',
            'icon' => 'bi-eye',
            'content' => $about->vision ?? '',
            'fallback' => 'Our vision details will be updated soon.',
        ],
        [
            'title' => 'Values',
            'icon' => 'bi-gem',
            'content' => $about->values ?? '',
            'fallback' => 'Our values details will be updated soon.',
        ],
    ];
@endphp

<section class="mvv-section py-5">
    <div class="container">
        <div class="sorath-section-header text-center mb-4">
            <p class="sorath-small-title mb-2">/ OUR FOUNDATION</p>
            <h2 class="sorath-title">Mission, Vision & Values</h2>
            <p class="sorath-desc mx-auto">The principles that guide how Whiterock builds quality, trust, and long-term customer value.</p>
        </div>

        <div class="row g-4">
            @foreach ($items as $item)
                <div class="col-md-6 col-lg-4">
                    <article class="mvv-card h-100">
                        <div class="mvv-icon">
                            <i class="bi {{ $item['icon'] }}"></i>
                        </div>
                        <h3 class="mvv-title">{{ $item['title'] }}</h3>
                        <div class="mvv-body">
                            {!! trim((string) $item['content']) !== '' ? $item['content'] : e($item['fallback']) !!}
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
