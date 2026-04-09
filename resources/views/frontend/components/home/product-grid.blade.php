{{-- Expects: $sectionTitle, $products, optional $sectionDescription, $sectionId --}}
@php
    $sectionDescription = $sectionDescription
        ?? 'Far far away behind the word mountains far from the countries Vokalia and Consonantia there live the blind texts.';
@endphp
<section @if (!empty($sectionId)) id="{{ $sectionId }}" @endif class="product-section py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col position-relative">
                <div class="sorath-section-header text-center">
                    <h2 class="sorath-title">{{ $sectionTitle }}</h2>
                    <p class="sorath-desc">
                        {{ $sectionDescription }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

                    <div class="card product-card h-100 border-0">

                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-reset">
                            <div class="product-img">
                                @if (!empty($product->featured_image))
                                    <img src="{{ asset('storage/' . $product->featured_image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                @elseif (!empty($product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="min-height: 200px;">
                                        <span class="text-muted small">No image</span>
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="card-body text-center">

                            <a href="{{ route('product.show', $product->slug) }}"
                                class="text-decoration-none text-dark">
                                <h6 class="fw-semibold">{{ $product->name }}</h6>
                            </a>

                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-dark btn-sm mt-2">
                                View product
                            </a>

                        </div>

                    </div>

                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">
                    No products to show here yet.
                </div>
            @endforelse
        </div>

    </div>
</section>
