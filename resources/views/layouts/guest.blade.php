<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Whiterock') }}</title>

    @if (!empty($settings?->favicon_path))
        <link rel="icon" href="{{ asset('storage/' . $settings->favicon_path) }}" type="image/x-icon">
    @endif

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="login-register-background">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-md-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="/">
                        <x-sorath-logo />
                    </a>
                </div>

                <!-- Card -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>

            </div>
        </div>

        <!-- Bootstrap JS -->
        <script type="module" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</body>

</html>
