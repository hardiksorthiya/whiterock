@extends('layouts.app')

@php
    $edit = (bool) ($catalogue ?? null);
@endphp

@section('page_title', $edit ? 'Edit catalogue' : 'New catalogue')
@section('page_subtitle', $edit ? 'Update catalogue details' : 'Add a new catalogue PDF')

@section('content')
    @if ($errors->any())
        <div class="adm-alert adm-alert--err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ $edit ? route('backend.catalogues.update', $catalogue->id) : route('backend.catalogues.store') }}"
        enctype="multipart/form-data" class="row g-4">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="col-lg-8">
            <section class="adm-card">
                <h2 class="adm-card__title">Details</h2>
                <div class="adm-card__body">
                    <div class="adm-fld">
                        <label for="catalogue-name">Name</label>
                        <input id="catalogue-name" type="text" name="name" class="form-control"
                            value="{{ old('name', data_get($catalogue, 'name')) }}" required>
                    </div>
                    <div class="adm-fld">
                        <label for="catalogue-category">Category</label>
                        <select id="catalogue-category" name="category_id" class="form-select" required>
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @selected((int) old('category_id', data_get($catalogue, 'category_id')) === (int) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section class="adm-card">
                <h2 class="adm-card__title">Featured image</h2>
                <div class="adm-card__body">
                    <p class="small adm-muted mb-2">Optional cover image for lists and previews. JPG, PNG, WebP, GIF or SVG, max 2&nbsp;MB.</p>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                    @if ($edit && data_get($catalogue, 'featured_image'))
                        <div class="mt-3 d-flex flex-wrap align-items-center gap-3">
                            <img class="adm-thumb" src="{{ asset('storage/' . $catalogue->featured_image) }}" alt="">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remove_featured_image" id="remove-featured-image" value="1"
                                    @checked(old('remove_featured_image'))>
                                <label class="form-check-label small" for="remove-featured-image">Remove featured image on save</label>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section class="adm-card">
                <h2 class="adm-card__title">Catalogue PDF</h2>
                <div class="adm-card__body">
                    <input type="file" name="pdf" class="form-control" accept="application/pdf,.pdf"
                        @required(! $edit)>
                    <p class="small adm-muted mt-2 mb-0">
                        {{ $edit ? 'Upload a new PDF only if you want to replace the current one.' : 'PDF file is required.' }}
                    </p>
                    @if ($edit && data_get($catalogue, 'pdf'))
                        <a href="{{ asset('storage/' . $catalogue->pdf) }}" class="adm-btn adm-btn--ghost adm-btn--sm mt-2"
                            target="_blank" rel="noopener noreferrer">View current PDF</a>
                    @endif
                </div>
            </section>
        </div>

        <div class="col-lg-4 adm-sidebar-col">
            <section class="adm-card">
                <h2 class="adm-card__title">Status</h2>
                <div class="adm-card__body">
                    <select name="is_active" class="form-select">
                        <option value="1" @selected((int) old('is_active', data_get($catalogue, 'is_active', 1)) === 1)>Active</option>
                        <option value="0" @selected((int) old('is_active', data_get($catalogue, 'is_active', 1)) === 0)>Inactive</option>
                    </select>
                </div>
            </section>

            <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                <i class="bi bi-check-lg"></i> {{ $edit ? 'Update catalogue' : 'Save catalogue' }}
            </button>
        </div>
    </form>
@endsection
