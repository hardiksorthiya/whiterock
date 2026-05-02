@extends('layouts.app')

@section('page_title', 'Applications')
@section('page_subtitle', 'Manage product applications')

@section('content')
<div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
    <a href="{{ route('backend.applications.create') }}" class="adm-btn adm-btn--primary">
        <i class="bi bi-plus-lg"></i> Add application
    </a>

    <div class="ms-auto"></div>
</div>

@if (session('success'))
    <div class="adm-alert adm-alert--ok">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="adm-alert adm-alert--err">{{ session('error') }}</div>
@endif

<div class="adm-table-wrap">
    @if ($applications->isEmpty())
        <p class="adm-empty mb-0">
            No applications yet. <a href="{{ route('backend.applications.create') }}">Create the first one</a>.
        </p>
    @else
        <div class="table-responsive">
            <table class="table adm-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="width:4rem;">Feature</th>
                        <th style="width:5rem;">Banner</th>
                        <th>Name</th>
                        <th>Gallery Category</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
                            <td>
                                @if ($application->feature_image)
                                    <img src="{{ asset('storage/' . $application->feature_image) }}" alt=""
                                        class="adm-thumb" width="44" height="44" style="object-fit:cover;border-radius:8px;">
                                @else
                                    <span class="adm-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($application->banner_image)
                                    <img src="{{ asset('storage/' . $application->banner_image) }}" alt=""
                                        class="adm-thumb" width="56" height="36" style="object-fit:cover;border-radius:8px;">
                                @else
                                    <span class="adm-muted small">—</span>
                                @endif
                            </td>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->gallery_category_names ?: ($application->galleryCategory->name ?? '—') }}</td>
                            <td class="text-end">
                                <div class="adm-actions justify-content-end">
                                    <a href="{{ route('backend.applications.edit', $application) }}"
                                        class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                    <form action="{{ route('backend.applications.destroy', $application) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this application?');">
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

        @if ($applications->hasPages())
            <div class="adm-pager">{{ $applications->links() }}</div>
        @endif
    @endif
</div>
@endsection

