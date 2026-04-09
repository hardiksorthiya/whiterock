@props([
    'size' => '60px',
])

<div {{ $attributes->class(['text-center']) }}>
    <a href="{{ url('/') }}">
        <img src="{{ asset('storage/'.$settings->light_logo_path) }}"
             alt="{{ config('app.name', 'App') }} logo"
             class="sorath-logo-img"
             style="height: {{ $size }}; width: auto; max-width: 100%; object-fit: contain;">
    </a>
</div>
