@if ($paginator->hasPages())
    <nav class="products-pager" aria-label="Product results pages">
        <div class="d-flex justify-content-between flex-fill d-sm-none align-items-center gap-2">
            <p class="products-pager__summary products-pager__summary--compact mb-0 small">
                <span class="products-pager__num">{{ $paginator->firstItem() }}</span>–<span class="products-pager__num">{{ $paginator->lastItem() }}</span>
                <span class="text-muted"> / </span>
                <span class="products-pager__num">{{ $paginator->total() }}</span>
            </p>
            <ul class="pagination products-pager__pagination mb-0">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link products-pager__arrow" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link products-pager__arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page"><i class="bi bi-chevron-left"></i></a>
                    </li>
                @endif
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link products-pager__arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page"><i class="bi bi-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link products-pager__arrow" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none d-sm-flex align-items-center justify-content-between gap-3 flex-wrap">
            <p class="products-pager__summary mb-0">
                Showing
                <strong class="products-pager__num">{{ $paginator->firstItem() }}</strong>
                to
                <strong class="products-pager__num">{{ $paginator->lastItem() }}</strong>
                of
                <strong class="products-pager__num">{{ $paginator->total() }}</strong>
                results
            </p>

            <ul class="pagination products-pager__pagination mb-0">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link products-pager__arrow" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link products-pager__arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page"><i class="bi bi-chevron-left"></i></a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link products-pager__arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page"><i class="bi bi-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link products-pager__arrow" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
