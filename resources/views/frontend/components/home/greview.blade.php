@php
    $g = $googleReviewsData ?? [];
    $reviews = array_slice($g['reviews'] ?? [], 0, 15);
    $n = count($reviews);
@endphp

@if ($n > 0)
    <section class="sorath-t py-5" aria-labelledby="t-h">
        <div class="container">
            <div class="row sorath-t__row">
                <div class="col-lg-5 sorath-t__img-wrap">
                    <img src="{{ asset('images/testimonialbg.jpg') }}" alt="" class="sorath-t__img">
                </div>
                <div class="col-lg-7 sorath-t__panel">
                    <div class="row">
                        <div class="col-lg-8">
                            <h2 id="t-h" class="sorath-t__h">TESTIMONIALS</h2>
                            <p class="sorath-t__intro small text-muted mb-4">
                                @if (!empty($g['overall_rating']) && !empty($g['user_ratings_total']))
                                    {{ number_format($g['overall_rating'], 1) }} · {{ $g['user_ratings_total'] }} Google
                                    reviews
                                @else
                                    Google reviews
                                @endif
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                             @if (!empty(data_get($setting, 'google_place_id')))
                            <p class="small text-muted mt-3 mb-0">
                                <a href="https://www.google.com/maps/search/?api=1&amp;query=Google&amp;query_place_id={{ urlencode(data_get($setting, 'google_place_id')) }}"
                                    target="_blank" rel="noopener">Google Maps</a>
                            </p>
                        @endif
                        </div>

                       

                        <div id="tCarousel" class="carousel slide position-relative pb-4"
                            @if ($n > 1) data-bs-ride="carousel" data-bs-interval="7000" @endif>
                            <div class="carousel-inner">
                                @foreach ($reviews as $i => $r)
                                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                        <p class="sorath-t__text">{{ data_get($r, 'text') }}</p>
                                        <div
                                            class="d-flex justify-content-between align-items-end gap-2 mt-4 pt-3 border-top">
                                            <div class="d-flex gap-2 align-items-center min-w-0">
                                                @if ($p = data_get($r, 'profile_photo_url'))
                                                    <img src="{{ $p }}" alt=""
                                                        class="rounded-circle flex-shrink-0" width="48"
                                                        height="48">
                                                @else
                                                    <div class="sorath-t__av rounded-circle flex-shrink-0">
                                                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr((string) data_get($r, 'author_name', 'G'), 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="min-w-0">
                                                    <strong
                                                        class="d-block">{{ data_get($r, 'author_name', 'User') }}</strong>
                                                    <small
                                                        class="text-muted">{{ data_get($r, 'relative_time_description') }}</small>
                                                </div>
                                            </div>
                                            <span class="sorath-t__q" aria-hidden="true">“</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($n > 1)
                                <div
                                    class="carousel-indicators sorath-t__dots position-absolute bottom-0 start-0 end-0 m-0">
                                    @foreach ($reviews as $i => $_)
                                        <button type="button" data-bs-target="#tCarousel"
                                            data-bs-slide-to="{{ $i }}"
                                            class="{{ $i === 0 ? 'active' : '' }}"
                                            aria-label="{{ $i + 1 }}"></button>
                                    @endforeach
                                </div>
                                {{-- <button class="carousel-control-prev" type="button" data-bs-target="#tCarousel"
                                    data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                                <button class="carousel-control-next" type="button" data-bs-target="#tCarousel"
                                    data-bs-slide="next"><span class="carousel-control-next-icon"></span></button> --}}
                            @endif
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
