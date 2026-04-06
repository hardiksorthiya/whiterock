<section class="sorath-portfolio py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left Intro -->
            <div class="col position-relative">
                <div class="sorath-section-header text-center">
                    <div class="d-flex justify-content-center mb-3 align-items-center">
                        <h2 class="portfolio-text-line position-absolute">PORTFOLIO</h2>
                        <h2 class="sorath-title">Latest Projects</h2>
                    </div>

                    <p class="sorath-desc">
                        Far far away behind the word mountains far from the countries
                        Vokalia and Consonantia there live the blind texts.
                    </p>
                </div>
            </div>

            <ul class="nav nav-tabs sorath-tabs justify-content-center mb-4 flex-wrap" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="portfolio-all-tab" data-bs-toggle="tab"
                        data-bs-target="#portfolio-all" type="button" role="tab" aria-controls="portfolio-all"
                        aria-selected="true">
                        ALL
                    </button>
                </li>
                @foreach ($galleryCategories as $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="portfolio-cat-{{ $category->id }}-tab" data-bs-toggle="tab"
                            data-bs-target="#portfolio-cat-{{ $category->id }}" type="button" role="tab"
                            aria-controls="portfolio-cat-{{ $category->id }}" aria-selected="false">
                            {{ strtoupper($category->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>  
    </div>

    <div class="container-fluid">
        <div class="tab-content">
            {{-- All products --}}
            <div class="tab-pane fade show active" id="portfolio-all" role="tabpanel" aria-labelledby="portfolio-all-tab"
                tabindex="0">
                <div class="container-fluid">
                    <div class="row">
                        @forelse ( $latestGalleryImages as $image)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="sorath-gallery-card">
                                    @if (!empty($image->image))
                                        <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid"
                                            alt="{{ $image->name }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="min-height: 200px;">
                                            <span class="text-muted small">No image</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4">No products yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            @foreach ($galleryCategories as $category)
                <div class="tab-pane fade" id="portfolio-cat-{{ $category->id }}" role="tabpanel"
                    aria-labelledby="portfolio-cat-{{ $category->id }}-tab" tabindex="0">
                    <div class="container-fluid">
                        <div class="row">
                            @forelse ($category->images as $image)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="sorath-gallery-card">
                                        @if (!empty($image->image))
                                            <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid"
                                                alt="{{ $image->name }}">
                                        @elseif (!empty($product->image))
                                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid"
                                                alt="{{ $product->name }}">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="min-height: 200px;">
                                                <span class="text-muted small">No image</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted py-4">No products in this category.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
