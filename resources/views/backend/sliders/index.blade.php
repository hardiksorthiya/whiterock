@extends('layouts.app')

@section('page_title', 'Sliders')
@section('page_subtitle', 'Manage slider images and positions')

@section('content')

    <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
        <a href="{{ route('backend.sliders.create') }}" class="adm-btn adm-btn--primary">
            <i class="bi bi-images"></i> Add slider
        </a>

        <form method="GET" action="{{ route('backend.sliders.index') }}" class="d-flex gap-2 align-items-center ms-auto"
            style="max-width: min(100%, 40rem);">
            <input type="search" name="search" class="form-control" placeholder="Search by slider name…"
                value="{{ old('search', request('search')) }}" aria-label="Search sliders">
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
            @if (request()->filled('search'))
                <a href="{{ route('backend.sliders.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
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
        @if ($sliders->isEmpty())
            <p class="adm-empty">
                @if (request()->filled('search'))
                    No sliders match your search.
                    <a href="{{ route('backend.sliders.index') }}">Clear search</a>
                @else
                    No sliders yet. <a href="{{ route('backend.sliders.create') }}">Create the first one</a>.
                @endif
            </p>
        @else
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Active</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                            <tr>
                                <td>{{ $slider->id }}</td>
                                <td>{{ $slider->title ?: '—' }}</td>
                                <td>{{ $slider->description ?: '—' }}</td>
                                <td><img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title ?: 'Slider' }}"
                                        style="max-width: 150px;"></td>
                                        <td>
                                        @if ($slider->is_active)
                                            <span class="adm-badge adm-badge-success">Active</span>
                                        @else
                                            <span class="adm-badge adm-badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                <td class="text-end">
                                    <a href="{{ route('backend.sliders.edit', $slider) }}"
                                        class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                    <form action="{{ route('backend.sliders.destroy', $slider) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this slider?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="adm-btn adm-btn--ghost adm-btn--sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($sliders->hasPages())
                <div class="adm-pager">{{ $sliders->links() }}</div>
            @endif
        @endif
    </div>

@endsection
