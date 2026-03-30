@extends('layouts.app')

@php
    $edit = (bool) ($category ?? null);
@endphp

@section('page_title', $edit ? 'Edit gallery category' : 'New gallery category')
@section('page_subtitle', $edit ? 'Update category name and add images' : 'Create a new gallery category')

@section('content')
    @if ($errors->any())
        <div class="adm-alert adm-alert--err">
            @foreach ($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST"
        action="{{ $edit ? route('backend.gallery.update', $category->id) : route('backend.gallery.store') }}"
        class="row g-4" enctype="multipart/form-data">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="col-lg-8">
            <section class="adm-card">
                <h2 class="adm-card__title">Details</h2>
                <div class="adm-card__body">
                    <div class="mb-3">
                        <label for="cat-name" class="form-label">Name</label>
                        <input type="text" id="cat-name" name="name" class="form-control" required
                            value="{{ old('name', data_get($category, 'name')) }}">
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-4 adm-sidebar-col">
            <section class="adm-card">
                <h2 class="adm-card__title">Images</h2>
                <div class="adm-card__body">
                    <p class="small adm-muted mb-2">Upload images to display under this category.</p>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple {{ $edit ? '' : 'required' }}>

                    @if ($edit && $category->images->isNotEmpty())
                        <p class="small fw-semibold mt-3 mb-2">Current images</p>
                        <p class="small adm-muted mt-0 mb-3">Tick “Remove” for images you want to delete when you save.</p>
                        <div class="row g-2">
                            @foreach ($category->images as $galleryImage)
                                <div class="col-6">
                                    <div class="border rounded p-2 h-100">
                                        <img src="{{ asset('storage/' . $galleryImage->image) }}" alt=""
                                            class="img-fluid rounded mb-2"
                                            style="aspect-ratio: 1; max-height: 110px; object-fit: cover; width: 100%;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="remove_gallery_image_ids[]"
                                                value="{{ $galleryImage->id }}"
                                                id="rm-gallery-img-{{ $galleryImage->id }}">
                                            <label class="form-check-label small"
                                                for="rm-gallery-img-{{ $galleryImage->id }}">Remove</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section class="adm-card mt-3">
                <h2 class="adm-card__title">Save</h2>
                <div class="adm-card__body">
                    <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                        <i class="bi bi-check-lg"></i>
                        {{ $edit ? 'Update category' : 'Create category' }}
                    </button>
                </div>
            </section>
        </div>
    </form>
@endsection

