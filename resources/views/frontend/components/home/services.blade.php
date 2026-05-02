<section class="sorath-services py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-12">
                <div class="sorath-section-header text-center mx-auto" style="max-width: 760px;">
                    <h2 class="sorath-title">Our Product Range</h2>
                    <p class="sorath-desc mb-0">
                        Explore our range of ceiling systems and decorative panel solutions designed for durability, performance, and modern interiors.
                    </p>
                </div>
            </div>

            <!-- Service Card -->
            @foreach ($services->take(2) as $service)
                <div class="col-lg-5 col-md-6">
                    <div class="sorath-service-card sorath-bg-card"
                        style="background-image: url('{{ asset('storage/' . $service->background_image) }}');">

                        <div class="sorath-card-content">
                            {{-- <div class="sorath-icon">
                                <img src="{{ asset('storage/' . $service->icon) }}" alt="Services Icon"
                                    class="img-fluid">
                            </div> --}}
                            <h4>{{ $service->title }}</h4>
                            <p>{{ $service->description }}</p>
                            @if ($service->button_href)
                                <a href="{{ $service->button_href }}" class="sorath-service-btn"
                                    @if (str_starts_with($service->button_href, 'http://') || str_starts_with($service->button_href, 'https://')) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $service->button_text ?: 'Learn more' }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
