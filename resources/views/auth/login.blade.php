@extends('layouts.guest')

@section('content')

<h3 class="text-center mb-4">Login</h3>

<!-- Session Status -->
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input 
            type="email" 
            name="email" 
            value="{{ old('email') }}" 
            class="form-control" 
            required 
            autofocus
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

    <!-- Remember Me -->
    <div class="mb-3 form-check">
        <input 
            type="checkbox" 
            name="remember" 
            class="form-check-input" 
            id="remember"
        >
        <label class="form-check-label" for="remember">
            Remember Me
        </label>
    </div>

    <!-- Forgot Password -->
    @if (Route::has('password.request'))
        <div class="mb-3 text-end">
            <a href="{{ route('password.request') }}" class="text-decoration-none">
                Forgot your password?
            </a>
        </div>
    @endif

    <!-- Submit -->
    <button type="submit" class="btn btn-dark w-100">
        Login
    </button>
</form>

@endsection