@extends('layouts.guest')

@section('content')

<h3 class="text-center mb-4">Register</h3>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input 
            type="text" 
            name="name" 
            value="{{ old('name') }}" 
            class="form-control" 
            required 
            autofocus
        >

        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input 
            type="email" 
            name="email" 
            value="{{ old('email') }}" 
            class="form-control" 
            required
        >

        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input 
            type="password" 
            name="password" 
            class="form-control" 
            required
        >

        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input 
            type="password" 
            name="password_confirmation" 
            class="form-control" 
            required
        >

        @error('password_confirmation')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Already Registered -->
    <div class="mb-3 text-end">
        <a href="{{ route('login') }}" class="text-decoration-none">
            Already registered?
        </a>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-dark w-100">
        Register
    </button>

</form>

@endsection