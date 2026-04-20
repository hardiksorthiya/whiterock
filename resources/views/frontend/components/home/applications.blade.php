@php
    $applicationCategories = collect($galleryCategories ?? [])
        ->map(function ($category) {
            $images = collect($category->images ?? [])
                ->filter(fn ($image) => !empty($image->image))
                ->values();

            return [
                'id' => (int) $category->id,
                'name' => (string) ($category->name ?? 'Category'),
                'images' => $images->map(fn ($image) => asset('storage/' . $image->image))->values()->all(),
                'cover' => $images->isNotEmpty() ? asset('storage/' . $images->first()->image) : asset('images/nproduct.jpeg'),
            ];
        })
        ->filter(fn ($category) => !empty($category['name']))
        ->values();

    $applicationCategoryMap = $applicationCategories->keyBy('id');
@endphp

@if ($applicationCategories->isNotEmpty())
    <section class="home-applications py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="sorath-title mb-2">Product Applications</h2>
                <p class="sorath-desc mb-0">
                    Discover how our products enhance every space. Tap a category to preview its gallery images.
                </p>
            </div>
        </div>

        <div class="home-applications__rail-wrap">
            <div class="home-applications__rail">
                @for ($copy = 0; $copy < 2; $copy++)
                    @foreach ($applicationCategories as $category)
                        <button type="button"
                            class="home-applications__card"
                            data-bs-toggle="modal"
                            data-bs-target="#applicationImagesModal"
                            data-category-id="{{ $category['id'] }}"
                            aria-label="View {{ $category['name'] }} images">
                            <img src="{{ $category['cover'] }}" alt="{{ $category['name'] }}" class="home-applications__card-img">
                            <span class="home-applications__card-name">{{ $category['name'] }}</span>
                        </button>
                    @endforeach
                @endfor
            </div>
        </div>

        <div class="modal fade home-applications__modal" id="applicationImagesModal" tabindex="-1" aria-labelledby="applicationImagesModalLabel"
            data-bs-backdrop="false"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered home-applications__modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="applicationImagesModalLabel">Application Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="applicationImagesModalBody"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function initApplicationsModal() {
                const modal = document.getElementById('applicationImagesModal');
                if (!modal) return;

                const categories = @json($applicationCategoryMap);
                const title = modal.querySelector('#applicationImagesModalLabel');
                const body = modal.querySelector('#applicationImagesModalBody');

                modal.addEventListener('show.bs.modal', function(event) {
                    const trigger = event.relatedTarget;
                    if (!trigger) return;

                    const categoryId = String(trigger.getAttribute('data-category-id') || '');
                    const category = categories[categoryId];
                    if (!category || !body || !title) return;

                    title.textContent = category.name + ' - Gallery';
                    const images = Array.isArray(category.images) ? category.images : [];

                    if (images.length === 0) {
                        body.innerHTML =
                            '<div class="text-center text-muted py-4">No images in this category yet.</div>';
                        return;
                    }

                    body.innerHTML = `
                        <div class="home-applications__viewer">
                            <button type="button" class="home-applications__viewer-nav home-applications__viewer-prev" aria-label="Previous image">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <img src="${images[0]}" alt="${category.name} image 1" class="home-applications__modal-main-img" id="applicationViewerMainImage">
                            <button type="button" class="home-applications__viewer-nav home-applications__viewer-next" aria-label="Next image">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                        <div class="home-applications__modal-thumbs mt-3" id="applicationViewerThumbs">
                            ${images.map((img, idx) => `
                                <button type="button" class="home-applications__thumb-btn ${idx === 0 ? 'is-active' : ''}" data-slide-to="${idx}" aria-label="Show image ${idx + 1}">
                                    <img src="${img}" alt="${category.name} thumbnail ${idx + 1}" class="home-applications__thumb-img">
                                </button>
                            `).join('')}
                        </div>
                    `;

                    const mainImage = body.querySelector('#applicationViewerMainImage');
                    const thumbsWrap = body.querySelector('#applicationViewerThumbs');
                    const prevBtn = body.querySelector('.home-applications__viewer-prev');
                    const nextBtn = body.querySelector('.home-applications__viewer-next');
                    if (!mainImage || !thumbsWrap || !prevBtn || !nextBtn) return;

                    const thumbButtons = Array.from(thumbsWrap.querySelectorAll('.home-applications__thumb-btn'));
                    let activeIndex = 0;
                    let touchStartX = 0;

                    const updateViewer = (index) => {
                        if (!images.length) return;
                        activeIndex = (index + images.length) % images.length;
                        mainImage.src = images[activeIndex];
                        mainImage.alt = `${category.name} image ${activeIndex + 1}`;

                        thumbButtons.forEach((btn, idx) => {
                            btn.classList.toggle('is-active', idx === activeIndex);
                        });
                    };

                    thumbButtons.forEach((btn, idx) => {
                        btn.addEventListener('click', () => updateViewer(idx));
                    });

                    prevBtn.addEventListener('click', () => updateViewer(activeIndex - 1));
                    nextBtn.addEventListener('click', () => updateViewer(activeIndex + 1));

                    mainImage.addEventListener('touchstart', (e) => {
                        touchStartX = e.changedTouches[0]?.clientX ?? 0;
                    }, { passive: true });

                    mainImage.addEventListener('touchend', (e) => {
                        const touchEndX = e.changedTouches[0]?.clientX ?? 0;
                        const deltaX = touchEndX - touchStartX;
                        if (Math.abs(deltaX) < 24) return;
                        if (deltaX > 0) {
                            updateViewer(activeIndex - 1);
                        } else {
                            updateViewer(activeIndex + 1);
                        }
                    }, { passive: true });
                });
            })();
        </script>
    @endpush
@endif
