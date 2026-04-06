<section class="product-section py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col position-relative">
                <div class="sorath-section-header text-center">
                    <h2 class="sorath-title">Our Products</h2>
                    <p class="sorath-desc">
                        Far far away behind the word mountains far from the countries
                        Vokalia and Consonantia there live the blind texts.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">

            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

                    <div class="card product-card h-100 border-0">

                        <!-- Image -->
                        <div class="product-img">
                            <img src="{{ asset('storage/' . $product->featured_image) }}" class="card-img-top"
                                alt="{{ $product->name }}">
                        </div>

                        <!-- Content -->
                        <div class="card-body text-center">

                            <h6 class="fw-semibold">{{ $product->name }}</h6>

                            <a href="#" class="btn btn-dark btn-sm mt-2">
                                Enquiry Now
                            </a>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
</section>
