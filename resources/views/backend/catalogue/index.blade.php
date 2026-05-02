@extends('layouts.app')

@section('page_title', 'Catalogues')
@section('page_subtitle', 'Manage catalogue PDFs')

@section('content')
    @php($bulkFormId = 'catalogue-bulk-form')

    <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
        <a href="{{ route('backend.catalogues.create') }}" class="adm-btn adm-btn--primary">
            <i class="bi bi-plus-lg"></i> Add catalogue
        </a>

        <form method="GET" action="{{ route('backend.catalogues.index') }}"
            class="d-flex gap-2 align-items-center ms-auto" style="max-width: min(100%, 40rem);">
            <input type="search" name="search" class="form-control" placeholder="Search by catalogue name…"
                value="{{ old('search', request('search')) }}" aria-label="Search catalogues">
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
            @if (request()->filled('search'))
                <a href="{{ route('backend.catalogues.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
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
        @if ($catalogues->isEmpty())
            <p class="adm-empty">
                @if (request()->filled('search'))
                    No catalogues match your search.
                    <a href="{{ route('backend.catalogues.index') }}">Clear search</a>
                @else
                    No catalogues yet. <a href="{{ route('backend.catalogues.create') }}">Create the first one</a>.
                @endif
            </p>
        @else
            <form id="{{ $bulkFormId }}" method="POST" action="{{ route('backend.catalogues.bulk-action') }}"
                class="p-3 pb-0 border-bottom border-light">
                @csrf
                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                    <label class="visually-hidden" for="bulk-action-catalogue">Bulk action</label>
                    <select name="action" id="bulk-action-catalogue" class="form-select" style="max-width: 14rem;">
                        <option value="">Bulk actions…</option>
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
                            <th style="width:5rem;">Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>PDF</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($catalogues as $catalogue)
                            <tr>
                                <td>
                                    <input type="checkbox" class="select-item" name="catalogue_ids[]"
                                        value="{{ $catalogue->id }}" form="{{ $bulkFormId }}">
                                </td>
                                <td><span
                                        class="adm-badge">{{ $loop->iteration + ($catalogues->currentPage() - 1) * $catalogues->perPage() }}</span>
                                </td>
                                <td>
                                    @if ($catalogue->featured_image)
                                        <img src="{{ asset('storage/' . $catalogue->featured_image) }}" alt=""
                                            class="adm-thumb adm-thumb--cover" width="48" height="48"
                                            style="object-fit:cover;border-radius:8px;">
                                    @else
                                        <span class="adm-muted small">—</span>
                                    @endif
                                </td>
                                <td><strong>{{ $catalogue->name }}</strong></td>
                                <td>{{ data_get($catalogue, 'category.name', '—') }}</td>
                                <td>
                                    @if ($catalogue->is_active)
                                        <span class="adm-badge adm-badge-success">Active</span>
                                    @else
                                        <span class="adm-badge adm-badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($catalogue->pdf)
                                        <a href="{{ asset('storage/' . $catalogue->pdf) }}" target="_blank"
                                            rel="noopener noreferrer" class="adm-btn adm-btn--ghost adm-btn--sm">View PDF</a>
                                    @else
                                        <span class="adm-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="adm-actions justify-content-end">
                                        <a href="{{ route('backend.catalogues.edit', $catalogue) }}"
                                            class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                        <form action="{{ route('backend.catalogues.destroy', $catalogue) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this catalogue?');">
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
            <div class="adm-pager">{{ $catalogues->links() }}</div>
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
                var n = document.querySelectorAll('.adm-table .select-item:checked').length;
                if (!n) {
                    e.preventDefault();
                    alert('Select at least one catalogue.');
                    return;
                }
                if (action.value === 'delete' && !confirm('Delete ' + n + ' catalogue(s)? This cannot be undone.')) {
                    e.preventDefault();
                }
            });
        })();
    </script>
@endpush
