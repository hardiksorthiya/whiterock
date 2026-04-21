@php
    $milestones = [
        ['year' => '2021', 'month' => 'Nov', 'description' => 'Launched Forest Collection in Soffit with 6 matt shades'],
        ['year' => '2022', 'month' => 'Apr', 'description' => 'Added extra machinery, increasing production capacity to 65,000 sq.ft/day'],
        ['year' => '2022', 'month' => 'Jun', 'description' => 'Launched Dura+ exterior facade system'],
        ['year' => '2023', 'month' => 'Sep', 'description' => 'Launched Innov2+ series with new profile options'],
        ['year' => '2024', 'month' => 'Jun', 'description' => 'Launched Innov+ in dual tone'],
        ['year' => '2024', 'month' => 'Oct', 'description' => 'Opened first experience center'],
        ['year' => '2025', 'month' => 'Apr', 'description' => 'Launched acoustic panel line'],
        ['year' => '2025', 'month' => 'Jul', 'description' => 'Expanded national warehouse network'],
        ['year' => '2025', 'month' => 'Sep', 'description' => 'Introduced next-gen ceiling systems'],
        ['year' => '2025', 'month' => 'Nov', 'description' => 'Scaled partner distribution program'],
        ['year' => '2026', 'month' => 'Jan', 'description' => 'Added new finishes for premium projects'],
        ['year' => '2026', 'month' => 'Mar', 'description' => 'Improved lead-time performance across regions'],
    ];
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<section class="about-road-carousel py-5" aria-labelledby="about-roadmap-heading">
    <div class="text-center mb-4 px-3">
        <p class="sorath-small-title mb-2 text-uppercase small">Our Journey</p>
        <h2 id="about-roadmap-heading" class="sorath-title mb-2">Roadmap</h2>
    </div>

    <div class="about-road-carousel__wrap">
        <div class="about-road-carousel__viewport">
            <div class="about-road-carousel__road" aria-hidden="true">
                <span class="about-road-carousel__road-line"></span>
            </div>

            <div class="swiper about-road-swiper js-about-road-swiper">
                <div class="swiper-wrapper">
                    @foreach ($milestones as $item)
                        @php $isOdd = $loop->iteration % 2 === 1; @endphp
                        <div class="swiper-slide">
                            <article class="about-road-carousel__card {{ $isOdd ? 'is-up' : 'is-down' }}">
                                @if ($isOdd)
                                    <p class="about-road-carousel__desc">{{ $item['description'] }}</p>
                                    <div class="about-road-carousel__pin-wrap">
                                        <div class="about-road-carousel__pin">
                                            <span class="about-road-carousel__year">{{ $item['year'] }}</span>
                                            <span class="about-road-carousel__month">{{ $item['month'] }}</span>
                                        </div>
                                        <span class="about-road-carousel__stem"></span>
                                    </div>
                                @else
                                    <div class="about-road-carousel__pin-wrap">
                                        <span class="about-road-carousel__stem"></span>
                                        <div class="about-road-carousel__pin">
                                            <span class="about-road-carousel__year">{{ $item['year'] }}</span>
                                            <span class="about-road-carousel__month">{{ $item['month'] }}</span>
                                        </div>
                                    </div>
                                    <p class="about-road-carousel__desc">{{ $item['description'] }}</p>
                                @endif
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
