<section class="home-contact-us py-5">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="home-contact-us__content h-100">
                    <p class="home-contact-us__eyebrow mb-2">CONTACT US</p>
                    <h2 class="sorath-title mb-3">Ready to discuss your next interior project?</h2>
                    <p class="home-contact-us__subtitle mb-3">Get fast support from our product specialists.</p>
                    <p class="sorath-desc text-start mb-4">
                        Share your requirement and our team will help you with product suggestions, quantity guidance,
                        and commercial pricing for your business needs.
                    </p>

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
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
