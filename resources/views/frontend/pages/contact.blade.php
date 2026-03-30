@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'CONTACT US',
        'image' => asset('frontend/images/contact-banner.jpg')
    ])

    <section class="py-5">
        <div class="container">
        <div class="row align-items-start g-4">
            <!-- LEFT SIDE -->
            <div class="col-lg-5">
                <div class="h-100">
                    <h2 class="fw-bold mb-3">Get in Touch</h2>
                    <p class="text-muted mb-4">
                        We are here to help you. Reach out to any of our offices.
                    </p>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone"></i>
                            <a href="tel:{{ $setting->phone }}" class="text-decoration-none">
                                {{ $setting->phone }}
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-envelope"></i>
                            <a href="mailto:{{ $setting->email }}" class="text-decoration-none">
                                {{ $setting->email }}
                            </a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex align-items-center gap-3">
                            @if (!empty($setting->facebook_url))
                                <a href="{{ $setting->facebook_url }}" target="_blank" rel="noopener"
                                    class="site-footer__social-btn" aria-label="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif

                            @if (!empty($setting->instagram_url))
                                <a href="{{ $setting->instagram_url }}" target="_blank" rel="noopener"
                                    class="site-footer__social-btn" aria-label="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif

                            @if (!empty($setting->twitter_url))
                                <a href="{{ $setting->twitter_url }}" target="_blank" rel="noopener"
                                    class="site-footer__social-btn" aria-label="Twitter / X">
                                    <i class="bi bi-twitter-x"></i>
                                </a>
                            @endif

                            @if (!empty($setting->whatsapp_url))
                                <a href="{{ $setting->whatsapp_url }}" target="_blank" rel="noopener"
                                    class="site-footer__social-btn" aria-label="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE (FORM) -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Your Email">
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" rows="5" placeholder="Your Message"></textarea>
                            </div>
                        </div>

                        <button class="btn btn-dark w-100 mt-4 text-uppercase" type="button">
                            SEND MESSAGE
                        </button>
                    </form>
                    </div>
                </div>
            </div>

            <!-- LOCATIONS GRID (below) -->
            <div class="col-12 mt-2">
                <div class="row g-4">
                        @foreach($setting->contact_locations ?? [] as $address)
                            @php
                                $title = $address['title'] ?? $address['address'] ?? $address['description'] ?? '';
                                $addressLine = $address['address'] ?? $address['description'] ?? '';
                                $callLine = $address['call'] ?? $setting->phone ?? '';
                                // $emailLine = $address['email'] ?? $setting->email ?? '';
                                $mapHtml = $address['map_iframe'] ?? ($address['map'] ?? '');
                            @endphp

                            <div class="col-md-6 col-xl-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <!-- top title -->
                                        <h5 class="card-title">{{ $title !== '' ? $title : 'Location' }}</h5>

                                        <!-- address -->
                                        <p class="card-text mb-2">
                                            <strong>Address:</strong> {{ $addressLine !== '' ? $addressLine : '—' }}
                                        </p>

                                        <!-- call -->
                                        <p class="card-text mb-2">
                                            <strong>Call:</strong> {{ $callLine !== '' ? $callLine : '—' }}
                                        </p>

                                        <!-- email -->
                                        {{-- <p class="card-text mb-2">
                                            <strong>Email:</strong> {{ $emailLine !== '' ? $emailLine : '—' }}
                                        </p> --}}

                                        <!-- map -->
                                        @if ($mapHtml !== '')
                                            <div class="mt-3 border rounded overflow-hidden">
                                                <div class="ratio ratio-16x9 map-iframe">
                                                    {!! $mapHtml !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

