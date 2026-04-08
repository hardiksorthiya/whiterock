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
    </div>

    <div class="col-lg-4 adm-sidebar-col">
        <section class="adm-card">
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