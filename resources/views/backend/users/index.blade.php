@extends('layouts.app')

@section('page_title', 'Users')
@section('page_subtitle', 'Manage accounts and roles')

@section('content')
<div class="adm-page">
    <div class="adm-toolbar d-flex flex-wrap align-items-end gap-3 justify-content-between">
        <a href="{{ route('backend.users.create') }}" class="adm-btn adm-btn--primary">
            <i class="bi bi-person-plus"></i> Add user
        </a>

        <form method="GET" action="{{ route('backend.users.index') }}"
            class="d-flex gap-2 align-items-center ms-auto" style="max-width: min(100%, 40rem);">
            <input type="search" name="search" class="form-control" placeholder="Search by name or email…"
                value="{{ old('search', request('search')) }}" aria-label="Search users">
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Search</button>
            @if (request()->filled('search'))
                <a href="{{ route('backend.users.index') }}" class="adm-btn adm-btn--ghost adm-btn--sm">Clear</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="adm-alert adm-alert--ok">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="adm-alert adm-alert--err">{{ session('error') }}</div>
    @endif

    <div class="adm-table-wrap">
        @if ($users->isEmpty())
            <p class="adm-empty">
                @if (request()->filled('search'))
                    No users match your search.
                    <a href="{{ route('backend.users.index') }}">Clear search</a>
                @else
                    No users yet. <a href="{{ route('backend.users.create') }}">Add the first user</a>.
                @endif
            </p>
        @else
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><span class="adm-badge">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</span></td>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td><span class="adm-muted small">{{ $user->email }}</span></td>
                                <td>
                                    @if ($user->roles->isNotEmpty())
                                        <span class="adm-badge adm-badge-success">{{ $user->roles->first()->name }}</span>
                                    @else
                                        <span class="adm-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="adm-actions justify-content-end">
                                        <a href="{{ route('backend.users.edit', $user) }}" class="adm-btn adm-btn--ghost adm-btn--sm">Edit</a>
                                        <form action="{{ route('backend.users.destroy', $user) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this user? This cannot be undone.');">
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
            <div class="adm-pager">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection
