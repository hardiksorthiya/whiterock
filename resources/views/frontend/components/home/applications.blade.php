@php
    $applicationIds = $applicationIds ?? null;
    if (!is_null($applicationIds) && !is_array($applicationIds)) {
        $applicationIds = [$applicationIds];
    }

    // Unique suffix for DOM ids (so multiple sections can coexist).
    $suffix = '1';
    if (is_array($applicationIds) && !empty($applicationIds)) {
        $suffix = (string) reset($applicationIds);
    } else {
        $suffix = 'apps';
    }

    $modalId = 'applicationImagesModal-' . $suffix;
    $modalLabelId = 'applicationImagesModalLabel-' . $suffix;
    $viewerMainId = 'applicationViewerMainImage-' . $suffix;
    $viewerThumbsId = 'applicationViewerThumbs-' . $suffix;

    $applicationCards = collect();
    $sectionTitle = 'Product Applications';

    if (!empty($productApplications) && method_exists($productApplications, 'isNotEmpty') && $productApplications->isNotEmpty()) {
        if (is_array($applicationIds) && !empty($applicationIds)) {
            $ids = array_values(array_map('intval', $applicationIds));
            $productApplications = $productApplications->whereIn('id', $ids)->values();
        }

        // Use backend application name(s) for the section heading.
        $names = collect($productApplications)
            ->pluck('name')
            ->filter()
            ->values();
        if ($names->isNotEmpty()) {
            $sectionTitle = $names->count() === 1
                ? (string) $names->first()
                : ((string) $names->first() . ' +' . ($names->count() - 1) . ' more');
        }

        // Explode multi-selected categories into separate cards (so each card shows only one gallery category like before).
        $applicationCards = $productApplications
            ->flatMap(function ($app) {
                $galleryCategories = collect($app->galleryCategories ?? []);

                return $galleryCategories->map(function ($cat) use ($app) {
                    $images = collect($cat->images ?? [])
                        ->filter(fn ($image) => !empty($image->image))
                        ->values();

                    $imageUrls = $images->map(fn ($image) => asset('storage/' . $image->image))->values()->all();

                    $cover = !empty($app->feature_image)
                        ? asset('storage/'.$app->feature_image)
                        : (!empty($imageUrls[0])
                            ? $imageUrls[0]
                            : asset('images/nproduct.jpeg'));

                    return [
                        // Unique key per (application, category) pair.
                        'id' => (string) $app->id . '-' . (string) $cat->id,
                        'name' => (string) ($cat->name ?? ''),
                        'images' => $imageUrls,
                        'cover' => $cover,
                    ];
                });
            })
            ->filter(fn ($card) => !empty($card['name']))
            ->values();
    } else {
        // Backward compatible fallback: show all gallery categories if no application entries exist.
        $applicationCards = collect($galleryCategories ?? [])
            ->map(function ($category) {
                $images = collect($category->images ?? [])
                    ->filter(fn ($image) => !empty($image->image))
                    ->values();

                $imageUrls = $images->map(fn ($image) => asset('storage/' . $image->image))->values()->all();

                return [
                    'id' => (int) $category->id,
                    'name' => (string) ($category->name ?? 'Category'),
                    'images' => $imageUrls,
                    'cover' => $images->isNotEmpty() ? asset('storage/' . $images->first()->image) : asset('images/nproduct.jpeg'),
                ];
            })
            ->filter(fn ($card) => !empty($card['name']))
            ->values();
    }

    $applicationCardMap = $applicationCards->keyBy('id');
@endphp

@if ($applicationCards->isNotEmpty())
    <section
        class="home-applications py-5 {{ (is_numeric($suffix) && (int) $suffix === 2) ? 'home-applications--ltr' : '' }}">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="sorath-title mb-2">Product Application Of {{ $sectionTitle }}</h2>
            </div>
        </div>

        <div class="home-applications__rail-wrap">
            <div class="home-applications__rail">
                @for ($copy = 0; $copy < 2; $copy++)
                    @foreach ($applicationCards as $card)
                        <button type="button"
                            class="home-applications__card"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $modalId }}"
                            data-application-id="{{ $card['id'] }}"
                            aria-label="View {{ $card['name'] }} images">
                            <img src="{{ $card['cover'] }}" alt="{{ $card['name'] }}" class="home-applications__card-img">
                            <span class="home-applications__card-name">{{ $card['name'] }}</span>
                        </button>
                    @endforeach
                @endfor
            </div>
        </div>

        <div class="modal fade home-applications__modal" id="{{ $modalId }}" tabindex="-1"
            aria-labelledby="{{ $modalLabelId }}"
            data-bs-backdrop="false"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered home-applications__modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ $modalLabelId }}">Application Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="applicationImagesModalBody-{{ $suffix }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- JSON payload for frontend JS (used to render modal gallery images) --}}
    <script type="application/json" id="applicationCardMap-{{ $suffix }}">
        {!! json_encode($applicationCardMap, JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif
