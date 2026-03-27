@extends('layouts.guest')

@section('content')

<h4 class="text-center mb-3">Verify Your Email</h4>

<p class="text-muted text-center mb-4">
    Thanks for signing up! Before getting started, please verify your email address 
    by clicking on the link we just emailed to you. If you didn’t receive it, we’ll send another.
</p>

<!-- Success Message -->
@if (session('status') == 'verification-link-sent')
    <div class="alert alert-success text-center">
        A new verification link has been sent to your email address.
    </div>
@endif

<div class="d-flex justify-content-between align-items-center">

    <!-- Resend Email -->
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-dark">
            Resend Verification Email
        </button>
    </form>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none">
            Logout
        </button>
    </form>

</div>

@endsection