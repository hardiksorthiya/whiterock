<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        $g = $globalSeo ?? [
            'title' => 'Nivoc — Strength You Can Build On',
            'description' => 'Nivoc supplies wall and ceiling systems—gypsum ceiling tiles, T-grid, soffit and fluted panels—for dealers, contractors and commercial and residential projects across India.',
            'keywords' => 'Nivoc, gypsum ceiling tiles, T-grid ceiling, false ceiling, soffit panels, fluted panels, wall panels, building materials, dealer, India',
        ];
    @endphp
    <title>@hasSection('seo_title')@yield('seo_title')@else{{ $g['title'] }}@endif</title>
    <meta name="description" content="@hasSection('seo_description')@yield('seo_description')@else{{ $g['description'] }}@endif">
    <meta name="keywords" content="@hasSection('seo_keywords')@yield('seo_keywords')@else{{ $g['keywords'] }}@endif">
    <meta property="og:title" content="@hasSection('seo_title')@yield('seo_title')@else{{ $g['title'] }}@endif">
    <meta property="og:description" content="@hasSection('seo_description')@yield('seo_description')@else{{ $g['description'] }}@endif">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lenis.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <link rel="icon" href="{{ asset('storage/'.$settings->favicon_path) }}">
    @stack('head')
</head>
<body>
    @include('frontend.partials.header')

    <div class="content">
        @yield('content')
    </div>

    @include('frontend.partials.footer')
    @include('frontend.partials.floating-whatsapp')
    @stack('scripts')
</body>
</html>
