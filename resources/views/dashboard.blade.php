@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('content')

<h2 class="h4 mb-4">Overview</h2>

<!-- Welcome Alert -->
<div class="alert alert-success">
    You're logged in!
</div>

<!-- Stats Cards -->
<div class="row">

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-3">
            <h6 class="text-muted">Total Users</h6>
            <h3>120</h3>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-3">
            <h6 class="text-muted">Orders</h6>
            <h3>75</h3>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-3">
            <h6 class="text-muted">Revenue</h6>
            <h3>₹50,000</h3>
        </div>
    </div>

</div>

<!-- Extra Section -->
<div class="card shadow-sm p-4 mt-3">
    <h5>Quick Overview</h5>
    <p class="text-muted">
        Welcome to your admin dashboard. Here you can manage users, products, and system settings.
    </p>
</div>

@endsection