@extends('layouts.app')

@php
    $edit = (bool) ($application ?? null);
@endphp

@section('page_title', $edit ? 'Edit application' : 'New application')
@section('page_subtitle', $edit ? 'Update application details' : 'Create a new application')

@section('content')
    @if ($errors->any())
        <div class="adm-alert adm-alert--err">
            @foreach ($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST"
        action="{{ $edit ? route('backend.applications.update', $application->id) : route('backend.applications.store') }}"
        enctype="multipart/form-data"
        class="row g-4">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="col-lg-8">
            <section class="adm-card">
                <h2 class="adm-card__title">Application details</h2>
                <div class="adm-card__body">
                    <div class="mb-3">
                        <label for="app-name" class="form-label">Application Name</label>
                        <input type="text" id="app-name" name="name" class="form-control" required maxlength="255"
                            value="{{ old('name', data_get($application, 'name')) }}">
                    </div>

                    <div class="mb-3">
                        @php
                            $selectedCategoryIds = old('gallery_category_ids', data_get($application, 'gallery_category_ids', []));
                            if (! is_array($selectedCategoryIds)) {
                                $selectedCategoryIds = [];
                            }
                            $selectedCategoryIds = array_map('intval', $selectedCategoryIds);
                            if ($selectedCategoryIds === [] && $edit && data_get($application, 'gallery_category_id')) {
                                $selectedCategoryIds = [(int) $application->gallery_category_id];
                            }
                        @endphp

                        <label for="app-category" class="form-label">Gallery Categories</label>

                        <div id="adm-app-cat-dd" class="dropdown adm-cat-dd w-100" data-bs-auto-close="outside">
                            <button type="button"
                                class="dropdown-toggle adm-cat-dd__toggle"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true"
                                aria-controls="adm-app-cat-dd-panel">
                                <span class="adm-cat-dd__label-text is-placeholder" data-adm-cat-label>
                                    Select categories…
                                </span>
                                <i class="bi bi-chevron-down adm-cat-dd__chev" aria-hidden="true"></i>
                            </button>

                            <div id="adm-app-cat-dd-panel" class="dropdown-menu adm-cat-dd__menu w-100">
                                <div class="adm-cat-dd__head border-bottom py-2 px-3">
                                    Choose one or more
                                </div>

                                @if ($categories->isEmpty())
                                    <div class="adm-cat-dd__empty">No gallery categories yet.</div>
                                @else
                                    <div class="adm-cat-dd__scroll">
                                        @foreach ($categories as $cat)
                                            <div class="adm-cat-dd__item">
                                                <div class="form-check">
                                                    <input class="form-check-input adm-cat-dd__cb"
                                                        type="checkbox" name="gallery_category_ids[]" value="{{ $cat->id }}"
                                                        id="adm-app-cat-{{ $cat->id }}"
                                                        data-adm-cat-name="{{ e($cat->name) }}"
                                                        @checked(in_array((int) $cat->id, $selectedCategoryIds, true))>
                                                    <label class="form-check-label" for="adm-app-cat-{{ $cat->id }}">
                                                        {{ $cat->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="adm-cat-dd__foot border-top py-2 px-3 d-flex justify-content-end">
                                        <button type="button"
                                            class="btn btn-link btn-sm text-decoration-none p-0 adm-muted"
                                            id="adm-app-cat-dd-clear" style="font-size: 0.8125rem;">
                                            Clear selection
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @error('gallery_category_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-4 adm-sidebar-col">
            <section class="adm-card">
                <h2 class="adm-card__title">Feature image</h2>
                <div class="adm-card__body">
                    <p class="small adm-muted mb-2">Shown as the card cover on the homepage applications rail when set.
                        JPG, PNG, WebP, GIF or SVG, max 2&nbsp;MB.</p>
                    <input type="file" name="feature_image" class="form-control" accept="image/*">
                    @if ($edit && data_get($application, 'feature_image'))
                        <div class="mt-3 d-flex flex-wrap align-items-center gap-3">
                            <img class="adm-thumb" src="{{ asset('storage/' . $application->feature_image) }}" alt="">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remove_feature_image"
                                    id="remove-application-feature-image" value="1"
                                    @checked(old('remove_feature_image'))>
                                <label class="form-check-label small" for="remove-application-feature-image">Remove feature image on save</label>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section class="adm-card">
                <h2 class="adm-card__title">Banner image</h2>
                <div class="adm-card__body">
                    <p class="small adm-muted mb-2">Optional wide background behind the applications section (first application with a banner is used).
                        Max 4&nbsp;MB.</p>
                    <input type="file" name="banner_image" class="form-control" accept="image/*">
                    @if ($edit && data_get($application, 'banner_image'))
                        <div class="mt-3 d-flex flex-wrap align-items-center gap-3">
                            <img class="adm-thumb" src="{{ asset('storage/' . $application->banner_image) }}" alt=""
                                style="max-width:100%;height:auto;max-height:120px;object-fit:cover;">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remove_banner_image"
                                    id="remove-application-banner-image" value="1"
                                    @checked(old('remove_banner_image'))>
                                <label class="form-check-label small" for="remove-application-banner-image">Remove banner image on save</label>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section class="adm-card">
                <h2 class="adm-card__title">Save</h2>
                <div class="adm-card__body">
                    <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                        <i class="bi bi-check-lg"></i>
                        {{ $edit ? 'Update application' : 'Create application' }}
                    </button>
                </div>
            </section>
        </div>
    </form>

@push('scripts')
    <script>
        (function() {
            var root = document.getElementById('adm-app-cat-dd');
            if (!root) return;

            var label = root.querySelector('[data-adm-cat-label]');
            var boxes = root.querySelectorAll('.adm-cat-dd__cb');
            var clearBtn = document.getElementById('adm-app-cat-dd-clear');

            function updateLabel() {
                var names = [];
                boxes.forEach(function(cb) {
                    if (cb.checked) names.push(cb.getAttribute('data-adm-cat-name') || '');
                });
                if (!label) return;
                label.classList.toggle('is-placeholder', names.length === 0);
                if (names.length === 0) {
                    label.textContent = 'Select categories…';
                    return;
                }
                if (names.length <= 3) {
                    label.textContent = names.join(', ');
                    return;
                }
                label.textContent = names.length + ' categories selected';
            }

            boxes.forEach(function(cb) {
                cb.addEventListener('change', updateLabel);
            });

            root.querySelectorAll('.adm-cat-dd__item').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    if (e.target.closest('input[type="checkbox"], label')) return;
                    var cb = item.querySelector('.adm-cat-dd__cb');
                    if (!cb) return;
                    cb.checked = !cb.checked;
                    updateLabel();
                });
            });

            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    boxes.forEach(function(cb) {
                        cb.checked = false;
                    });
                    updateLabel();
                });
            }

            updateLabel();
        })();
    </script>
@endpush
@endsection

