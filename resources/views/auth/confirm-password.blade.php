@extends('layouts.guest')

@section('content')
    <h4 class="text-center mb-3">Confirm Password</h4>

    <p class="text-muted text-center mb-4">
        This is a secure area of the application. Please confirm your password before continuing.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>

            <input type="password" name="password" class="form-control" required autocomplete="current-password">

            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-dark w-100">
            Confirm
        </button>

    </form>
@endsection
