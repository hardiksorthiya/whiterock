@php
    $gcCategory = $galleryCategory ?? $category ?? null;
    $gcSliderId = isset($sliderId) ? preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $sliderId) : null;

    $gcUrls = [];
    $gcTitle = $title ?? null;

    if ($gcCategory) {
        $gcCategory->loadMissing('images');
        $gcUrls = collect($gcCategory->images ?? [])
            ->filter(fn ($img) => !empty($img->image))
            ->map(fn ($img) => asset('storage/' . $img->image))
            ->values()
            ->all();
        $gcTitle = $gcTitle ?? ($gcCategory->name ?? 'Gallery');
    } elseif (!empty($imageUrls) && is_array($imageUrls)) {
        $gcUrls = array_values(array_filter($imageUrls, fn ($u) => is_string($u) && $u !== ''));
        $gcTitle = $gcTitle ?? ($albumTitle ?? 'Gallery');
    }

    $gcSuffix = $gcSliderId ?? (string) (($gcCategory?->id) ?: substr(md5(implode('|', $gcUrls)), 0, 10));
    $gcModalId = 'gcGalleryModal-' . $gcSuffix;
    $gcLabelId = 'gcGalleryModalLabel-' . $gcSuffix;
    $gcBodyId = 'gcGalleryModalBody-' . $gcSuffix;
    $gcPayloadId = 'gcGalleryPayload-' . $gcSuffix;
    $gcSectionTitle = $sectionTitle ?? $gcTitle;
    $gcSectionSubtitle = $sectionSubtitle ?? $subtitle ?? null;
    $gcCarouselId = 'careerFoundationHero-' . $gcSuffix;
@endphp

@if (count($gcUrls))
    <section class="career-foundation-hero py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="sorath-title mb-2">{{ $gcSectionTitle }}</h2>
                @if (!empty($gcSectionSubtitle))
                    <p class="career-foundation-hero__subtitle mb-0 mx-auto">{{ $gcSectionSubtitle }}</p>
                @endif
            </div>

            <div id="{{ $gcCarouselId }}" class="carousel slide career-foundation-hero__carousel" data-bs-ride="carousel"
                data-bs-interval="4500" data-bs-pause="hover">
                <div class="carousel-inner rounded-4 overflow-hidden">
                    @foreach ($gcUrls as $idx => $url)
                        <div class="carousel-item @if ($idx === 0) active @endif">
                            <button type="button" class="career-foundation-hero__media-btn w-100 border-0 p-0"
                                data-bs-toggle="modal" data-bs-target="#{{ $gcModalId }}" data-gc-index="{{ $idx }}"
                                aria-label="View image {{ $idx + 1 }}">
                                <img src="{{ $url }}" alt="" class="career-foundation-hero__img" loading="lazy">
                                <span class="career-foundation-hero__overlay" aria-hidden="true"></span>
                            </button>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $gcCarouselId }}" data-bs-slide="prev"
                    aria-label="Previous image">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#{{ $gcCarouselId }}" data-bs-slide="next"
                    aria-label="Next image">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>

        <div class="modal fade home-applications__modal" id="{{ $gcModalId }}" tabindex="-1"
            aria-labelledby="{{ $gcLabelId }}" data-bs-backdrop="true" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered home-applications__modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ $gcLabelId }}">{{ $gcTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="{{ $gcBodyId }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="application/json" id="{{ $gcPayloadId }}">
            {!! json_encode(['title' => $gcTitle, 'images' => $gcUrls], JSON_UNESCAPED_SLASHES) !!}
        </script>
    </section>
@endif
