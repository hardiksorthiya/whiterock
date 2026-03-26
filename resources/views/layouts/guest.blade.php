<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Whiterock') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body style="background:#f5f5f5;">

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
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
