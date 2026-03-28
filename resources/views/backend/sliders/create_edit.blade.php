@extends('layouts.app')

@php
    $edit = (bool) $slider;
@endphp

@section('page_title', $edit ? 'Edit Slider' : 'New Slider')
@section('page_subtitle', $edit ? 'Update slider details' : 'Create a new slider')

@section('content')

@if ($errors->any())
    <div class="adm-alert adm-alert--err">
        @foreach ($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

<form method="POST" 
    action="{{ $edit ? route('backend.sliders.update', $slider->id) : route('backend.sliders.store') }}" 
    class="row g-4" enctype="multipart/form-data">

    @csrf
    @if ($edit) @method('PUT') @endif

    <div class="col-lg-8">

        <!-- BASIC -->
        <section class="adm-card">
            <h2 class="adm-card__title">Slider Details</h2>

            <div class="adm-card__body">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', data_get($slider, 'title')) }}">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', data_get($slider, 'description')) }}</textarea>
                </div>

                <!-- IMAGE -->
                <div class="mb-3">
                    <label>Background Image</label>
                    <input type="file" name="image" class="form-control">

                    @if($edit && $slider->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$slider->image) }}" width="120" class="rounded">
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- BUTTON SETTINGS -->
        <section class="adm-card mt-3">
            <h2 class="adm-card__title">Button Settings</h2>

            <div class="adm-card__body">

                <div class="form-check mb-3">
                    <input type="checkbox" name="show_button" id="showButton"
                        class="form-check-input"
                        {{ old('show_button', data_get($slider, 'show_button')) ? 'checked' : '' }}>
                    <label class="form-check-label">Show Button</label>
                </div>

                <div id="buttonFields">
                    <div class="mb-3">
                        <label>Button Text</label>
                        <input type="text" name="button_text" class="form-control"
                            value="{{ old('button_text', data_get($slider, 'button_text')) }}">
                    </div>

                    <div class="mb-3">
                        <label>Button Link</label>
                        <input type="text" name="button_link" class="form-control"
                            value="{{ old('button_link', data_get($slider, 'button_link')) }}">
                    </div>
                </div>

            </div>
        </section>

        <!-- VIDEO SETTINGS -->
        <section class="adm-card mt-3">
            <h2 class="adm-card__title">Video Settings</h2>

            <div class="adm-card__body">

                <div class="form-check mb-3">
                    <input type="checkbox" name="show_video" id="showVideo"
                        class="form-check-input"
                        {{ old('show_video', data_get($slider, 'show_video')) ? 'checked' : '' }}>
                    <label class="form-check-label">Show Video Button</label>
                </div>

                <div id="videoFields">
                    <div class="mb-3">
                        <label>Video Link</label>
                        <input type="text" name="video_link" class="form-control"
                            value="{{ old('video_link', data_get($slider, 'video_link')) }}">
                    </div>
                </div>

            </div>
        </section>

    </div>

    <!-- RIGHT SIDE -->
    <div class="col-lg-4 adm-sidebar-col">

        <section class="adm-card">
            <h2 class="adm-card__title">Status</h2>
            <div class="adm-card__body">

                @php
                    $isActiveSelected = old('is_active', $edit ? (data_get($slider, 'is_active') ? '1' : '0') : '1');
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
            <h2 class="adm-card__title">Save</h2>
            <div class="adm-card__body">
                <button type="submit" class="adm-btn adm-btn--primary w-100">
                    {{ $edit ? 'Update Slider' : 'Create Slider' }}
                </button>
            </div>
        </section>

    </div>

</form>

@endsection

@push('scripts')
    <script>
        const showButtonCheckbox = document.querySelector('input[name="show_button"]');
        const buttonFields = document.getElementById('buttonFields');

        const showVideoCheckbox = document.querySelector('input[name="show_video"]');
        const videoFields = document.getElementById('videoFields');

        function toggleFields(checkbox, fields) {
            if (checkbox.checked) {
                fields.style.display = 'block';
            } else {
                fields.style.display = 'none';
            }
        }

        showButtonCheckbox.addEventListener('change', () => toggleFields(showButtonCheckbox, buttonFields));
        showVideoCheckbox.addEventListener('change', () => toggleFields(showVideoCheckbox, videoFields));

        // Initialize on page load
        toggleFields(showButtonCheckbox, buttonFields);
        toggleFields(showVideoCheckbox, videoFields);
    </script>
@endpush