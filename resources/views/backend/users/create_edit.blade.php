@extends('layouts.app')

@php
    $edit = (bool) $user;
@endphp

@section('page_title', $edit ? 'Edit user' : 'New user')
@section('page_subtitle', $edit ? 'Update account and role' : 'Create a backend account')

@section('content')


    @if ($errors->any())
        <div class="adm-alert adm-alert--err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ $edit ? route('backend.users.update', $user->id) : route('backend.users.store') }}" class="row g-4">
        @csrf
        @if ($edit) @method('PUT') @endif

        <div class="col-lg-8">
            <section class="adm-card">
                <h2 class="adm-card__title">Account</h2>
                <div class="adm-card__body">
                    <div class="adm-fld">
                        <label for="user-name">Name</label>
                        <input id="user-name" type="text" name="name" class="form-control" required
                            value="{{ old('name', data_get($user, 'name')) }}" autocomplete="name">
                    </div>
                    <div class="adm-fld">
                        <label for="user-email">Email</label>
                        <input id="user-email" type="email" name="email" class="form-control" required
                            value="{{ old('email', data_get($user, 'email')) }}" autocomplete="email">
                    </div>
                    <div class="adm-fld">
                        <label for="user-password">Password @if($edit)<span class="adm-muted fw-normal">(optional)</span>@endif</label>
                        <input id="user-password" type="password" name="password" class="form-control"
                            autocomplete="new-password" @if(!$edit) required @endif placeholder="{{ $edit ? 'Leave blank to keep current' : 'Min. 6 characters' }}">
                    </div>
                    <div class="adm-fld">
                        <label for="user-password-confirm">Confirm password</label>
                        <input id="user-password-confirm" type="password" name="password_confirmation" class="form-control"
                            autocomplete="new-password" @if(!$edit) required @endif placeholder="{{ $edit ? 'Leave blank if not changing' : 'Repeat password' }}">
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-4 adm-sidebar-col">
            <section class="adm-card">
                <h2 class="adm-card__title">Role</h2>
                <div class="adm-card__body">
                    <label class="visually-hidden" for="user-role">Role</label>
                    <select id="user-role" name="role" class="form-select" required>
                        <option value="">Select role…</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected(old('role', $edit ? ($user->roles->first()?->name ?? '') : '') === $role->name)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </section>

            <button type="submit" class="adm-btn adm-btn--primary adm-btn--block">
                <i class="bi bi-check-lg"></i> {{ $edit ? 'Update user' : 'Save user' }}
            </button>
        </div>
    </form>
@endsection
