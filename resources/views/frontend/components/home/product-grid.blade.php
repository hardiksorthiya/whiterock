{{--
    Expects: $sectionTitle, $products, optional $sectionDescription, $sectionId, $viewAllUrl
    Optional: $headerSplit (bool) — title left, View All right, no description (category strips on home)
--}}
@php
    $sectionDescription = $sectionDescription
        ?? 'Far far away behind the word mountains far from the countries Vokalia and Consonantia there live the blind texts.';
    $viewAllUrl = $viewAllUrl ?? null;
    $headerSplit = filter_var($headerSplit ?? false, FILTER_VALIDATE_BOOLEAN);
    $tones = ['a', 'b', 'c', 'd', 'e', 'f'];
@endphp
<section @if (!empty($sectionId)) id="{{ $sectionId }}" @endif
    class="product-section product-section--visual-grid py-5{{ $headerSplit ? ' product-section--head-split' : '' }}">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 position-relative">
                @if ($headerSplit)
                    <div
                        class="product-section__head-row d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <h2 class="product-section__head-title sorath-title mb-0 text-start">{{ $sectionTitle }}</h2>
                        @if (!empty($viewAllUrl))
                            <a href="{{ $viewAllUrl }}"
                                class="btn btn-outline-dark product-section__view-all-btn flex-shrink-0"
                                target="_blank" rel="noopener noreferrer">
                                View All
                            </a>
                        @endif
                    </div>
                @else
                    <div class="sorath-section-header text-center">
                        <h2 class="sorath-title">{{ $sectionTitle }}</h2>
                        <p class="sorath-desc">
                            {{ $sectionDescription }}
                        </p>
                        @if (!empty($viewAllUrl))
                            <a href="{{ $viewAllUrl }}" class="btn btn-outline-dark btn-sm mt-2" target="_blank"
                                rel="noopener noreferrer">
                                View All
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-3 g-md-4 justify-content-center product-section--visual-grid__row">
            @forelse ($products as $product)
                @php
                    $tone = $tones[$loop->index % 6];
                    $detailUrl = route('product.show', $product->slug);
                    $tagline = $product->short_description ?? null;
                    $tagline = $tagline ? \Illuminate\Support\Str::limit(trim(strip_tags($tagline)), 110) : null;
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-visual-block h-100">
                        <a href="{{ $detailUrl }}"
                            class="product-visual-block__media text-reset text-decoration-none d-block">
                            <div class="product-card__frame product-card__frame--tone-{{ $tone }}">
                                <div class="product-img product-img--visual">
                                    @if (!empty($product->featured_image))
                                        <img src="{{ asset('storage/' . $product->featured_image) }}"
                                            class="product-card__visual-img"
                                            alt="{{ $product->name }}"
                                            loading="lazy">
                                    @elseif (!empty($product->image))
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="product-card__visual-img"
                                            alt="{{ $product->name }}"
                                            loading="lazy">
                                    @else
                                        <div class="product-card__visual-placeholder">
                                            <span>No image</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="product-visual-block__meta text-center">
                            <a href="{{ $detailUrl }}" class="product-visual-block__title-link text-decoration-none">
                                <h3 class="product-visual-block__title">{{ $product->name }}</h3>
                            </a>
                            @if (!empty($tagline))
                                <p class="product-visual-block__tagline">{{ $tagline }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">
                    No products to show here yet.
                </div>
            @endforelse
        </div>

    </div>
</section>
