@extends('layouts.app')

@php
    $edit = (bool) $product;
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
                <section class="adm-card">
                    <h2 class="adm-card__title">Category</h2>
                    <div class="adm-card__body">
                        <select name="category_id" class="form-select">
                            <option value="">
                                @if($defaultCategory ?? null)
                                    Optional — default: “{{ $defaultCategory->name }}”
                                @else
                                    Select category (set a default in Categories)
                                @endif
                            </option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected((string) old('category_id', $edit ? $product->category_id : '') === (string) $cat->id)>
                                    {{ $cat->name }}{{ ($defaultCategory ?? null) && $defaultCategory->id === $cat->id ? ' ★' : '' }}
                                </option>
                            @endforeach
                        </select>
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
                    </div>
                </section>

                <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                    <i class="bi bi-check-lg"></i> {{ $edit ? 'Update product' : 'Save product' }}
                </button>
            </div>
        </div>
    </form>
@endsection
