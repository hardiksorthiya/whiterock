@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'GALLERY',
        'image' => asset('images/breadcrumb/nivoc_heading_banner_06.jpg'),
    ])

    <div class="container py-5">

        @if (! empty($galleryApplicationCards))
            <div class="text-center mb-4 mb-lg-5">
                <p class="gallery-page__lead text-secondary mb-0 mx-auto" style="max-width: 42rem;">
                    Choose an application to open its gallery. Inside, use category tabs — <strong>All</strong> or each linked gallery category — just like before.
                </p>
            </div>

            <div class="row gallery-page-apps justify-content-center g-4">
                @foreach ($galleryApplicationCards as $card)
                    <div class="col-sm-6 col-xl-6">
                        <a href="{{ route('gallery.application.show', $card['id']) }}"
                            class="home-applications__card gallery-page__app-card d-block w-100 text-decoration-none text-reset"
                            aria-label="Open gallery for {{ $card['name'] }}">
                            <img src="{{ $card['cover'] }}" alt="{{ $card['name'] }}" class="home-applications__card-img">
                            <span class="home-applications__card-name">{{ $card['name'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Fallback when no backend applications exist --}}
            <div class="text-center mb-4">
                <button class="filter-btn active" type="button" data-filter="all">All</button>

                @foreach ($categories as $cat)
                    <button class="filter-btn" type="button" data-filter="cat-{{ $cat->id }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <div class="row gallery-container">
                @foreach ($categories as $cat)
                    @foreach ($cat->images as $img)
                        <div class="col-md-4 mb-4 gallery-item cat-{{ $cat->id }}">
                            <img src="{{ asset('storage/' . $img->image) }}" class="img-fluid rounded" alt="">
                        </div>
                    @endforeach
                @endforeach
            </div>

            <script>
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        let filter = this.getAttribute('data-filter');

                        document.querySelectorAll('.gallery-item').forEach(item => {
                            if (filter === 'all' || item.classList.contains(filter)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                });
            </script>
        @endif

    </div>

    @include('frontend.components.home.sticky-enquiry')

@endsection
