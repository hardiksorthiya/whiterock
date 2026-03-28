@extends('layouts.app')

@php
    $edit = (bool) $role;
@endphp

@section('page_title', $edit ? 'Edit role' : 'New role')
@section('page_subtitle', $edit ? 'Update name and permissions' : 'Define a role and assign permissions')

@section('content')


    @if ($errors->any())
        <div class="adm-alert adm-alert--err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ $edit ? route('backend.roles.update', $role->id) : route('backend.roles.store') }}" class="row g-4">
        @csrf
        @if ($edit) @method('PUT') @endif

        <div class="col-lg-8">
            <section class="adm-card">
                <h2 class="adm-card__title">Role name</h2>
                <div class="adm-card__body">
                    <div class="adm-fld mb-0">
                        <label for="role-name">Name</label>
                        <input id="role-name" type="text" name="name" class="form-control" required
                            value="{{ old('name', data_get($role, 'name')) }}" placeholder="e.g. Editor, Manager">
                    </div>
                </div>
            </section>

            <section class="adm-card">
                <h2 class="adm-card__title">Permissions</h2>
                <div class="adm-card__body">
                    <p class="small adm-muted mb-3">Tick the abilities this role should have. Values are saved by permission name.</p>
                    <div class="row g-2">
                        @foreach ($permissions as $permission)
                            <div class="col-md-6 col-xl-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                        @checked(in_array($permission->name, old('permissions', $rolePermissionNames ?? []), true))>
                                    <label class="form-check-label small" for="perm-{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($permissions->isEmpty())
                        <p class="adm-muted small mb-0">No permissions in the database. Run your seeder or add permissions first.</p>
                    @endif
                </div>
            </section>
        </div>

        <div class="col-lg-4 adm-sidebar-col">
            <section class="adm-card">
                <h2 class="adm-card__title">Save</h2>
                <div class="adm-card__body">
                    <p class="small adm-muted mb-0">Assign at least one permission, or adjust checks and save.</p>
                </div>
            </section>
            <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                <i class="bi bi-check-lg"></i> {{ $edit ? 'Update role' : 'Save role' }}
            </button>
        </div>
    </form>
@endsection
