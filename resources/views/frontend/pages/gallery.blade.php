@extends('frontend.layouts.app')

@section('content')

<!-- Breadcrumb -->
@include('frontend.components.breadcrumb', [
    'title' => 'GALLERY',
    'image' => asset('frontend/images/gallery-banner.jpg')
])

<div class="container py-5">

    <!-- Tabs -->
    <div class="text-center mb-4">
        <button class="filter-btn active" data-filter="all">All</button>

        @foreach($categories as $cat)
            <button class="filter-btn" data-filter="cat-{{ $cat->id }}">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>

    <!-- Gallery Grid -->
    <div class="row gallery-container">

        @foreach($categories as $cat)
            @foreach($cat->images as $img)
                <div class="col-md-4 mb-4 gallery-item cat-{{ $cat->id }}">
                    <img src="{{ asset('storage/'.$img->image) }}" class="img-fluid rounded">
                </div>
            @endforeach
        @endforeach

    </div>

</div>
    <script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {

        // Active button
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
@endsection