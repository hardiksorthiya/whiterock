{{-- $products, optional $showSectionHeader, $sectionTitle, $sectionDescription --}}
@php
    $showSectionHeader = $showSectionHeader ?? false;
    $sectionTitle = $sectionTitle ?? 'Products';
    $sectionDescription =
        $sectionDescription ??
        'Select a product to view details, specifications, and enquiry options.';
    $tones = ['a', 'b', 'c', 'd', 'e', 'f'];
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

<div class="product-section--visual-grid products-listing-visual">
    <div class="row g-3 g-md-4 products-grid-wrap" id="productsListingGrid" data-current-view="grid-3">
        @forelse ($products as $product)
            @php
                $tone = $tones[$loop->index % 6];
                $detailUrl = route('product.show', $product->slug);
                $tagline = $product->short_description ?? null;
                $tagline = $tagline ? \Illuminate\Support\Str::limit(trim(strip_tags($tagline)), 110) : null;
            @endphp
            <div class="product-col col-12 col-sm-6 col-lg-4">
                <div class="product-visual-block product-catalog-card h-100">
                    <a href="{{ $detailUrl }}" class="product-visual-block__media text-reset text-decoration-none d-block">
                        <div class="product-card__frame product-card__frame--tone-{{ $tone }}">
                            <div class="product-img product-img--visual">
                                @if (!empty($product->featured_image))
                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                        class="product-card__visual-img"
                                        alt="{{ $product->name }}"
                                        loading="lazy">
                                @elseif (!empty($product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="product-card__visual-img"
                                        alt="{{ $product->name }}"
                                        loading="lazy">
                                @else
                                    <div class="product-card__visual-placeholder">
                                        <span>No image</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                    <div class="product-visual-block__meta text-center">
                        <a href="{{ $detailUrl }}" class="product-visual-block__title-link text-decoration-none">
                            <h3 class="product-visual-block__title">{{ $product->name }}</h3>
                        </a>
                        @if (!empty($tagline))
                            <p class="product-visual-block__tagline">{{ $tagline }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                No products to show here yet.
            </div>
        @endforelse
    </div>
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
                    var block = col.querySelector('.product-visual-block');
                    if (block) {
                        if (view === 'list') {
                            block.classList.add('product-visual-block--list');
                        } else {
                            block.classList.remove('product-visual-block--list');
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
