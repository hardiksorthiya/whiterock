@extends('layouts.app')

@php
    $edit = (bool) $service;
@endphp

@section('page_title', $edit ? 'Edit Service' : 'New Service')
@section('page_subtitle', $edit ? 'Update service details' : 'Create a new service')

@section('content')

@if ($errors->any())
    <div class="adm-alert adm-alert--err">
        @foreach ($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

<form method="POST"
    action="{{ $edit ? route('backend.services.update', $service->id) : route('backend.services.store') }}"
    class="row g-4"
    enctype="multipart/form-data">

    @csrf
    @if ($edit) @method('PUT') @endif

    <div class="col-lg-8">

        <section class="adm-card">
            <h2 class="adm-card__title">Service Details</h2>

            <div class="adm-card__body">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required
                        value="{{ old('title', data_get($service, 'title')) }}">
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', data_get($service, 'description')) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="button_text">Button label</label>
                    <input type="text" name="button_text" id="button_text" class="form-control" maxlength="120"
                        placeholder="e.g. View products, Learn more"
                        value="{{ old('button_text', data_get($service, 'button_text')) }}">
                    <p class="small adm-muted mb-0 mt-1">Shown on the home services card when a link is set. Defaults to “Learn more” if empty.</p>
                </div>

                <div class="mb-0">
                    <label for="button_url">Button link</label>
                    <input type="text" name="button_url" id="button_url" class="form-control" maxlength="500"
                        placeholder="https://… or /products"
                        value="{{ old('button_url', data_get($service, 'button_url')) }}">
                    <p class="small adm-muted mb-0 mt-1">Full URL, site path (e.g. <code>/products</code>), <code>mailto:</code>, or <code>tel:</code>. Leave empty to hide the button.</p>
                </div>

            </div>
        </section>

    </div>

    <div class="col-lg-4 adm-sidebar-col">

        <section class="adm-card">
            <h2 class="adm-card__title">Icon</h2>
            <div class="adm-card__body">
                <p class="small adm-muted mb-2">Square image works best for icons.</p>
                <input type="file" name="icon" class="form-control" accept="image/*" {{ $edit ? '' : 'required' }}>

                @if ($edit && data_get($service, 'icon'))
                    <div class="mt-3">
                        <p class="small fw-semibold mb-2">Current icon</p>
                        <img src="{{ asset('storage/' . $service->icon) }}" alt="" width="80" class="rounded">
                    </div>
                @endif
            </div>
        </section>

        <section class="adm-card mt-3">
            <h2 class="adm-card__title">Background Image</h2>
            <div class="adm-card__body">
                <p class="small adm-muted mb-2">Optional image for featured-style cards.</p>
                <input type="file" name="background_image" class="form-control" accept="image/*">

                @if ($edit && data_get($service, 'background_image'))
                    <div class="mt-3">
                        <p class="small fw-semibold mb-2">Current background</p>
                        <img src="{{ asset('storage/' . $service->background_image) }}" alt="" width="120" class="rounded">
                    </div>
                @endif
            </div>
        </section>

        <section class="adm-card mt-3">
            <h2 class="adm-card__title">Status</h2>
            <div class="adm-card__body">
                @php
                    $isActiveSelected = old('is_active', $edit ? (data_get($service, 'is_active') ? '1' : '0') : '1');
                @endphp
                <div class="mb-0">
                    <label class="form-label" for="is_active">Active / Inactive</label>
                    <select name="is_active" id="is_active" class="form-select" required>
                        <option value="1" @selected((string) $isActiveSelected === '1')>Active</option>
                        <option value="0" @selected((string) $isActiveSelected === '0')>Inactive</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="adm-card mt-3">
            <div class="adm-card__body">
                <button type="submit" class="adm-btn adm-btn--primary w-100">
                    {{ $edit ? 'Update Service' : 'Create Service' }}
                </button>
            </div>
        </section>

    </div>

</form>

@endsection
