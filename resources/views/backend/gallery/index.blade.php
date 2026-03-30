@extends('layouts.app')

@section('page_title', 'Gallery')
@section('page_subtitle', 'Manage your gallery categories and images here')

@section('content')
    <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
        <a href="{{ route('backend.gallery.create') }}" class="adm-btn adm-btn--primary">
            <i class="bi bi-plus-lg"></i> Add category
        </a>

        <form method="GET" action="{{ route('backend.gallery.index') }}"
            class="d-flex gap-2 align-items-center ms-auto" style="max-width: min(100%, 40rem);">
            <input type="search" name="search" class="form-control" placeholder="Search by name…"
                value="{{ old('search', request('search')) }}" aria-label="Search gallery categories">
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
            @if (request()->filled('search'))
                <a href="{{ route('backend.gallery.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
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
        @if ($categories->isEmpty())
            <p class="adm-empty">
                @if (request()->filled('search'))
                    No categories match your search.
                    <a href="{{ route('backend.gallery.index') }}">Clear search</a>
                @else
                    No categories yet. <a href="{{ route('backend.gallery.create') }}">Create the first one</a>.
                @endif
            </p>
        @else
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Images</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $c)
                            <tr>
                                <td>
                                    <span class="adm-badge">
                                        {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                    </span>
                                </td>
                                <td><strong>{{ $c->name }}</strong></td>
                                <td>
                                    @if ($c->images->isNotEmpty())
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ asset('storage/' . $c->images->first()->image) }}"
                                                alt="" class="adm-thumb adm-thumb--sm rounded"
                                                style="width: 42px; height: 42px; object-fit: cover;">
                                            <span class="adm-muted small">{{ $c->images->count() }} total</span>
                                        </div>
                                    @else
                                        <span class="adm-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="adm-actions justify-content-end">
                                        <a href="{{ route('backend.gallery.edit', $c) }}"
                                            class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>

                                        <form action="{{ route('backend.gallery.destroy', $c) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this category? This will also delete all associated images.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="adm-pager">{{ $categories->links() }}</div>
            @endif
        @endif
    </div>
@endsection

