@extends('layouts.app')

@php($edit = (bool) ($feature ?? null))

@section('page_title', $edit ? 'Edit product feature' : 'New product feature')
@section('page_subtitle', $edit ? 'Update title and image' : 'Add a reusable highlight for products')

@section('content')
    @if ($errors->any())
        <div class="adm-alert adm-alert--err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST"
        action="{{ $edit ? route('backend.product-features.update', $feature->id) : route('backend.product-features.store') }}"
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
                        <label for="pf-title">Title</label>
                        <input id="pf-title" type="text" name="title" class="form-control" required maxlength="255"
                            value="{{ old('title', data_get($feature, 'title')) }}">
                    </div>
                    <div class="adm-fld">
                        <label for="pf-sort">Sort order</label>
                        <input id="pf-sort" type="number" name="sort_order" class="form-control" min="0" max="99999"
                            value="{{ old('sort_order', data_get($feature, 'sort_order', 0)) }}">
                        <p class="small adm-muted mb-0 mt-1">Lower numbers appear first when multiple features are selected on a product.</p>
                    </div>
                </div>
            </section>

            <section class="adm-card">
                <h2 class="adm-card__title">Image</h2>
                <div class="adm-card__body">
                    <p class="small adm-muted mb-2">Square or transparent PNG works best for icons. Max 2&nbsp;MB.</p>
                    <input type="file" name="image" class="form-control" accept="image/*" @if (!$edit) required @endif>
                    @if ($edit && data_get($feature, 'image'))
                        <div class="mt-3">
                            <span class="small adm-muted d-block mb-1">Current image</span>
                            <img src="{{ asset('storage/' . $feature->image) }}" alt="" class="adm-thumb"
                                style="max-height:120px;object-fit:contain;">
                        </div>
                    @endif
                </div>
            </section>

            <button type="submit" class="adm-btn adm-btn--primary">
                <i class="bi bi-check-lg"></i> {{ $edit ? 'Update feature' : 'Save feature' }}
            </button>
        </div>
    </form>
@endsection
