@extends('layouts.app')

@section('page_title', 'Roles')
@section('page_subtitle', 'Manage roles and permission sets')

@section('content')

    <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
        <a href="{{ route('backend.roles.create') }}" class="adm-btn adm-btn--primary">
            <i class="bi bi-shield-plus"></i> Add role
        </a>

        <form method="GET" action="{{ route('backend.roles.index') }}"
            class="d-flex gap-2 align-items-center ms-auto" style="max-width: min(100%, 40rem);">
            <input type="search" name="search" class="form-control" placeholder="Search by role name…"
                value="{{ old('search', request('search')) }}" aria-label="Search roles">
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
            @if (request()->filled('search'))
                <a href="{{ route('backend.roles.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
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
        @if ($roles->isEmpty())
            <p class="adm-empty">
                @if (request()->filled('search'))
                    No roles match your search.
                    <a href="{{ route('backend.roles.index') }}">Clear search</a>
                @else
                    No roles yet. <a href="{{ route('backend.roles.create') }}">Create the first role</a>.
                @endif
            </p>
        @else
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td><span class="adm-badge">{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</span></td>
                                <td><strong>{{ $role->name }}</strong></td>
                                <td>
                                    <span class="adm-badge adm-badge-secondary">{{ $role->permissions_count }} assigned</span>
                                </td>
                                <td class="text-end">
                                    <div class="adm-actions justify-content-end">
                                        <a href="{{ route('backend.roles.edit', $role->id) }}" class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                        <form action="{{ route('backend.roles.destroy', $role->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this role? Users assigned to it may lose access.');">
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
            <div class="adm-pager">{{ $roles->links() }}</div>
        @endif
    </div>

@endsection
