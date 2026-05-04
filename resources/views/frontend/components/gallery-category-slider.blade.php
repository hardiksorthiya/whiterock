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
@endphp

@if (count($gcUrls))
    <section class="gallery-category-slider home-applications py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="sorath-title mb-2">{{ $gcSectionTitle }}</h2>
                @if (!empty($gcSectionSubtitle))
                    <p class="gallery-category-slider__subtitle mb-0 mx-auto">{{ $gcSectionSubtitle }}</p>
                @endif
            </div>
        </div>

        <div class="home-applications__rail-wrap">
            <div class="home-applications__rail">
                @for ($copy = 0; $copy < 2; $copy++)
                    @foreach ($gcUrls as $idx => $url)
                        <button type="button"
                            class="home-applications__card gallery-category-slider__photo"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $gcModalId }}"
                            data-gc-index="{{ $idx }}"
                            aria-label="View image {{ $idx + 1 }}">
                            <img src="{{ $url }}" alt="" class="home-applications__card-img gallery-category-slider__photo-img"
                                loading="lazy">
                            <span class="gallery-category-slider__zoom" aria-hidden="true">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </span>
                        </button>
                    @endforeach
                @endfor
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
