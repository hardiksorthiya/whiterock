<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Whiterock PVC Panels: Fast, Durable, and Affordable</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/frontend/style.css') }}">
</head>
<body>
    @include('frontend.partials.header')

    <div class="content">
        @yield('content')
    </div>

    @include('frontend.partials.footer')
</body>
</html>
