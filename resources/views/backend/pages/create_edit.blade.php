@extends('layouts.app')

@php
    $edit = isset($page);
    $layoutValue = old('layout', $page->layout ?? 'default');
    $faqItems = old('faq_items', $page->faq_items ?? []);
    if (! is_array($faqItems) || count($faqItems) === 0) {
        $faqItems = [['question' => '', 'answer' => '']];
    }
@endphp

@section('page_title', $edit ? 'Edit Page' : 'Create Page')
@section('page_subtitle', $edit ? 'Update page details' : 'Add new page')

@section('content')

@if ($errors->any())
    <div class="adm-alert adm-alert--err">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST"
    action="{{ $edit ? route('backend.pages.update', $page->id) : route('backend.pages.store') }}"
    class="row g-4">

    @csrf
    @if($edit) @method('PUT') @endif

    <!-- LEFT -->
    <div class="col-lg-8">

        <!-- BASIC -->
        <section class="adm-card">
            <h2 class="adm-card__title">Page Details</h2>

            <div class="adm-card__body">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $page->title ?? '') }}">
                </div>

                <div class="mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control"
                        value="{{ old('slug', $page->slug ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="layout">Layout</label>
                    <select name="layout" id="layout" class="form-select" required>
                        <option value="default" @selected($layoutValue === 'default')>Default</option>
                        <option value="faq" @selected($layoutValue === 'faq')>FAQ</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" id="editor" class="form-control" rows="6">{{ old('description', $page->description ?? '') }}</textarea>
                </div>

                <div id="faq-layout-fields" class="{{ $layoutValue === 'faq' ? '' : 'd-none' }}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="mb-0">Questions & Answers</label>
                        <button type="button" class="adm-btn adm-btn--ghost adm-btn--sm" id="addFaqRow">
                            <i class="bi bi-plus-lg"></i> Add Q&A
                        </button>
                    </div>

                    <div id="faqRows" class="d-flex flex-column gap-3">
                        @foreach ($faqItems as $i => $item)
                            <div class="border rounded p-3 position-relative faq-row">
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 remove-faq-row"
                                    title="Remove" aria-label="Remove question">&times;</button>
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-0">Question</label>
                                    <input type="text" name="faq_items[{{ $i }}][question]" class="form-control"
                                        value="{{ old('faq_items.' . $i . '.question', $item['question'] ?? '') }}">
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small text-muted mb-0">Answer</label>
                                    <textarea name="faq_items[{{ $i }}][answer]" class="form-control" rows="3">{{ old('faq_items.' . $i . '.answer', $item['answer'] ?? '') }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- SEO -->
        <section class="adm-card mt-3">
            <h2 class="adm-card__title">SEO Settings</h2>

            <div class="adm-card__body">

                <div class="mb-3">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" class="form-control"
                        value="{{ old('meta_title', $page->meta_title ?? '') }}">
                </div>

                <div class="mb-3">
                    <label>Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">
                        {{ old('meta_description', $page->meta_description ?? '') }}
                    </textarea>
                </div>

                <div class="mb-3">
                    <label>Keywords</label>
                    <input type="text" name="keywords" class="form-control"
                        value="{{ old('keywords', $page->keywords ?? '') }}">
                </div>

            </div>
        </section>

    </div>

    <!-- RIGHT -->
    <div class="col-lg-4">

        <section class="adm-card">
            <h2 class="adm-card__title">Status</h2>

            <div class="adm-card__body">
                @php
                    $isActiveSelected = old('is_active', $edit ? (($page->is_active ?? false) ? '1' : '0') : '1');
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
                <button class="adm-btn adm-btn--primary w-100">
                    {{ $edit ? 'Update Page' : 'Create Page' }}
                </button>
            </div>
        </section>

    </div>

</form>

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

@endsection