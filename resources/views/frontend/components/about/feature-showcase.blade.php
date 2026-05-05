@php
    $rawSlides = ($about && is_array($about->about_feature_slides)) ? $about->about_feature_slides : null;
    if (empty($rawSlides) || ! is_array($rawSlides)) {
        $rawSlides = [
            [
                'title' => 'Watch our journey and product story.',
                'card_media_type' => 'image',
                'card_media' => 'images/about/c1.jpeg',
                'popup_video_url' => 'images/about.mp4',
            ],
            [
                'title' => 'Quality ceiling systems, built to perform.',
                'card_media_type' => 'image',
                'card_media' => 'images/about/c2.jpeg',
                'popup_video_url' => 'https://www.youtube.com/embed/p9znelcArPM',
            ],
        ];
    }

    $cardSrc = static function (array $slide): string {
        $m = $slide['card_media'] ?? '';
        if ($m === '') {
            return '';
        }
        if (str_starts_with($m, 'http://') || str_starts_with($m, 'https://') || str_starts_with($m, '/')) {
            return $m;
        }
        if (str_contains($m, 'images/') && ! str_contains($m, 'about_feature_slides')) {
            return asset($m);
        }

        return asset('storage/' . ltrim($m, '/'));
    };

    $popupData = static function (?string $url): ?array {
        if ($url === null || trim($url) === '') {
            return null;
        }
        $u = trim($url);
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|watch\?v=))([a-zA-Z0-9_-]{11})/', $u, $m)) {
            return [
                'type' => 'youtube',
                'src' => 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&rel=0',
            ];
        }
        if (str_starts_with($u, 'http://') || str_starts_with($u, 'https://') || str_starts_with($u, '/')) {
            return ['type' => 'html5', 'src' => $u];
        }
        if (str_contains($u, 'images/') && ! str_contains($u, 'about_feature_slides')) {
            return ['type' => 'html5', 'src' => asset($u)];
        }

        return ['type' => 'html5', 'src' => asset('storage/' . ltrim($u, '/'))];
    };

    $resolveSlidePopup = static function (array $slide) use ($popupData): ?array {
        $stored = isset($slide['popup_video_path']) ? trim((string) $slide['popup_video_path']) : '';
        if ($stored !== '') {
            return ['type' => 'html5', 'src' => asset('storage/' . ltrim($stored, '/'))];
        }

        return $popupData($slide['popup_video_url'] ?? null);
    };
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<section class="about-feature-showcase py-5" aria-labelledby="about-feature-heading">
    <div class="container-fluid">
        {{-- <div class="text-center mb-4">
            <h2 id="about-feature-heading" class="sorath-title mb-2">About NIVOC</h2>
            <p class="sorath-desc mb-0 text-muted">Tap a slide to watch the full video.</p>
        </div> --}}

        <div class="about-feature-showcase__wrap position-relative">
            <div class="swiper js-about-feature-swiper">
                <div class="swiper-wrapper">
                    @foreach ($rawSlides as $slide)
                        @php
                            $src = $cardSrc($slide);
                            $popup = $resolveSlidePopup($slide);
                            $mediaType = ($slide['card_media_type'] ?? 'image') === 'video' ? 'video' : 'image';
                        @endphp
                        @if ($src !== '')
                            <div class="swiper-slide h-auto">
                                @if ($popup)
                                    <button
                                        type="button"
                                        class="about-feature-showcase__card w-100 text-start border-0 p-0"
                                        data-about-feature-popup-type="{{ $popup['type'] }}"
                                        data-about-feature-popup-src="{{ e($popup['src']) }}"
                                    >
                                @else
                                    <div class="about-feature-showcase__card about-feature-showcase__card--static w-100">
                                @endif
                                    <span class="about-feature-showcase__media">
                                        @if ($mediaType === 'video')
                                            <video
                                                class="about-feature-showcase__video"
                                                muted
                                                loop
                                                playsinline
                                                autoplay
                                                preload="metadata"
                                            >
                                                <source src="{{ $src }}">
                                            </video>
                                        @else
                                            <img
                                                class="about-feature-showcase__img"
                                                src="{{ $src }}"
                                                alt="{{ $slide['title'] ?? 'Slide' }}"
                                                loading="lazy"
                                            >
                                        @endif
                                        <span class="about-feature-showcase__overlay"></span>
                                        <span class="about-feature-showcase__caption">
                                            <span class="about-feature-showcase__title">
                                                {{ $slide['title'] ?? '' }}
                                            </span>
                                            @if ($popup)
                                                <span class="about-feature-showcase__cta">
                                                    Watch now
                                                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </span>
                                @if ($popup)
                                    </button>
                                @else
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <button type="button" class="about-feature-showcase__nav about-feature-showcase__nav--prev js-about-feature-prev" aria-label="Previous slide">
                <i class="bi bi-chevron-left fs-5" aria-hidden="true"></i>
            </button>
            <button type="button" class="about-feature-showcase__nav about-feature-showcase__nav--next js-about-feature-next" aria-label="Next slide">
                <i class="bi bi-chevron-right fs-5" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</section>

<div class="modal fade about-feature-modal" id="aboutFeatureVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content about-feature-modal__content border-0">
            <div class="modal-header about-feature-modal__header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 about-feature-modal__body">
                <div class="ratio ratio-16x9 about-feature-modal__frame" data-about-feature-modal-frame></div>
            </div>
        </div>
    </div>
</div>
