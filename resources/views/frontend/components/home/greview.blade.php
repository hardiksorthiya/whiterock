@php
    $g = $googleReviewsData ?? [];
    $reviews = array_slice($g['reviews'] ?? [], 0, 15);
    $n = count($reviews);
    $overall = isset($g['overall_rating']) ? (float) $g['overall_rating'] : null;
    $totalReviews = isset($g['user_ratings_total']) ? (int) $g['user_ratings_total'] : null;
@endphp

@if ($n > 0)
    @php
        $starRow = static function (?float $rating): string {
            if ($rating === null || $rating < 0) {
                return '';
            }
            $r = min(5, max(0, $rating));
            $full = (int) floor($r);
            $half = $r - $full >= 0.5 ? 1 : 0;
            $empty = 5 - $full - $half;
            $html = '<span class="sorath-t__stars" aria-hidden="true">';
            for ($i = 0; $i < $full; $i++) {
                $html .= '<i class="bi bi-star-fill sorath-t__star sorath-t__star--on"></i>';
            }
            if ($half) {
                $html .= '<i class="bi bi-star-half sorath-t__star sorath-t__star--on"></i>';
            }
            for ($i = 0; $i < $empty; $i++) {
                $html .= '<i class="bi bi-star sorath-t__star sorath-t__star--off"></i>';
            }
            $html .= '</span>';

            return $html;
        };
    @endphp

    <section class="sorath-t sorath-t--reviews py-5" id="testimonials" aria-labelledby="t-h">
        <div class="container">
            <div class="sorath-t__shell">
                <div class="row g-0 sorath-t__row align-items-stretch">
                    <div class="col-lg-5 sorath-t__media-col">
                        <div class="sorath-t__media">
                            <img src="{{ asset('images/testimonialbg.jpg') }}"
                                alt=""
                                class="sorath-t__img" width="800" height="960" loading="lazy">
                            <div class="sorath-t__media-overlay" aria-hidden="true"></div>
                            <div class="sorath-t__media-caption" aria-hidden="true">
                                <span class="sorath-t__media-quote">“</span>
                                <span class="sorath-t__media-label">Trusted on Google</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 sorath-t__panel">
                        <div class="sorath-t__panel-inner">
                            <header class="sorath-t__head">
                                <p class="sorath-small-title mb-2">Testimonials</p>
                                <h2 id="t-h" class="sorath-title sorath-t__title mb-3">What our clients say</h2>
                                <div class="sorath-t__summary">
                                    @if ($overall !== null)
                                        <div class="sorath-t__summary-rating">
                                            {!! $starRow($overall) !!}
                                            <span class="sorath-t__summary-score">{{ number_format($overall, 1) }}</span>
                                            @if ($totalReviews !== null)
                                                <span class="sorath-t__summary-count">· {{ number_format($totalReviews) }}
                                                    Google reviews</span>
                                            @endif
                                        </div>
                                    @else
                                        <p class="sorath-t__summary-fallback text-muted small mb-0">Google reviews</p>
                                    @endif
                                    @if (!empty(data_get($setting, 'google_place_id')))
                                        <a class="sorath-t__maps-link"
                                            href="https://www.google.com/maps/search/?api=1&amp;query=Google&amp;query_place_id={{ urlencode(data_get($setting, 'google_place_id')) }}"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-google" aria-hidden="true"></i>
                                            View on Google Maps
                                        </a>
                                    @endif
                                </div>
                            </header>

                            <div id="tCarousel" class="carousel slide sorath-t__carousel position-relative"
                                @if ($n > 1) data-bs-ride="carousel" data-bs-interval="6500" @endif>
                                <div class="carousel-inner">
                                    @foreach ($reviews as $i => $r)
                                        @php
                                            $reviewRating = data_get($r, 'rating');
                                            $reviewRating =
                                                $reviewRating !== null && $reviewRating !== ''
                                                    ? (float) $reviewRating
                                                    : null;
                                        @endphp
                                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                            <div class="sorath-t__quote-card">
                                                @if ($reviewRating !== null)
                                                    <div class="sorath-t__review-stars mb-3">
                                                        {!! $starRow($reviewRating) !!}
                                                    </div>
                                                @endif
                                                <blockquote class="sorath-t__text mb-0">
                                                    {{ data_get($r, 'text') }}
                                                </blockquote>
                                            </div>
                                            <footer
                                                class="sorath-t__footer d-flex justify-content-between align-items-end gap-3 mt-4">
                                                <div class="d-flex gap-3 align-items-center min-w-0">
                                                    @if ($p = data_get($r, 'profile_photo_url'))
                                                        <img src="{{ $p }}"
                                                            alt="{{ data_get($r, 'author_name', 'Reviewer') }}"
                                                            class="sorath-t__avatar rounded-circle flex-shrink-0"
                                                            width="52" height="52" loading="lazy">
                                                    @else
                                                        <div
                                                            class="sorath-t__av sorath-t__avatar sorath-t__avatar--initial rounded-circle flex-shrink-0">
                                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr((string) data_get($r, 'author_name', 'G'), 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div class="min-w-0">
                                                        <strong
                                                            class="sorath-t__author d-block">{{ data_get($r, 'author_name', 'User') }}</strong>
                                                        <span
                                                            class="sorath-t__when">{{ data_get($r, 'relative_time_description') }}</span>
                                                    </div>
                                                </div>
                                                <span class="sorath-t__q" aria-hidden="true">”</span>
                                            </footer>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($n > 1)
                                    <div class="sorath-t__carousel-foot d-flex flex-wrap align-items-center justify-content-between gap-3 mt-4 pt-1">
                                        <div class="carousel-indicators sorath-t__dots m-0 position-static">
                                            @foreach ($reviews as $i => $_)
                                                <button type="button" data-bs-target="#tCarousel"
                                                    data-bs-slide-to="{{ $i }}"
                                                    class="{{ $i === 0 ? 'active' : '' }}"
                                                    aria-label="Show review {{ $i + 1 }} of {{ $n }}"></button>
                                            @endforeach
                                        </div>
                                        <div class="sorath-t__nav d-flex gap-2">
                                            <button class="btn sorath-t__nav-btn" type="button" data-bs-target="#tCarousel"
                                                data-bs-slide="prev" aria-label="Previous review">
                                                <i class="bi bi-chevron-left" aria-hidden="true"></i>
                                            </button>
                                            <button class="btn sorath-t__nav-btn" type="button" data-bs-target="#tCarousel"
                                                data-bs-slide="next" aria-label="Next review">
                                                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@elseif (config('app.debug') && data_get($setting, 'google_place_id'))
    <div class="container py-2">
        <p class="small text-warning mb-0">Reviews: {{ $g['api_status'] ?? 'empty' }} — <a
                href="{{ route('google-reviews') }}">JSON</a></p>
    </div>
@endif
