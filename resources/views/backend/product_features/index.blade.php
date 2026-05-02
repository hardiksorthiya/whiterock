@extends('layouts.app')

@section('page_title', 'Product features')
@section('page_subtitle', 'Icons and titles shown on product detail pages')

@section('content')
    <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
        <a href="{{ route('backend.product-features.create') }}" class="adm-btn adm-btn--primary">
            <i class="bi bi-plus-lg"></i> Add feature
        </a>

        <form method="GET" action="{{ route('backend.product-features.index') }}"
            class="d-flex gap-2 align-items-center ms-auto" style="max-width: min(100%, 24rem);">
            <input type="search" name="search" class="form-control" placeholder="Search by title…"
                value="{{ old('search', request('search')) }}" aria-label="Search features">
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
            @if (request()->filled('search'))
                <a href="{{ route('backend.product-features.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="adm-alert adm-alert--ok">{{ session('success') }}</div>
    @endif

    <div class="adm-table-wrap">
        @if ($features->isEmpty())
            <p class="adm-empty mb-0">
                @if (request()->filled('search'))
                    No features match your search.
                    <a href="{{ route('backend.product-features.index') }}">Clear search</a>
                @else
                    No product features yet.
                    <a href="{{ route('backend.product-features.create') }}">Create the first one</a>.
                @endif
            </p>
        @else
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:4rem;">#</th>
                            <th style="width:5rem;">Image</th>
                            <th>Title</th>
                            <th style="width:6rem;">Sort</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($features as $feature)
                            <tr>
                                <td><span class="adm-badge">{{ $loop->iteration + ($features->currentPage() - 1) * $features->perPage() }}</span></td>
                                <td>
                                    @if ($feature->image)
                                        <img src="{{ asset('storage/' . $feature->image) }}" alt=""
                                            class="adm-thumb" width="48" height="48" style="object-fit:contain;">
                                    @else
                                        <span class="adm-muted small">—</span>
                                    @endif
                                </td>
                                <td><strong>{{ $feature->title }}</strong></td>
                                <td>{{ $feature->sort_order }}</td>
                                <td class="text-end">
                                    <div class="adm-actions justify-content-end">
                                        <a href="{{ route('backend.product-features.edit', $feature) }}"
                                            class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                        <form action="{{ route('backend.product-features.destroy', $feature) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this feature? It will be removed from all products.');">
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
            <div class="adm-pager">{{ $features->links() }}</div>
        @endif
    </div>
@endsection
