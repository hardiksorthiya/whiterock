<section class="sorath-section py-5">
    <div class="container">
        <div class="row align-items-center position-relative">

            <!-- Left Content -->
            <div class="col-lg-6 col-md-6">
                <div class="sorath-image-wrapper">
                    @if (! empty($about->about_image))
                        <img src="{{ asset('storage/' . $about->about_image) }}" class="img-fluid" alt="About image">
                    @else
                        <img src="{{ asset('images/h1.jpg') }}" class="img-fluid" alt="Interior">
                    @endif
                </div>
            </div>
           
            <!-- Right Founder Image -->
             <div class="col-lg-6 col-md-6">
                <div class="sorath-content-box shadow">
                    <p class="sorath-small-title">/ WELCOME TO WHITEROCK</p>
                    <h2 class="sorath-title">
                        STYLISH DESIGNS,<br>INNOVATIVE IDEAS
                    </h2>
                    <div class="sorath-desc">
                        {!! $about->description ?? 'About content coming soon.' !!}
                    </div>
                    
                </div>
            </div>


        </div>
    </div>
</section>
