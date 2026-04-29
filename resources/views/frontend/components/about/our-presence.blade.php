<section class="our-presence py-5 section-reveal" aria-labelledby="our-presence-title">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <div class="our-presence__map-wrap">
                    <img
                        src="{{ asset('images/_provided_map.svg') }}"
                        alt="India map showing our locations"
                        class="our-presence__map-image"
                        loading="lazy"
                    >

                    <span class="our-presence__pin" style="--pin-x: 13%; --pin-y: 50%; --pin-delay: 0s;" aria-label="Ahmedabad">
                        <span class="our-presence__pin-dot"></span>
                        <span class="our-presence__pin-label">Ahmedabad</span>
                    </span>
                    <span class="our-presence__pin" style="--pin-x: 17%; --pin-y: 56%; --pin-delay: 0.2s;" aria-label="Surat">
                        <span class="our-presence__pin-dot"></span>
                        <span class="our-presence__pin-label">Surat</span>
                    </span>
                    <span class="our-presence__pin" style="--pin-x: 17%; --pin-y: 63%; --pin-delay: 0.4s;" aria-label="Mumbai">
                        <span class="our-presence__pin-dot"></span>
                        <span class="our-presence__pin-label">Mumbai</span>
                    </span>
                    <span class="our-presence__pin" style="--pin-x: 24%; --pin-y: 67%; --pin-delay: 0.6s;" aria-label="Pune">
                        <span class="our-presence__pin-dot"></span>
                        <span class="our-presence__pin-label">Pune</span>
                    </span>
                    <span class="our-presence__pin" style="--pin-x: 35%; --pin-y: 56%; --pin-delay: 0.8s;" aria-label="Nagpur">
                        <span class="our-presence__pin-dot"></span>
                        <span class="our-presence__pin-label">Nagpur</span>
                    </span>
                    <span class="our-presence__pin" style="--pin-x: 54%; --pin-y: 60%; --pin-delay: 1s;" aria-label="Hyderabad">
                        <span class="our-presence__pin-dot"></span>
                        <span class="our-presence__pin-label">Hyderabad</span>
                    </span>
                    <span class="our-presence__pin" style="--pin-x: 37%; --pin-y: 78%; --pin-delay: 1.2s;" aria-label="Bangalore">
                        <span class="our-presence__pin-dot"></span>
                        <span class="our-presence__pin-label">Bangalore</span>
                    </span>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="our-presence__content h-100">
                    <span class="sorath-small-title">OUR PRESENCE</span>
                    <h2 id="our-presence-title" class="sorath-title mt-3 mb-3">Strong Network Across India</h2>
                    <p class="sorath-desc our-presence__desc mb-3">
                        With a growing network of warehouses across key cities, NIVOC ensures faster delivery, consistent stock availability, and seamless support nationwide.
                    </p>
                    <p class="our-presence__cities mb-4">
                        Bangalore, Hyderabad, Nagpur, Aurangabad, Mumbai, Pune, Ahmedabad, Jaipur, Ahmedabad
                    </p>
                    <a href="{{ url('/contact') }}" class="btn btn-dark our-presence__cta">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>
