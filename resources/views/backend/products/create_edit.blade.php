@extends('layouts.app')

@php
    $edit = (bool) $product;
    $selectedCategoryIds = old('category_ids', $edit ? $product->categories->pluck('id')->all() : []);
    if (! is_array($selectedCategoryIds)) {
        $selectedCategoryIds = [];
    }
    $selectedCategoryIds = array_map('intval', $selectedCategoryIds);
@endphp

@section('page_title', $edit ? 'Edit product' : 'New product')
@section('page_subtitle', $edit ? 'Update product details' : 'Add a product to your catalogue')

@section('content')
    @if ($errors->any())
        <div class="adm-alert adm-alert--err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ $edit ? route('backend.products.update', $product->id) : route('backend.products.store') }}" enctype="multipart/form-data">
        @csrf
        @if($edit) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-lg-8">
                @foreach ([
                    ['Basic', [
                        ['text', 'name', 'Product name'],
                        ['text', 'slug', 'Slug'],
                        ['text', 'sku', 'SKU'],
                    ]],
                    ['Description', [
                        ['area', 'short_description', 'Short description', 2],
                        ['area', 'long_description', 'Long description', 4],
                    ]],
                    ['SEO', [
                        ['text', 'meta_title', 'Meta title'],
                        ['area', 'meta_description', 'Meta description', 2],
                        ['text', 'keywords', 'Keywords'],
                    ]],
                ] as [$title, $fields])
                    <section class="adm-card">
                        <h2 class="adm-card__title">{{ $title }}</h2>
                        <div class="adm-card__body">
                            @foreach ($fields as $f)
                                <div class="adm-fld">
                                    <label for="f-{{ $f[1] }}">{{ $f[2] }}</label>
                                    @if ($f[0] === 'text')
                                        <input id="f-{{ $f[1] }}" type="text" name="{{ $f[1] }}" class="form-control"
                                            value="{{ old($f[1], data_get($product ?? [], $f[1])) }}">
                                    @else
                                        <textarea id="f-{{ $f[1] }}" name="{{ $f[1] }}" class="form-control" rows="{{ $f[3] }}">{{ old($f[1], data_get($product ?? [], $f[1])) }}</textarea>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>

            <div class="col-lg-4 adm-sidebar-col">
                <section class="adm-card adm-card--overflow-visible">
                    <h2 class="adm-card__title">Categories</h2>
                    <div class="adm-card__body">
                        <p class="small adm-muted mb-3">
                            @if($defaultCategory ?? null)
                                If none selected, “{{ $defaultCategory->name }}” is applied (★).
                            @else
                                If none selected, set a default under Product Categories.
                            @endif
                        </p>

                        <label class="visually-hidden" for="adm-cat-dd-btn">Product categories</label>
                        <div id="adm-product-cat-dd" class="dropdown adm-cat-dd w-100" data-bs-auto-close="outside">
                            <button type="button" id="adm-cat-dd-btn"
                                class="dropdown-toggle adm-cat-dd__toggle"
                                data-bs-toggle="dropdown"
                                aria-expanded="false" aria-haspopup="true" aria-controls="adm-cat-dd-panel">
                                <span class="adm-cat-dd__label-text is-placeholder" data-adm-cat-label>Select categories…</span>
                                <i class="bi bi-chevron-down adm-cat-dd__chev" aria-hidden="true"></i>
                            </button>
                            <div id="adm-cat-dd-panel" class="dropdown-menu adm-cat-dd__menu w-100">
                                <div class="adm-cat-dd__head border-bottom py-2 px-3">
                                    Choose one or more
                                </div>
                                @if ($categories->isEmpty())
                                    <div class="adm-cat-dd__empty">No categories yet. Create some under Product Categories.</div>
                                @else
                                    <div class="adm-cat-dd__scroll">
                                        @foreach ($categories as $cat)
                                            <div class="adm-cat-dd__item">
                                                <div class="form-check">
                                                    <input class="form-check-input adm-cat-dd__cb" type="checkbox"
                                                        name="category_ids[]" value="{{ $cat->id }}"
                                                        id="adm-cat-{{ $cat->id }}"
                                                        data-adm-cat-name="{{ e($cat->name) }}"
                                                        @checked(in_array((int) $cat->id, $selectedCategoryIds, true))>
                                                    <label class="form-check-label" for="adm-cat-{{ $cat->id }}">
                                                        {{ $cat->name }}
                                                        @if (($defaultCategory ?? null) && $defaultCategory->id === $cat->id)
                                                            <span class="text-muted small">★</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="adm-cat-dd__foot border-top py-2 px-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 adm-muted"
                                            id="adm-cat-dd-clear" style="font-size: 0.8125rem;">
                                            Clear selection
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>

                <section class="adm-card">
                    <h2 class="adm-card__title">Featured image</h2>
                    <div class="adm-card__body">
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                        @if($edit && $product->featured_image)
                            <img class="adm-thumb" src="{{ asset('storage/'.$product->featured_image) }}" alt="">
                        @endif
                    </div>
                </section>

                <section class="adm-card">
                    <h2 class="adm-card__title">Gallery</h2>
                    <div class="adm-card__body">
                        <p class="small adm-muted mb-2">Select multiple images to add at once (max 2MB each).</p>
                        <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>

                        @if ($edit && $product->images->isNotEmpty())
                            <p class="small fw-semibold mt-3 mb-2">Current gallery — check <strong>Remove</strong> to delete when you save</p>
                            <div class="row g-2">
                                @foreach ($product->images as $galleryImage)
                                    <div class="col-6 col-md-4">
                                        <div class="border rounded p-2 h-100">
                                            <img src="{{ asset('storage/'.$galleryImage->image) }}" alt=""
                                                class="img-fluid rounded mb-2 w-100" style="aspect-ratio: 1; max-height: 120px; object-fit: cover;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remove_gallery_ids[]"
                                                    value="{{ $galleryImage->id }}" id="rm-gallery-{{ $galleryImage->id }}">
                                                <label class="form-check-label small" for="rm-gallery-{{ $galleryImage->id }}">Remove</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>

                <section class="adm-card">
                    <h2 class="adm-card__title">Status</h2>
                    <div class="adm-card__body">
                        <select name="is_active" class="form-select">
                            <option value="1" @selected((int) old('is_active', $edit ? $product->is_active : 1) === 1)>Active</option>
                            <option value="0" @selected((int) old('is_active', $edit ? $product->is_active : 1) === 0)>Inactive</option>
                        </select>
                        <div class="form-check mt-3 pt-2 border-top border-light">
                            <input type="hidden" name="is_featured" value="0">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="f-is-featured" value="1"
                                @checked((int) old('is_featured', $edit && $product->is_featured ? 1 : 0) === 1)>
                            <label class="form-check-label" for="f-is-featured">
                                <span class="fw-semibold">Featured product</span>
                                <span class="d-block small adm-muted mt-1">Show in featured spots (e.g. homepage highlights). Uncheck for a normal listing.</span>
                            </label>
                        </div>
                    </div>
                </section>

                <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                    <i class="bi bi-check-lg"></i> {{ $edit ? 'Update product' : 'Save product' }}
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        (function() {
            var root = document.getElementById('adm-product-cat-dd');
            if (!root) return;
            var label = root.querySelector('[data-adm-cat-label]');
            var boxes = root.querySelectorAll('.adm-cat-dd__cb');
            var clearBtn = document.getElementById('adm-cat-dd-clear');

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
