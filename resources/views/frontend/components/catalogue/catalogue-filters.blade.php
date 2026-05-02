{{-- $catalogueCategories (collection), $activeSlug (null = All) --}}
@if ($catalogueCategories->isNotEmpty())
    <section class="catalogue-filters catalogue-filters--pills py-4 bg-white border-bottom border-light">
        <div class="container">
            <nav aria-label="Catalogue categories">
                <ul class="catalogue-pill-row list-unstyled mb-0 d-flex flex-wrap justify-content-center gap-2 gap-md-3">
                    <li>
                        <a href="{{ route('catalogue') }}"
                            class="catalogue-pill @if ($activeSlug === null) is-active @endif">All</a>
                    </li>
                    @foreach ($catalogueCategories as $cat)
                        <li>
                            <a href="{{ route('catalogue-category.show', $cat->slug) }}"
                                class="catalogue-pill @if ((string) $activeSlug === (string) $cat->slug) is-active @endif">{{ $cat->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </section>
@endif
