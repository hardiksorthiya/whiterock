@extends('layouts.app')

@section('page_title', 'Products')
@section('page_subtitle', 'Manage your products here')

@section('content')
    @php($bulkFormId = 'product-bulk-form')

   
        <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
            <a href="{{ route('backend.products.create') }}" class="adm-btn adm-btn--primary">
                <i class="bi bi-plus-lg"></i> Add product
            </a>

            <form method="GET" action="{{ route('backend.products.index') }}"
                class="d-flex gap-2 align-items-center ms-auto" style="max-width: min(100%, 40rem);">
                <input type="search" name="search" class="form-control" placeholder="Search by name…"
                    value="{{ old('search', request('search')) }}" aria-label="Search products">
                <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
                @if (request()->filled('search'))
                    <a href="{{ route('backend.products.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
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
            @if ($products->isEmpty())
                <p class="adm-empty">
                    @if (request()->filled('search'))
                        No products match your search.
                        <a href="{{ route('backend.products.index') }}">Clear search</a>
                    @else
                        No products yet. <a href="{{ route('backend.products.create') }}">Create the first one</a>.
                    @endif
                </p>
            @else
                <form id="{{ $bulkFormId }}" method="POST" action="{{ route('backend.products.bulk-action') }}"
                    class="p-3 pb-0 border-bottom border-light">
                    @csrf
                    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                        <label class="visually-hidden" for="bulk-action">Bulk action</label>
                        <select name="action" id="bulk-action" class="form-select" style="max-width: 14rem;">
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
                                <th>Categories</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item" name="product_ids[]"
                                            value="{{ $product->id }}" form="{{ $bulkFormId }}">
                                    </td>
                                    <td><span
                                            class="adm-badge">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</span>
                                    </td>
                                    <td>
                                        @if ($product->featured_image)
                                            <img src="{{ asset('storage/' . $product->featured_image) }}" alt=""
                                                class="adm-thumb adm-thumb--sm rounded">
                                        @else
                                            <span class="adm-muted small">—</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>{{ $product->categories->pluck('name')->join(', ') ?: '—' }}</td>
                                    <td>
                                        @if ($product->is_featured)
                                            <span class="adm-badge" title="Featured product">★ Featured</span>
                                        @else
                                            <span class="adm-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->is_active)
                                            <span class="adm-badge adm-badge-success">Active</span>
                                        @else
                                            <span class="adm-badge adm-badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="adm-actions justify-content-end">
                                            @if ($product->is_active)
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="adm-btn adm-btn--ghost adm-btn--sm"
                                                    target="_blank" rel="noopener noreferrer"
                                                    title="Open product page in a new tab">View</a>
                                            @endif
                                            <a href="{{ route('backend.products.edit', $product) }}"
                                                class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                            <form action="{{ route('backend.products.destroy', $product) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this product?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="adm-btn adm-btn--danger adm-btn--sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="adm-pager">{{ $products->links() }}</div>
            @endif
        </div>
@endsection

@push('scripts')
    <script>
        (function() {
            var form = document.getElementById(@json($bulkFormId));
            if (!form) return;
            form.addEventListener('submit', function(e) {
                var action = form.querySelector('[name="action"]');
                if (!action || !action.value) {
                    e.preventDefault();
                    alert('Choose a bulk action.');
                    return;
                }
                /* Checkboxes use form="…" and live in the table, not inside <form>, so query the document/table */
                var n = document.querySelectorAll('.adm-table .select-item:checked').length;
                if (!n) {
                    e.preventDefault();
                    alert('Select at least one product.');
                    return;
                }
                if (action.value === 'delete' && !confirm('Delete ' + n +
                    ' product(s)? This cannot be undone.')) {
                    e.preventDefault();
                }
            });
        })();
    </script>
@endpush
