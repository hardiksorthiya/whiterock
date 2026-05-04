@php
    $waLink = $setting->whatsapp_url ?? null;
    if (empty($waLink) && ! empty($setting->phone)) {
        $digits = preg_replace('/\D+/', '', (string) $setting->phone);
        $waLink = ! empty($digits) ? 'https://wa.me/'.$digits : null;
    }
    $waHref = $waLink ?: route('contact');
    $waIsExternal = ! empty($waLink);
@endphp

<section class="faq-page-cta" aria-label="Dealer and pricing actions">
    <div class="faq-page-cta__glow faq-page-cta__glow--1" aria-hidden="true"></div>
    <div class="faq-page-cta__glow faq-page-cta__glow--2" aria-hidden="true"></div>

    <div class="container position-relative">
        <div class="faq-page-cta__shell mx-auto text-center">
            <p class="faq-page-cta__eyebrow mb-2">Partner with NIVOC</p>
            <p class="faq-page-cta__tagline mb-0 mx-auto">Take the next step — dealership enquiries and B2B pricing in one place.</p>

            <div class="faq-page-cta__actions">
                <a href="{{ route('contact') }}" class="faq-page-cta__btn faq-page-cta__btn--dealer">
                    <span class="faq-page-cta__btn-icon" aria-hidden="true"><i class="bi bi-shop-window"></i></span>
                    <span class="faq-page-cta__btn-label">Become a Dealer</span>
                </a>
                <a href="{{ $waHref }}"
                    class="faq-page-cta__btn faq-page-cta__btn--whatsapp"
                    @if ($waIsExternal) target="_blank" rel="noopener noreferrer"
                    @else title="WhatsApp number not set — opens contact form for B2B pricing" @endif>
                    <span class="faq-page-cta__btn-icon" aria-hidden="true"><i class="bi bi-whatsapp"></i></span>
                    <span class="faq-page-cta__btn-label">Get B2B Price List on WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</section>
