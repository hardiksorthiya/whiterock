@extends('layouts.guest')

@section('content')
    <h4 class="text-center mb-3">Forgot Password</h4>

    <p class="text-muted text-center mb-4">
        Forgot your password? No problem. Enter your email and we’ll send you a reset link.
    </p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>

            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>

            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-dark w-100">
            Email Password Reset Link
        </button>

    </form>
@endsection
