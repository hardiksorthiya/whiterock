@extends('layouts.app')

@section('title', 'Profile — ' . config('app.name'))

@section('page_title', 'Profile')

@section('content')

<h4 class="mb-4">Profile</h4>

<div class="row">

    <!-- Update Profile Info -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-4">
            <h5 class="mb-3">Update Profile Information</h5>

            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Update Password -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-4">
            <h5 class="mb-3">Change Password</h5>

            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete Account -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-4 border-danger">
            <h5 class="mb-3 text-danger">Delete Account</h5>

            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

@endsection