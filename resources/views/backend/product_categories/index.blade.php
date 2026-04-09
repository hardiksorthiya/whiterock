@extends('layouts.app')

@section('page_title', 'Product categories')
@section('page_subtitle', 'Organize products by category')

@section('content')
@php($bulkFormId = 'category-bulk-form')


    <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
        <a href="{{ route('backend.product-categories.create') }}" class="adm-btn adm-btn--primary">
            <i class="bi bi-plus-lg"></i> Add category
        </a>

        <form method="GET" action="{{ route('backend.product-categories.index') }}"
            class="d-flex gap-2 align-items-center ms-auto" style="max-width: min(100%, 40rem);">
            <input type="search" name="search" class="form-control" placeholder="Search by name or slug…"
                value="{{ old('search', request('search')) }}" aria-label="Search categories">
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
            @if (request()->filled('search'))
                <a href="{{ route('backend.product-categories.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="adm-alert adm-alert--ok">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="adm-alert adm-alert--err">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="adm-alert adm-alert--err">
            @foreach ($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <div class="adm-table-wrap">
        @if ($productCategories->isEmpty())
            <p class="adm-empty">
                @if (request()->filled('search'))
                    No categories match your search.
                    <a href="{{ route('backend.product-categories.index') }}">Clear search</a>
                @else
                    No categories yet. <a href="{{ route('backend.product-categories.create') }}">Create the first one</a>.
                @endif
            </p>
        @else
            <form id="{{ $bulkFormId }}" method="POST" action="{{ route('backend.product-categories.bulk-action') }}"
                class="p-3 pb-0 border-bottom border-light">
                @csrf
                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                    <label class="visually-hidden" for="bulk-action-cat">Bulk action</label>
                    <select name="action" id="bulk-action-cat" class="form-select" style="max-width: 14rem;">
                        <option value="">Bulk actions…</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit" class="adm-btn adm-btn--ghost adm-btn--sm">Apply</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:2.5rem;"><input type="checkbox" id="select-all"
                                    aria-label="Select all on this page"></th>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCategories as $productCategory)
                            <tr>
                                <td>
                                    <input type="checkbox" class="select-item" name="category_ids[]"
                                        value="{{ $productCategory->id }}" form="{{ $bulkFormId }}">
                                </td>
                                <td><span
                                        class="adm-badge">{{ $loop->iteration + ($productCategories->currentPage() - 1) * $productCategories->perPage() }}</span>
                                </td>
                                <td>
                                    @if ($productCategory->image)
                                        <img src="{{ asset('storage/' . $productCategory->image) }}"
                                            alt="" class="adm-thumb adm-thumb--sm rounded">
                                    @else
                                        <span class="adm-muted small">—</span>
                                    @endif
                                </td>
                                <td><strong>{{ $productCategory->name }}</strong></td>
                                <td><span class="adm-muted small">{{ $productCategory->slug }}</span></td>
                                <td>
                                    <span class="adm-badge">{{ (int) ($productCategory->products_count ?? 0) }}</span>
                                </td>
                                <td>
                                    @if ($productCategory->is_active)
                                        <span class="adm-badge adm-badge-success">Active</span>
                                    @else
                                        <span class="adm-badge adm-badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="adm-actions justify-content-end">
                                        <a href="{{ route('backend.product-categories.edit', $productCategory) }}"
                                            class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                        <form action="{{ route('backend.product-categories.destroy', $productCategory) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this category? Products in this category may be removed depending on your database rules.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="adm-pager">{{ $productCategories->links() }}</div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
(function () {
    var form = document.getElementById(@json($bulkFormId));
    if (!form) return;
    form.addEventListener('submit', function (e) {
        var action = form.querySelector('[name="action"]');
        if (!action || !action.value) {
            e.preventDefault();
            alert('Choose a bulk action.');
            return;
        }
        var n = document.querySelectorAll('.adm-table .select-item:checked').length;
        if (!n) {
            e.preventDefault();
            alert('Select at least one category.');
            return;
        }
        if (action.value === 'delete' && !confirm('Delete ' + n + ' categor' + (n === 1 ? 'y' : 'ies') + '? Linked products may be deleted if the database is set to cascade.')) {
            e.preventDefault();
        }
    });
})();
</script>
@endpush
