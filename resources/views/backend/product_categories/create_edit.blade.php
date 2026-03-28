@extends('layouts.app')

@php
    $edit = (bool) $productCategory;
@endphp

@section('page_title', $edit ? 'Edit category' : 'New category')
@section('page_subtitle', $edit ? 'Update category details' : 'Add a product category')

@section('content')

    @if ($errors->any())
        <div class="adm-alert adm-alert--err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST"
        action="{{ $edit ? route('backend.product-categories.update', $productCategory->id) : route('backend.product-categories.store') }}"
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
                            value="{{ old('name', data_get($productCategory, 'name')) }}" required>
                    </div>
                    <div class="adm-fld">
                        <label for="cat-slug">Slug</label>
                        <input id="cat-slug" type="text" name="slug" class="form-control"
                            value="{{ old('slug', data_get($productCategory, 'slug')) }}" required>
                    </div>
                    <div class="adm-fld">
                        <input type="hidden" name="is_default" value="0">
                        <div class="form-check">
                            <input type="checkbox" name="is_default" value="1" class="form-check-input" id="defaultCategory"
                                @checked(old('is_default', data_get($productCategory, 'is_default') ? '1' : '0') == '1')>
                            <label class="form-check-label" for="defaultCategory">Default category (used when a product has no category)</label>
                        </div>
                    </div>
                </div>
            </section>

            <section class="adm-card">
                <h2 class="adm-card__title">Image</h2>
                <div class="adm-card__body">
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if ($edit && $productCategory->image)
                        <img class="adm-thumb mt-2" src="{{ asset('storage/'.$productCategory->image) }}" alt="">
                    @endif
                </div>
            </section>
        </div>

        <div class="col-lg-4 adm-sidebar-col">
            <section class="adm-card">
                <h2 class="adm-card__title">Status</h2>
                <div class="adm-card__body">
                    <select name="is_active" class="form-select">
                        <option value="1" @selected((int) old('is_active', data_get($productCategory, 'is_active', 1)) === 1)>Active</option>
                        <option value="0" @selected((int) old('is_active', data_get($productCategory, 'is_active', 1)) === 0)>Inactive</option>
                    </select>
                </div>
            </section>

            <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                <i class="bi bi-check-lg"></i> {{ $edit ? 'Update category' : 'Save category' }}
            </button>
        </div>
    </form>

@endsection
