@extends('layouts.guest')

@section('content')
    <h4 class="text-center mb-3">Reset Password</h4>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>

            <input type="email" name="email" value="{{ old('email', $request->email) }}" class="form-control" required
                autofocus>

            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>

            <input type="password" name="password" class="form-control" required>

            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>

            <input type="password" name="password_confirmation" class="form-control" required>

            @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-dark w-100">
            Reset Password
        </button>

    </form>
@endsection
