@extends('layouts.app')

@php
    $edit = (bool) $category;
@endphp
 
@section('page_title', $edit ? 'Edit catalogue category' : 'New catalogue category')
@section('page_subtitle', $edit ? 'Update catalogue category details' : 'Add a catalogue category')
@section('content')

    @if ($errors->any())
        <div class="adm-alert adm-alert--err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST"
    action="{{ $edit ? route('backend.catalogue-categories.update', $category->id) : route('backend.catalogue-categories.store') }}"
    enctype="multipart/form-data" class="row g-4">
    @csrf
    @if ($edit) @method('PUT') @endif

    <div class="col-lg-8">
        <section class="adm-card">
            <h2 class="adm-card__title">Details</h2>
            <div class="adm-card__body">
                <div class="adm-fld">
                    <label for="cat-name">Name</label>
                    <input id="cat-name" type="text" name="name" class="form-control"
                        value="{{ old('name', data_get($category, 'name')) }}" required>
                </div>
                <div class="adm-fld">
                    <label for="cat-slug">Slug</label>
                    <input id="cat-slug" type="text" name="slug" class="form-control"
                        value="{{ old('slug', data_get($category, 'slug')) }}" required>
                </div>
            </div>
        </section>
    </div>

    <div class="col-lg-4 adm-sidebar-col">
        <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
            <i class="bi bi-check-lg"></i> {{ $edit ? 'Update catalogue category' : 'Save catalogue category' }}
        </button>
    </div>
</form>

@endsection
