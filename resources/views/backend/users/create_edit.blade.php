@extends('layouts.app')

@section('content')

<h4>{{ isset($user) ? 'Edit User' : 'Create User' }}</h4>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" 
      action="{{ isset($user) ? route('backend.users.update',$user->id) : route('backend.users.store') }}">
    
    @csrf
    @if(isset($user)) @method('PUT') @endif

    <!-- Name -->
    <input type="text" name="name" 
        value="{{ old('name', $user->name ?? '') }}" 
        class="form-control mb-3" placeholder="Name">

    <!-- Email -->
    <input type="email" name="email" 
        value="{{ old('email', $user->email ?? '') }}" 
        class="form-control mb-3" placeholder="Email">

    <!-- Password -->
    <input type="password" name="password" 
        class="form-control mb-3" placeholder="Password">

    <!-- Confirm Password -->
    <input type="password" name="password_confirmation"
        class="form-control mb-3" placeholder="Confirm Password">

    <!-- Role -->
    <select name="role" class="form-control mb-3">
        <option value="">Select Role</option>
        @foreach($roles as $role)
            <option value="{{ $role->name }}"
                {{ old('role', isset($user) ? $user->roles->pluck('name')->first() : '') == $role->name ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-dark">
        {{ isset($user) ? 'Update' : 'Save' }}
    </button>

</form>

@endsection