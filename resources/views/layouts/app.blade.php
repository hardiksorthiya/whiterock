<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Whiterock'))</title>

    @if (!empty($settings?->favicon_path))
        <link rel="icon" href="{{ asset('storage/' . $settings->favicon_path) }}" type="image/x-icon">
    @endif

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @stack('styles')
</head>

<body class="app-body">

@include('layouts.sidebar')

<div class="sidebar-backdrop d-lg-none" id="sidebarBackdrop" aria-hidden="true"></div>

<div class="app-main" id="appMain">

    @include('layouts.navigation')

    <main class="app-content flex-grow-1">
        <div class="container-fluid py-3 py-lg-4">
            @yield('content')
        </div>
    </main>

</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')

</body>
</html>
