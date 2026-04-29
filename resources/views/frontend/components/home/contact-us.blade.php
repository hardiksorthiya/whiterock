@php
    $contactBgUrl = !empty($setting->contact_background_image_path)
        ? asset('storage/' . $setting->contact_background_image_path)
        : null;
@endphp

<section class="home-contact-us py-5">
    @if ($contactBgUrl)
        <div class="home-contact-us__bg" style="background-image: url('{{ $contactBgUrl }}');" aria-hidden="true"></div>
    @endif

    <div class="container position-relative z-1">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="home-contact-us__content h-100">
                    <p class="home-contact-us__eyebrow mb-2">CONTACT US</p>
                    <h2 class="sorath-title mb-3">Let’s Build Your Next Project Together</h2>
                    <p class="sorath-desc text-start mb-4">
                        Get reliable supply, consistent quality, and professional support—designed for dealers, contractors, and large-scale projects.
                    </p>
                    <div class="home-contact-us__benefits">
                        <div class="home-contact-us__benefit">
                            <div class="home-contact-us__benefit-icon">
                                <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
                            </div>
                            <div class="home-contact-us__benefit-text">
                                <div class="home-contact-us__benefit-title">Quick Response</div>
                                <div class="home-contact-us__benefit-desc">We reply within 24 hours</div>
                            </div>
                        </div>

                        <div class="home-contact-us__benefit">
                            <div class="home-contact-us__benefit-icon">
                                <i class="bi bi-box-seam" aria-hidden="true"></i>
                            </div>
                            <div class="home-contact-us__benefit-text">
                                <div class="home-contact-us__benefit-title">Bulk Pricing Available</div>
                                <div class="home-contact-us__benefit-desc">Best rates for bulk orders</div>
                            </div>
                        </div>

                        <div class="home-contact-us__benefit">
                            <div class="home-contact-us__benefit-icon">
                                <i class="bi bi-truck" aria-hidden="true"></i>
                            </div>
                            <div class="home-contact-us__benefit-text">
                                <div class="home-contact-us__benefit-title">Pan-India Supply</div>
                                <div class="home-contact-us__benefit-desc">Delivering across India</div>
                            </div>
                        </div>
                    </div>

                    @php
                        $waLink = $setting->whatsapp_url ?? null;
                        if (empty($waLink) && !empty($setting->phone)) {
                            $digits = preg_replace('/\D+/', '', (string) $setting->phone);
                            $waLink = !empty($digits) ? 'https://wa.me/' . $digits : null;
                        }
                    @endphp
                    @if (!empty($waLink))
                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                            class="btn btn-dark home-contact-us__wa-btn">
                            <i class="bi bi-whatsapp"></i>
                            <span>Get B2b Price List</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 home-contact-us__form-card h-100">
                    <div class="card-body p-4 p-lg-5">
                        <div class="home-contact-us__form-head mb-4">
                            <div class="home-contact-us__form-head-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h3 class="home-contact-us__form-title mb-0">Send us a Message</h3>
                                <span class="home-contact-us__form-line" aria-hidden="true"></span>
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
                                    <div class="home-contact-us__input-wrap">
                                        <i class="bi bi-person"></i>
                                        <input type="text" name="name" class="form-control home-contact-us__input"
                                            placeholder="Your Name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="home-contact-us__input-wrap">
                                        <i class="bi bi-envelope"></i>
                                        <input type="email" name="email" class="form-control home-contact-us__input"
                                            placeholder="Your Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="home-contact-us__input-wrap">
                                        <i class="bi bi-telephone"></i>
                                        <input type="tel" name="phone" class="form-control home-contact-us__input"
                                            placeholder="Phone Number" value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="home-contact-us__input-wrap">
                                        <i class="bi bi-geo-alt"></i>
                                        <input type="text" name="city" class="form-control home-contact-us__input"
                                            placeholder="City" value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="home-contact-us__input-wrap">
                                        <i class="bi bi-clipboard"></i>
                                        <input type="text" name="subject" class="form-control home-contact-us__input"
                                            placeholder="Subject" value="{{ old('subject') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="home-contact-us__input-wrap home-contact-us__input-wrap--textarea">
                                        <i class="bi bi-pencil"></i>
                                        <textarea name="message" class="form-control home-contact-us__input home-contact-us__input--textarea" rows="5"
                                            placeholder="Your Message">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="home-contact-us__trust mt-3">
                                <div class="home-contact-us__trust-item"><i class="bi bi-shield-check"></i><span>100% Reliable & Secure</span></div>
                                <div class="home-contact-us__trust-item"><i class="bi bi-clock"></i><span>Response Within 24 Hours</span></div>
                                <div class="home-contact-us__trust-item"><i class="bi bi-headset"></i><span>Dedicated Support</span></div>
                            </div>

                            <button class="btn home-contact-us__submit-btn w-100 mt-4 text-uppercase" type="submit">
                                <i class="bi bi-send"></i>
                                <span>Send Message</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
