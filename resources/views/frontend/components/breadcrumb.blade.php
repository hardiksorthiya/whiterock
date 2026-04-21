<section class="breadcrumb-section">
    <div class="breadcrumb-section__bg"
        style="background-image: url('{{ $image ?? asset('default.jpg') }}');"
        role="presentation"
        aria-hidden="true"></div>

    <div class="container breadcrumb-section__inner">
        <div class="breadcrumb-content text-center">

            @if (!empty($crumbs))
                <nav aria-label="Breadcrumb" class="breadcrumb-nav d-flex justify-content-center mb-3">
                    <ol class="breadcrumb breadcrumb-nav__list mb-0">
                        @foreach ($crumbs as $crumb)
                            <li class="breadcrumb-item @if ($loop->last) active @endif"
                                @if ($loop->last) aria-current="page" @endif>
                                @if (!$loop->last && !empty($crumb['url']))
                                    <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                                @else
                                    {{ $crumb['label'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            <h1>{{ $title ?? 'Page Title' }}</h1>

            @if (isset($subtitle))
                <p>{{ $subtitle }}</p>
            @endif

        </div>
    </div>

</section>
