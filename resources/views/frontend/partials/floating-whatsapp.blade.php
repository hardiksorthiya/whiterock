@php
    $site = $setting ?? \App\Models\Setting::site();
@endphp
@if (!empty($site->whatsapp_url))
    <a href="{{ $site->whatsapp_url }}" class="floating-whatsapp" target="_blank" rel="noopener noreferrer"
        aria-label="Chat on WhatsApp">
        <i class="bi bi-whatsapp" aria-hidden="true"></i>
    </a>
@endif
