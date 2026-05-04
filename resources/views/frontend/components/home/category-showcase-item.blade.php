@php
    $slugPrefix = (string) ($slugPrefix ?? '');
    $sectionTitle = (string) ($sectionTitle ?? 'Product Category');
    $sectionDescription = (string) ($sectionDescription ?? 'Explore our product range for this category.');
    $imageUrl = (string) ($imageUrl ?? asset('images/nproduct.jpeg'));
    $rightSliderImages = collect($rightSliderImages ?? [])->filter()->values();
    $titleImageUrl = !empty($titleImageUrl) ? (string) $titleImageUrl : null;

    $category = collect($productCategories ?? [])->first(function ($pc) use ($slugPrefix) {
        $slug = (string) ($pc->slug ?? '');
        return $slug === $slugPrefix || str_starts_with($slug, $slugPrefix . '-');
    });
    $sectionUrl = route($slugPrefix);
@endphp

<section class="home-category-showcase py-4 py-lg-5">
    <div class="container">
        <article class="category-showcase">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-6 d-flex">
                    <div class="home-category-showcase__content w-100 d-flex flex-column justify-content-center">
                        @if (!empty($titleImageUrl))
                            <img src="{{ $titleImageUrl }}"
                                alt="{{ $sectionTitle }}"
                                class="home-category-showcase__title-image mb-3">
                        @else
                            <h2 class="sorath-title mb-3">{{ $sectionTitle }}</h2>
                        @endif
                        <p class="sorath-desc text-start mb-4">{{ $sectionDescription }}</p>
                        <div>
                            <a href="{{ $sectionUrl }}" class="btn btn-dark home-category-showcase__btn">
                                Know more
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="home-category-showcase__media">
                        @if ($rightSliderImages->isNotEmpty())
                            <div id="home-right-slider-{{ $slugPrefix }}"
                                class="carousel slide home-category-showcase__right-slider"
                                data-bs-ride="carousel"
                                data-bs-interval="2600"
                                data-bs-pause="false"
                                data-bs-touch="true"
                                data-bs-wrap="true">
                                <div class="carousel-inner">
                                    @foreach ($rightSliderImages as $sliderImage)
                                        <div class="carousel-item @if ($loop->first) active @endif">
                                            <img src="{{ $sliderImage }}"
                                                alt="{{ $sectionTitle }}"
                                                class="img-fluid w-100 h-100">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <img src="{{ $imageUrl }}"
                                alt="{{ $sectionTitle }}"
                                class="img-fluid w-100 h-100">
                        @endif
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
