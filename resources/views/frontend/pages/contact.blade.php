@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'CONTACT US',
        'image' => asset('images/cbre.jpeg')
    ])

    @php
        $phoneRaw = trim((string) ($setting->phone ?? ''));
        $phoneParts = $phoneRaw !== ''
            ? preg_split('/\s*(\|\||[,;])\s*/', $phoneRaw, -1, PREG_SPLIT_NO_EMPTY)
            : [];
        if ($phoneParts === [] && $phoneRaw !== '') {
            $phoneParts = [$phoneRaw];
        }
        $contactAddress = trim((string) ($setting->contact_address ?? ''));
    @endphp

    <section class="contact-page py-5">
        <div class="container">
            <div class="contact-page__shell">
                <div class="row align-items-start g-4">
                    <div class="col-lg-5">
                        <div class="contact-page__info h-100">
                            <p class="contact-page__eyebrow mb-2">CONTACT US</p>
                            <h2 class="contact-page__title mb-3">Get in Touch</h2>
                            <p class="contact-page__desc mb-4">
                                We are here to help you. Reach out to us for product enquiries, dealership support, and project discussions.
                            </p>

                            <div class="contact-page__intro-wrap contact-page__intro-wrap--in-panel">
                                <article class="contact-page__intro-card">
                                    <div class="contact-page__intro-card-icon" aria-hidden="true">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <div class="contact-page__intro-card-body">
                                        <h3 class="contact-page__intro-card-title">Contact Us:</h3>
                                        <div class="contact-page__intro-card-text">
                                            @if (!empty($setting->email))
                                                <a href="mailto:{{ $setting->email }}"
                                                    class="contact-page__intro-link">{{ $setting->email }}</a>
                                            @endif
                                            @if (!empty($phoneParts))
                                                @if (!empty($setting->email))
                                                    <br>
                                                @endif
                                                <span class="contact-page__intro-phones">
                                                    @foreach ($phoneParts as $i => $part)
                                                        @if ($i > 0)
                                                            <span class="contact-page__intro-phone-sep" aria-hidden="true">
                                                                &nbsp;||&nbsp;
                                                            </span>
                                                        @endif
                                                        @php
                                                            $digits = preg_replace('/\D+/', '', (string) $part);
                                                        @endphp
                                                        @if ($digits !== '')
                                                            <a href="tel:{{ $digits }}"
                                                                class="contact-page__intro-link">{{ trim($part) }}</a>
                                                        @else
                                                            <span>{{ trim($part) }}</span>
                                                        @endif
                                                    @endforeach
                                                </span>
                                            @endif
                                            @if (empty($setting->email) && $phoneParts === [])
                                                <span class="text-muted">Contact details coming soon.</span>
                                            @endif
                                        </div>
                                    </div>
                                </article>

                                <article class="contact-page__intro-card">
                                    <div class="contact-page__intro-card-icon" aria-hidden="true">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div class="contact-page__intro-card-body">
                                        <h3 class="contact-page__intro-card-title">Office address:</h3>
                                        <div class="contact-page__intro-card-text">
                                            @if ($contactAddress !== '')
                                                {!! nl2br(e($contactAddress)) !!}
                                            @else
                                                <span class="text-muted">Address will appear here once set in site settings.</span>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <div class="contact-page__social mt-4">
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

                    <div class="col-lg-7">
                        <div class="contact-page__form-card">
                            <div class="p-4 p-lg-5">
                                <div class="contact-page__form-head mb-4">
                                    <span class="contact-page__form-icon"><i class="bi bi-envelope-fill"></i></span>
                                    <div>
                                        <h3 class="contact-page__form-title mb-0">Send us a Message</h3>
                                        <span class="contact-page__form-line"></span>
                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success mb-3">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('contact.store') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="contact-page__field">
                                                <i class="bi bi-person"></i>
                                                <input type="text" name="name" class="form-control" placeholder="Your Name"
                                                    value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="contact-page__field">
                                                <i class="bi bi-envelope"></i>
                                                <input type="email" name="email" class="form-control" placeholder="Your Email"
                                                    value="{{ old('email') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="contact-page__field">
                                                <i class="bi bi-telephone"></i>
                                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number"
                                                    value="{{ old('phone') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="contact-page__field">
                                                <i class="bi bi-geo-alt"></i>
                                                <input type="text" name="city" class="form-control" placeholder="City"
                                                    value="{{ old('city') }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="contact-page__field">
                                                <i class="bi bi-clipboard"></i>
                                                <input type="text" name="subject" class="form-control" placeholder="Subject"
                                                    value="{{ old('subject') }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="contact-page__field contact-page__field--textarea">
                                                <i class="bi bi-pencil"></i>
                                                <textarea name="message" class="form-control" rows="5" placeholder="Your Message">{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-lg contact-page__submit-btn w-100 mt-4 text-uppercase" type="submit">
                                        <i class="bi bi-send" aria-hidden="true"></i>
                                        <span>Send Message</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </section>

    <section class="contact-page__warehouses py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="sorath-title mb-0">Our warehouses across India</h2>
            </div>

            <div class="contact-page__warehouse-grid">
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/ban.png') }}" alt="Bangalore" class="contact-page__warehouse-card-img img-fluid"><span>Bangalore</span></div>
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/hyd.png') }}" alt="Hyderabad" class="contact-page__warehouse-card-img img-fluid"><span>Hyderabad</span></div>
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/nag.png') }}" alt="Nagpur" class="contact-page__warehouse-card-img img-fluid"><span>Nagpur</span></div>
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/aur.png') }}" alt="Aurangabad" class="contact-page__warehouse-card-img img-fluid"><span>Aurangabad</span></div>
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/mum.png') }}" alt="Mumbai" class="contact-page__warehouse-card-img img-fluid"><span>Mumbai</span></div>
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/pun.png') }}" alt="Pune" class="contact-page__warehouse-card-img img-fluid"><span>Pune</span></div>
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/ahm.png') }}" alt="Ahmedabad" class="contact-page__warehouse-card-img img-fluid"><span>Ahmedabad</span></div>
                <div class="contact-page__warehouse-card"><img src="{{ asset('images/contact/jai.png') }}" alt="Jaipur" class="contact-page__warehouse-card-img img-fluid"><span>Jaipur</span></div>
                 </div>
        </div>
    </section>

    @if (!empty($setting->contact_map_iframe))
        <section class="contact-page__map-section pb-5">
            <div class="container">
                <div class="contact-page__address-card">
                    <div class="p-4 p-lg-5">
                        <div class="text-center mb-3">
                            <h2 class="sorath-title mb-0">Our Location</h2>
                        </div>
                        <div class="contact-page__map rounded overflow-hidden border">
                            <div class="ratio ratio-21x9 map-iframe">
                                {!! $setting->contact_map_iframe !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @include('frontend.components.home.sticky-enquiry')
@endsection

