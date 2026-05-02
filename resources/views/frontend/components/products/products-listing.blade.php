{{-- $products, optional $showSectionHeader, $sectionTitle, $sectionDescription --}}
@php
    $showSectionHeader = $showSectionHeader ?? false;
    $sectionTitle = $sectionTitle ?? 'Products';
    $sectionDescription =
        $sectionDescription ??
        'Select a product to view details, specifications, and enquiry options.';
@endphp

@if ($showSectionHeader)
    <div class="row mb-4">
        <div class="col position-relative">
            <div class="sorath-section-header text-center">
                <h2 class="sorath-title">{{ $sectionTitle }}</h2>
                <p class="sorath-desc">{{ $sectionDescription }}</p>
            </div>
        </div>
    </div>
@endif

<div class="row g-4 products-grid-wrap" id="productsListingGrid" data-current-view="grid-3">
    @forelse ($products as $product)
        <div class="product-col col-12 col-sm-6 col-lg-4">
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
                    <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">
                        <h6 class="fw-semibold product-card__title mb-0">{{ $product->name }}</h6>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-5">
            No products to show here yet.
        </div>
    @endforelse
</div>

@push('scripts')
    <script>
        (function() {
            var storageKey = 'whiterock_products_view';
            var grid = document.getElementById('productsListingGrid');
            if (!grid) return;

            function colsForView(view) {
                if (view === 'grid-4') {
                    return ['col-12', 'col-sm-6', 'col-md-4', 'col-lg-3'];
                }
                if (view === 'grid-2') {
                    return ['col-12', 'col-md-6'];
                }
                if (view === 'list') {
                    return ['col-12'];
                }
                return ['col-12', 'col-sm-6', 'col-lg-4'];
            }

            function applyView(view) {
                grid.setAttribute('data-current-view', view);
                var cards = grid.querySelectorAll('.product-col');
                var classes = colsForView(view);
                cards.forEach(function(col) {
                    col.className = 'product-col ' + classes.join(' ');
                    var card = col.querySelector('.product-card');
                    if (card) {
                        if (view === 'list') {
                            card.classList.add('product-card--list');
                        } else {
                            card.classList.remove('product-card--list');
                        }
                    }
                });
                document.querySelectorAll('.products-view-btn').forEach(function(btn) {
                    btn.classList.toggle('is-active', btn.getAttribute('data-products-view') === view);
                });
                try {
                    localStorage.setItem(storageKey, view);
                } catch (e) {}
            }

            var initial = 'grid-3';
            try {
                initial = localStorage.getItem(storageKey) || 'grid-3';
            } catch (e) {}
            if (!['grid-3', 'grid-4', 'grid-2', 'list'].includes(initial)) {
                initial = 'grid-3';
            }
            applyView(initial);

            document.querySelectorAll('.products-view-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    applyView(btn.getAttribute('data-products-view'));
                });
            });
        })();
    </script>
@endpush
