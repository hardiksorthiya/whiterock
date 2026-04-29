<section class="sorath-founder-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="sorath-title mb-2">Leadership That Drives Growth</h3>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="sorath-content-box">
                    <h2 class="sorath-title">{{ $about->founder_name ?? 'Founder Name' }}</h2>
                    <p class="sorath-small-title">{{ $about->founder_designation ?? 'Founder Designation' }}</p>
                    <div class="sorath-desc">
                        {!! $about->founder_description ?? 'Founder description coming soon.' !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="sorath-image-wrapper">
                    <img src="{{ asset('storage/' . ($about->founder_image ?? '')) }}" class="img-fluid" alt="Founder">
                </div>
            </div>
            
        </div>
    </div>
</section>