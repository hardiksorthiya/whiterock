@extends('layouts.app')

@section('page_title', 'About Page')
@section('page_subtitle', 'Manage about page content')

@section('content')

@if ($errors->any())
    <div class="adm-alert adm-alert--err">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

@if (session('success'))
    <div class="adm-alert adm-alert--ok">{{ session('success') }}</div>
@endif

@php
    $slideRows = old('slides');
    if (! is_array($slideRows)) {
        $slideRows = ($about && is_array($about->about_feature_slides)) ? $about->about_feature_slides : [];
    }
    if (count($slideRows) === 0) {
        $slideRows[] = ['title' => '', 'card_media_type' => 'image', 'popup_video_url' => '', 'card_media' => ''];
    }
@endphp

<form method="POST" action="{{ route('backend.about.update') }}" enctype="multipart/form-data" class="row g-4">
    @csrf

    <div class="col-lg-8">
        <section class="adm-card">
            <h2 class="adm-card__title">Founder Information</h2>
            <div class="adm-card__body">
                <div class="mb-3">
                    <label>Founder Name</label>
                    <input type="text" name="founder_name" class="form-control"
                        value="{{ old('founder_name', $about->founder_name ?? '') }}">
                </div>

                <div class="mb-3">
                    <label>Designation</label>
                    <input type="text" name="founder_designation" class="form-control"
                        value="{{ old('founder_designation', $about->founder_designation ?? '') }}">
                </div>

                <div class="mb-0">
                    <label>Founder Description</label>
                    <textarea name="founder_description" id="founder_description" class="form-control" rows="4">{{ old('founder_description', $about->founder_description ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <section class="adm-card mt-3">
            <h2 class="adm-card__title">About Content</h2>
            <div class="adm-card__body">
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $about->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Mission</label>
                    <textarea name="mission" class="form-control" rows="4">{{ old('mission', $about->mission ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Vision</label>
                    <textarea name="vision" class="form-control" rows="4">{{ old('vision', $about->vision ?? '') }}</textarea>
                </div>

                <div class="mb-0">
                    <label>Values</label>
                    <textarea name="values" class="form-control" rows="4">{{ old('values', $about->values ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <section class="adm-card mt-3">
            <h2 class="adm-card__title">About page — feature slides</h2>
            <div class="adm-card__body">
                <p class="small text-muted mb-3">
                    Cards shown in the horizontal slider on the About page. Upload a still image, GIF, or a short preview video for each slide.
                    For “Watch now”, upload an MP4/WebM below <strong>or</strong> paste a YouTube URL (uploaded file is used first if both are set).
                </p>
                <div id="about-feature-slide-rows" class="d-flex flex-column gap-3">
                    @foreach ($slideRows as $idx => $slide)
                        <div class="border rounded p-3 position-relative about-feature-slide-row">
                            <button type="button"
                                class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 about-feature-remove-slide {{ count($slideRows) <= 1 ? 'd-none' : '' }}"
                                title="Remove slide">&times;</button>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Title (bottom overlay)</label>
                                    <input type="text" name="slides[{{ $idx }}][title]" class="form-control"
                                        value="{{ old('slides.'.$idx.'.title', $slide['title'] ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Card media type</label>
                                    @php $cmt = old('slides.'.$idx.'.card_media_type', $slide['card_media_type'] ?? 'image'); @endphp
                                    <select name="slides[{{ $idx }}][card_media_type]" class="form-select">
                                        <option value="image" @selected($cmt === 'image')>Image or GIF</option>
                                        <option value="video" @selected($cmt === 'video')>Video preview (loops silently)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Card media file</label>
                                    <input type="file" name="slides[{{ $idx }}][card_media]" class="form-control"
                                        accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/webm">
                                    @php
                                        $existing = old('slides.'.$idx.'.card_media_existing', $slide['card_media'] ?? '');
                                    @endphp
                                    <input type="hidden" name="slides[{{ $idx }}][card_media_existing]" value="{{ $existing }}">
                                    @if (! empty($existing))
                                        <p class="small mt-2 mb-0 text-muted">Current file: <code>{{ $existing }}</code></p>
                                        @if (! str_contains($existing, 'http') && preg_match('/\.(jpe?g|png|gif|webp)$/i', $existing))
                                            <img src="{{ asset('storage/' . $existing) }}" alt="" class="rounded mt-2" style="max-height:80px;max-width:100%;object-fit:cover;" loading="lazy">
                                        @endif
                                        @if (str_starts_with($existing, 'about_feature_slides/'))
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="slides[{{ $idx }}][card_media_remove]" value="1"
                                                    id="card_remove_{{ $idx }}" {{ old('slides.'.$idx.'.card_media_remove') ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="card_remove_{{ $idx }}">Remove uploaded card media</label>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Popup modal video (upload)</label>
                                    <input type="file" name="slides[{{ $idx }}][popup_video]" class="form-control"
                                        accept="video/mp4,video/webm">
                                    @php
                                        $existingPopup = old('slides.'.$idx.'.popup_video_path_existing', $slide['popup_video_path'] ?? '');
                                    @endphp
                                    <input type="hidden" name="slides[{{ $idx }}][popup_video_path_existing]" value="{{ $existingPopup }}">
                                    @if (! empty($existingPopup))
                                        <p class="small mt-2 mb-0 text-muted">Current popup file: <code>{{ $existingPopup }}</code></p>
                                        @if (str_starts_with($existingPopup, 'about_feature_popup_videos/'))
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="slides[{{ $idx }}][popup_video_remove]" value="1"
                                                    id="popup_remove_{{ $idx }}" {{ old('slides.'.$idx.'.popup_video_remove') ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="popup_remove_{{ $idx }}">Remove uploaded popup video</label>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Popup video URL (optional)</label>
                                    <input type="text" name="slides[{{ $idx }}][popup_video_url]" class="form-control"
                                        value="{{ old('slides.'.$idx.'.popup_video_url', $slide['popup_video_url'] ?? '') }}"
                                        placeholder="YouTube watch/embed URL, or leave blank if you uploaded above">
                                    <p class="small text-muted mt-1 mb-0">Used when no popup file is uploaded (or after removal).</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-3" id="about-feature-add-slide">Add slide</button>
            </div>
        </section>
    </div>

    <div class="col-lg-4 adm-sidebar-col">
        <section class="adm-card">
            <h2 class="adm-card__title">About Section Image</h2>
            <div class="adm-card__body">
                <input type="file" name="about_image" class="form-control" accept="image/*">

                @if (! empty($about->about_image))
                    <div class="mt-3">
                        <p class="small fw-semibold mb-2">Current image</p>
                        <img src="{{ asset('storage/' . $about->about_image) }}" alt="About section image" width="140" class="rounded">
                    </div>
                @endif
            </div>
        </section>

        <section class="adm-card mt-3">
            <h2 class="adm-card__title">Founder Image</h2>
            <div class="adm-card__body">
                <input type="file" name="founder_image" class="form-control" accept="image/*">

                @if (! empty($about->founder_image))
                    <div class="mt-3">
                        <p class="small fw-semibold mb-2">Current image</p>
                        <img src="{{ asset('storage/' . $about->founder_image) }}" alt="Founder image" width="120" class="rounded">
                    </div>
                @endif
            </div>
        </section>

        <section class="adm-card mt-3">
            <div class="adm-card__body">
                <button type="submit" class="adm-btn adm-btn--primary w-100">Save About Content</button>
            </div>
        </section>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof CKEDITOR === 'undefined') return;

        if (document.getElementById('founder_description')) {
            CKEDITOR.replace('founder_description');
        }
        if (document.getElementById('description')) {
            CKEDITOR.replace('description');
        }

        const slideRows = document.getElementById('about-feature-slide-rows');
        const addBtn = document.getElementById('about-feature-add-slide');

        function slideRowTemplate(index) {
            return (
                '<div class="border rounded p-3 position-relative about-feature-slide-row">' +
                '<button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 about-feature-remove-slide" title="Remove slide">&times;</button>' +
                '<div class="row g-3">' +
                '<div class="col-md-6"><label class="form-label small text-muted mb-1">Title (bottom overlay)</label>' +
                '<input type="text" name="slides[' + index + '][title]" class="form-control" value=""></div>' +
                '<div class="col-md-6"><label class="form-label small text-muted mb-1">Card media type</label>' +
                '<select name="slides[' + index + '][card_media_type]" class="form-select">' +
                '<option value="image" selected>Image or GIF</option><option value="video">Video preview (loops silently)</option></select></div>' +
                '<div class="col-md-6"><label class="form-label small text-muted mb-1">Card media file</label>' +
                '<input type="file" name="slides[' + index + '][card_media]" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/webm">' +
                '<input type="hidden" name="slides[' + index + '][card_media_existing]" value=""></div>' +
                '<div class="col-md-6"><label class="form-label small text-muted mb-1">Popup modal video (upload)</label>' +
                '<input type="file" name="slides[' + index + '][popup_video]" class="form-control" accept="video/mp4,video/webm">' +
                '<input type="hidden" name="slides[' + index + '][popup_video_path_existing]" value=""></div>' +
                '<div class="col-md-6"><label class="form-label small text-muted mb-1">Popup video URL (optional)</label>' +
                '<input type="text" name="slides[' + index + '][popup_video_url]" class="form-control" placeholder="YouTube URL"></div>' +
                '</div></div>'
            );
        }

        function renumberSlideRemoveButtons() {
            if (!slideRows) return;
            const rows = slideRows.querySelectorAll('.about-feature-slide-row');
            rows.forEach(function (row) {
                const btn = row.querySelector('.about-feature-remove-slide');
                if (!btn) return;
                btn.classList.toggle('d-none', rows.length <= 1);
            });
        }

        if (addBtn && slideRows) {
            addBtn.addEventListener('click', function () {
                const idx = slideRows.querySelectorAll('.about-feature-slide-row').length;
                slideRows.insertAdjacentHTML('beforeend', slideRowTemplate(idx));
                renumberSlideRemoveButtons();
            });
        }

        if (slideRows) {
            slideRows.addEventListener('click', function (e) {
                const t = e.target;
                if (!t.classList.contains('about-feature-remove-slide')) return;
                const row = t.closest('.about-feature-slide-row');
                const rows = slideRows.querySelectorAll('.about-feature-slide-row');
                if (rows.length <= 1) return;
                if (row) row.remove();
                renumberSlideRemoveButtons();
            });
            renumberSlideRemoveButtons();
        }
    });
</script>

@endsection


<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof CKEDITOR !== 'undefined' && document.getElementById('editor')) {
            CKEDITOR.replace('editor');
        }

        const layoutSelect = document.getElementById('layout');
        const faqFields = document.getElementById('faq-layout-fields');
        const faqRows = document.getElementById('faqRows');
        const addFaqRowBtn = document.getElementById('addFaqRow');

        function toggleLayoutFields() {
            const isFaq = layoutSelect && layoutSelect.value === 'faq';
            if (faqFields) faqFields.classList.toggle('d-none', !isFaq);
        }

        function faqRowCount() {
            return faqRows ? faqRows.querySelectorAll('.faq-row').length : 0;
        }

        function bindRemoveFaqRow(row) {
            const btn = row.querySelector('.remove-faq-row');
            if (!btn) return;
            btn.addEventListener('click', function () {
                if (faqRowCount() <= 1) {
                    row.querySelectorAll('input, textarea').forEach(function (el) {
                        el.value = '';
                    });
                    return;
                }
                row.remove();
            });
        }

        if (faqRows) {
            faqRows.querySelectorAll('.faq-row').forEach(bindRemoveFaqRow);
        }

        if (addFaqRowBtn && faqRows) {
            addFaqRowBtn.addEventListener('click', function () {
                const idx = faqRowCount();
                const row = document.createElement('div');
                row.className = 'border rounded p-3 position-relative faq-row';
                row.innerHTML =
                    '<button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 remove-faq-row" title="Remove" aria-label="Remove question">&times;</button>' +
                    '<div class="mb-2"><label class="form-label small text-muted mb-0">Question</label>' +
                    '<input type="text" name="faq_items[' + idx + '][question]" class="form-control" value=""></div>' +
                    '<div class="mb-0"><label class="form-label small text-muted mb-0">Answer</label>' +
                    '<textarea name="faq_items[' + idx + '][answer]" class="form-control" rows="3"></textarea></div>';
                faqRows.appendChild(row);
                bindRemoveFaqRow(row);
            });
        }

        if (layoutSelect) {
            layoutSelect.addEventListener('change', toggleLayoutFields);
            toggleLayoutFields();
        }
    });
</script>