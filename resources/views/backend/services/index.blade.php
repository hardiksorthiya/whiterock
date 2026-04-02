@extends('layouts.app')

@section('page_title', 'Services')
@section('page_subtitle', 'Manage your services')

@section('content')

<div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
    <a href="{{ route('backend.services.create') }}" class="adm-btn adm-btn--primary">
        <i class="bi bi-plus-lg"></i> Add service
    </a>

    <form method="GET" action="{{ route('backend.services.index') }}" class="d-flex gap-2 align-items-center ms-auto"
        style="max-width: min(100%, 40rem);">
        <input type="search" name="search" class="form-control" placeholder="Search by title…"
            value="{{ old('search', request('search')) }}" aria-label="Search services">
        <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
        @if (request()->filled('search'))
            <a href="{{ route('backend.services.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
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
    @if ($services->isEmpty())
        <p class="adm-empty">
            @if (request()->filled('search'))
                No services match your search.
                <a href="{{ route('backend.services.index') }}">Clear search</a>
            @else
                No services yet. <a href="{{ route('backend.services.create') }}">Create the first one</a>.
            @endif
        </p>
    @else
        <div class="table-responsive">
            <table class="table adm-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                @if ($service->icon)
                                    <img src="{{ asset('storage/' . $service->icon) }}" alt="" width="40" height="40"
                                        class="rounded object-fit-cover" style="object-fit: cover;">
                                @else
                                    <span class="adm-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $service->title }}</td>
                            <td>
                                @if ($service->is_active)
                                    <span class="adm-badge adm-badge-success">Active</span>
                                @else
                                    <span class="adm-badge adm-badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('backend.services.edit', $service) }}"
                                    class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                <form action="{{ route('backend.services.destroy', $service) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this service?');">
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
        @if ($services->hasPages())
            <div class="adm-pager">{{ $services->links() }}</div>
        @endif
    @endif
</div>

@endsection
