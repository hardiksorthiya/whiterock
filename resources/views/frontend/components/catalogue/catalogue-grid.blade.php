@if ($catalogues->isEmpty())
    <div class="catalogue-empty text-center py-5 px-3 rounded-3 bg-light">
        <p class="mb-2 fw-semibold text-secondary">No catalogues here yet.</p>
        <p class="small text-muted mb-0">Check another category or visit again soon.</p>
        <a href="{{ route('catalogue') }}" class="btn btn-sm btn-outline-dark mt-3 rounded-pill">View all catalogues</a>
    </div>
@else
    <div class="row g-4 g-lg-5 catalogue-book-grid justify-content-center">
        @foreach ($catalogues as $item)
            @php
                $pdfUrl = $item->pdf ? asset('storage/' . $item->pdf) : null;
                $imgUrl = $item->featured_image ? asset('storage/' . $item->featured_image) : null;
            @endphp
            <div class="col-6 col-md-4 col-xl-3">
                @if ($pdfUrl)
                    <button type="button"
                        class="catalogue-book-card catalogue-book-card--pdf text-decoration-none text-center d-block w-100"
                        data-catalogue-id="{{ $item->id }}"
                        data-catalogue-name="{{ $item->name }}"
                        aria-label="Request PDF catalogue: {{ $item->name }}">
                @else
                    <div class="catalogue-book-card text-decoration-none text-center d-block catalogue-book-card--no-pdf"
                        role="group"
                        aria-label="Catalogue: {{ $item->name }} (PDF not available)">
                @endif
                        <div class="catalogue-book-card__stage">
                            <div class="catalogue-book-card__shadow" aria-hidden="true"></div>
                            @if ($imgUrl)
                                <img src="{{ $imgUrl }}" alt=""
                                    class="catalogue-book-card__cover"
                                    loading="lazy"
                                    width="280"
                                    height="360">
                            @else
                                <div class="catalogue-book-card__placeholder" aria-hidden="true">
                                    <span class="catalogue-book-card__placeholder-letter">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="catalogue-book-card__title">{{ $item->name }}</h3>
                @if ($pdfUrl)
                    </button>
                @else
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif
