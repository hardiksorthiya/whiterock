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

                <div class="mb-0">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', data_get($service, 'description')) }}</textarea>
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
