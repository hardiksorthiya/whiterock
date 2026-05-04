@extends('frontend.layouts.app')

@section('seo_title')
{{ filled(trim((string) ($product->meta_title ?? ''))) ? trim($product->meta_title) : $product->name }} | Nivoc
@endsection
@section('seo_description')
{{ filled(trim((string) ($product->meta_description ?? '')))
    ? \Illuminate\Support\Str::limit(strip_tags($product->meta_description), 320)
    : \Illuminate\Support\Str::limit(strip_tags((string) ($product->short_description ?? '')), 320) }}
@endsection
@section('seo_keywords')
{{ trim((string) ($product->keywords ?? '')) ?: 'Nivoc, '.$product->name.', building materials, India' }}
@endsection

@php
    $imagePaths = collect();
    if (!empty($product->featured_image)) {
        $imagePaths->push($product->featured_image);
    }
    foreach ($product->images as $gi) {
        $imagePaths->push($gi->image);
    }
    if ($imagePaths->isEmpty() && !empty($product->image)) {
        $imagePaths->push($product->image);
    }
    $imagePaths = $imagePaths->unique()->values();
    $mainImagePath = $imagePaths->first();
    $categoryNames = $product->categories->pluck('name')->filter()->values();
    if ($categoryNames->isEmpty() && $product->category) {
        $categoryNames = collect([$product->category->name]);
    }
    $productSpecs = collect([
        'Available Size' => $product->available_size,
        'Emboss Height' => $product->emboss_height,
        'Pattern Size' => $product->pattern_size,
        'Installation' => $product->installation,
        'Thickness' => $product->thickness,
        'QTY' => $product->qty,
        'Material' => $product->material,
    ])->filter(fn ($value) => filled($value));
@endphp

@section('content')
    @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success mb-0">{{ session('success') }}</div>
        </div>
    @endif

    @include('frontend.components.breadcrumb', [
        'title' => $product->name,
        'subtitle' => $categoryNames->isNotEmpty() ? $categoryNames->join(', ') : null,
        'image' => asset('images/nproduct.jpeg'),
        'crumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products')],
            ['label' => $product->name, 'url' => null],
        ],
    ])

    <section class="product-detail py-5">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-start">
                {{-- Left: main image + gallery --}}
                <div class="col-lg-6">
                    <div class="product-detail__media-card p-3 p-lg-4">
                        <div class="product-detail__main rounded overflow-hidden">
                            @if ($mainImagePath)
                                <img src="{{ asset('storage/' . $mainImagePath) }}" alt="{{ $product->name }}"
                                    class="img-fluid w-100 product-detail__main-img" id="productMainImage"
                                    style="max-height: 650px; object-fit: contain;">
                            @else
                                <div class="d-flex align-items-center justify-content-center text-muted"
                                    style="min-height: 280px;">No image</div>
                            @endif
                        </div>
                        @if ($imagePaths->count() > 1)
                            <div class="product-detail__thumbs d-flex flex-wrap gap-2 mt-3" role="tablist">
                                @foreach ($imagePaths as $idx => $path)
                                    <button type="button"
                                        class="product-detail__thumb btn p-0 rounded overflow-hidden @if ($idx === 0) is-active @endif"
                                        data-src="{{ asset('storage/' . $path) }}" aria-label="Show image {{ $idx + 1 }}">
                                        <img src="{{ asset('storage/' . $path) }}" alt="">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right: meta + actions --}}
                <div class="col-lg-6">
                    <div class="product-detail__info-card p-3">
                        <h2 class="product-detail__title fw-bold">{{ $product->name }}</h2>

                        <div class="mb-1">
                            <div class="d-flex flex-wrap gap-2">
                                @forelse ($product->categories as $cat)
                                    <a href="{{ route('product-category.show', $cat->slug) }}"
                                        class="product-detail__chip">{{ $cat->name }}</a>
                                @empty
                                    @if ($product->category)
                                        <a href="{{ route('product-category.show', $product->category->slug) }}"
                                            class="product-detail__chip">{{ $product->category->name }}</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                @endforelse
                            </div>
                        </div>
                        <hr class="my-2">

                        @if (!empty($product->short_description))
                            <div class="product-detail__short mb-2">
                                {!! $product->short_description !!}
                            </div>
                        @endif

                       

                        @if ($productSpecs->isNotEmpty())
                            <div class="product-detail__specs mb-2">
                                @foreach ($productSpecs as $label => $value)
                                    <div class="product-detail__spec-row">
                                        <div class="product-detail__spec-label">{{ $label }}</div>
                                        <div class="product-detail__spec-value">{{ $value }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @php
                            $detailFeatures = $product->features->sortBy(
                                fn ($f) => sprintf('%010d|%s', (int) $f->sort_order, strtolower($f->title))
                            );
                        @endphp
                        @if ($detailFeatures->isNotEmpty())
                            <div class="product-detail__highlights mb-2">
                                <div class="row g-3">
                                    @foreach ($detailFeatures as $detailFeature)
                                        <div class="col-12 col-sm-6">
                                            <div class="product-detail__highlight-item">
                                                <span class="product-detail__highlight-icon">
                                                    @if ($detailFeature->image)
                                                        <img src="{{ asset('storage/' . $detailFeature->image) }}"
                                                            alt="" width="40" height="40" loading="lazy">
                                                    @else
                                                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                                                    @endif
                                                </span>
                                                <span>{{ $detailFeature->title }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <hr class="my-2">


                        <div class="mb-2">
                            <label for="productQuantity" class="form-label fw-semibold">Quantity</label>
                            <input type="number" name="quantity" id="productQuantity"
                                class="form-control product-detail__qty" min="1" step="1" value="1"
                                inputmode="numeric">
                        </div>

                        <div class="d-flex flex-wrap gap-2 gap-md-3 align-items-center product-detail__cta-row">
                            <button type="button" id="productEnquiryBtn" class="btn product-detail__cta-highlight px-4 py-2"
                                data-bs-toggle="modal" data-bs-target="#productEnquiryModal">
                                Enquiry
                            </button>
                            @if (!empty($product->catalogue_path))
                                <a href="{{ asset('storage/' . $product->catalogue_path) }}"
                                    class="btn product-detail__cta-highlight px-4 py-2 text-decoration-none"
                                    target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Catalogue
                                </a>
                            @endif
                            @if (!empty($setting->whatsapp_url))
                                <a href="#" id="productWhatsappBtn"
                                    class="btn product-detail__cta-highlight product-detail__cta-highlight--whatsapp px-4 py-2 text-decoration-none"
                                    target="_blank" rel="noopener noreferrer" data-wa-url="{{ $setting->whatsapp_url }}"
                                    data-product-name="{{ $product->name }}" data-product-sku="{{ $product->sku ?? '' }}">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($product->long_description))
                <div class="row mt-5 pt-4 border-top">
                    <div class="col-12 product-detail__long">
                        <div class="product-detail__long-wrap">
                            <h3 class="h4 fw-bold mb-3">Product details</h3>
                            <div class="product-detail__long-body">
                                {!! $product->long_description !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        @include('frontend.components.home.product-grid', [
            'sectionTitle' => 'Related products',
            'sectionDescription' => 'More from the same categories.',
            'products' => $relatedProducts,
            'sectionId' => 'related-products',
        ])
    @endif

    <div class="modal fade" id="productEnquiryModal" tabindex="-1" aria-labelledby="productEnquiryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="productEnquiryModalLabel">Enquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('product-enquiry.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Product Name</div>
                            <div class="fw-semibold">{{ $product->name }}</div>
                        </div>

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-3">
                            <label for="enquiryName" class="form-label">Name</label>
                            <input type="text" id="enquiryName" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="enquiryPhone" class="form-label">Phone Number</label>
                            <input type="text" id="enquiryPhone" name="phone"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="enquiryQuantity" class="form-label">Quantity</label>
                            <input type="number" id="enquiryQuantity" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror" min="1"
                                step="1" value="{{ old('quantity', 1) }}" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="enquiryMessage" class="form-label">Message</label>
                            <textarea id="enquiryMessage" name="message" class="form-control @error('message') is-invalid @enderror"
                                rows="4">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn product-detail__cta-highlight px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@include('frontend.components.home.sticky-enquiry')

@endsection

@push('scripts')
    <script>
        (function() {
            var main = document.getElementById('productMainImage');
            document.querySelectorAll('.product-detail__thumb').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var src = btn.getAttribute('data-src');
                    if (main && src) main.src = src;
                    document.querySelectorAll('.product-detail__thumb').forEach(function(b) {
                        b.classList.toggle('is-active', b === btn);
                    });
                });
            });

            var qty = document.getElementById('productQuantity');
            var enq = document.getElementById('productEnquiryBtn');
            var wa = document.getElementById('productWhatsappBtn');
            var enquiryQty = document.getElementById('enquiryQuantity');
            var hasErrors = @json($errors->any());

            function quantityValue() {
                var n = qty ? parseInt(qty.value, 10) : 1;
                return isNaN(n) || n < 1 ? 1 : n;
            }

            function syncLinks() {
                var n = quantityValue();
                if (enquiryQty) enquiryQty.value = String(n);
                if (wa && wa.getAttribute('data-wa-url')) {
                    var base = wa.getAttribute('data-wa-url');
                    var name = wa.getAttribute('data-product-name') || '';
                    var sku = wa.getAttribute('data-product-sku') || '';
                    var lines = ["Hello! I'd like to enquire about:", name];
                    if (sku) lines.push('SKU: ' + sku);
                    lines.push('Quantity: ' + n);
                    var msg = lines.join('\n');
                    wa.href = base + (base.indexOf('?') >= 0 ? '&' : '?') + 'text=' + encodeURIComponent(msg);
                }
            }

            if (qty) qty.addEventListener('input', syncLinks);
            if (enq) {
                enq.addEventListener('click', function() {
                    syncLinks();
                });
            }
            syncLinks();

            if (hasErrors && window.bootstrap) {
                var modalEl = document.getElementById('productEnquiryModal');
                if (modalEl) {
                    var modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            }
        })();
    </script>
@endpush
