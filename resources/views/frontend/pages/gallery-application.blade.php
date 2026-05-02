@extends('frontend.layouts.app')

@php
    $breadcrumbCrumbs = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Gallery', 'url' => route('gallery')],
        ['label' => $application->name, 'url' => null],
    ];
@endphp

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => strtoupper($application->name),
        'subtitle' => 'Browse photos by gallery category linked to this application.',
        'image' => asset('images/ngallery.jpeg'),
        'crumbs' => $breadcrumbCrumbs,
    ])

    <div class="container py-5">
        <div class="mb-4">
            <a href="{{ route('gallery') }}" class="gallery-application__back text-decoration-none fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> All applications
            </a>
        </div>

        @if ($galleryCategories->isEmpty())
            <div class="alert alert-light border text-center py-5 mb-0">
                <p class="mb-2 fw-semibold text-secondary">No gallery categories linked to this application yet.</p>
                <p class="small text-muted mb-0">Update it in the backend under Appearance → Application.</p>
            </div>
        @else
            <div class="text-center mb-4">
                <button class="filter-btn active" type="button" data-filter="all">All</button>

                @foreach ($galleryCategories as $cat)
                    <button class="filter-btn" type="button" data-filter="cat-{{ $cat->id }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <div class="row gallery-container">
                @foreach ($galleryCategories as $cat)
                    @foreach ($cat->images as $img)
                        <div class="col-md-4 mb-4 gallery-item cat-{{ $cat->id }}">
                            <img src="{{ asset('storage/' . $img->image) }}" class="img-fluid rounded"
                                alt="{{ $cat->name }}">
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
