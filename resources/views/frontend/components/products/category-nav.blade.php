{{-- $productCategories (collection), $activeSlug (null = Shop all) --}}
@if ($productCategories->isNotEmpty())
    <section class="category-nav-section py-4 py-lg-5 border-bottom bg-white">
        <div class="container">
            <div class="category-nav-scroll d-flex justify-content-center justify-content-lg-start flex-nowrap gap-4 gap-lg-5 pb-1">
                <a href="{{ route('products') }}"
                    class="category-nav-item text-decoration-none text-center flex-shrink-0 @if ($activeSlug === null) is-active @endif">
                    <div class="category-nav-item__circle category-nav-item__circle--all mx-auto">
                        <span class="category-nav-item__all-text">ALL</span>
                    </div>
                    <span class="category-nav-item__label d-block mt-2">Shop All</span>
                </a>
                @foreach ($productCategories as $pc)
                    <a href="{{ route('product-category.show', $pc->slug) }}"
                        class="category-nav-item text-decoration-none text-center flex-shrink-0 @if ((string) $activeSlug === (string) $pc->slug) is-active @endif">
                        <div class="category-nav-item__circle mx-auto">
                            @if (!empty($pc->image))
                                <img src="{{ asset('storage/' . $pc->image) }}" alt="{{ $pc->name }}"
                                    class="category-nav-item__img" loading="lazy">
                            @else
                                <span class="category-nav-item__placeholder"
                                    aria-hidden="true">{{ strtoupper(substr($pc->name, 0, 2)) }}</span>
                            @endif
                        </div>
                        <span class="category-nav-item__label d-block mt-2">{{ $pc->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
