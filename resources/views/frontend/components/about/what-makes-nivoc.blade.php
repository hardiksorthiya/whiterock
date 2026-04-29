@php
    $points = [
        [
            'title' => 'Consistent Quality',
            'description' => 'Delivering the same standard across every batch.',
        ],
        [
            'title' => 'Reliable Supply',
            'description' => 'Strong network ensuring timely availability.',
        ],
        [
            'title' => 'Built for Scale',
            'description' => 'Ready to support bulk and large-scale projects.',
        ],
        [
            'title' => 'Efficient Processes',
            'description' => 'Smooth coordination and faster execution.',
        ],
        [
            'title' => 'Backed by Experience',
            'description' => 'Powered by WhiteRock’s proven industry expertise.',
        ],
        [
            'title' => 'Built for Execution',
            'description' => 'Designed around real project and dealer needs.',
        ],
    ];
@endphp

<section class="nivoc-different-section py-5">
    <div class="container">
        <div class="row align-items-center g-4 g-xl-5">
            <div class="col-lg-6 order-lg-1">
                <p class="sorath-small-title mb-2 text-uppercase small">What Makes NIVOC Different</p>
                <h2 class="sorath-title mb-4">Why Professionals Choose NIVOC</h2>
                <div class="row g-3">
                    @foreach ($points as $point)
                        <div class="col-md-6">
                            <div class="d-flex gap-3 nivoc-diff-point">
                                <span class="nivoc-diff-point__icon" aria-hidden="true">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                                <span class="nivoc-diff-point__text">
                                    <strong>{{ $point['title'] }}</strong><br>
                                    {{ $point['description'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 order-lg-2">
                <div class="nivoc-diff-media ratio ratio-4x3 rounded-4 overflow-hidden shadow">
                    <img src="{{ asset('images/h1.jpeg') }}" class="w-100 h-100 object-fit-cover"
                        alt="NIVOC ceiling and interior systems">
                </div>
            </div>
        </div>
    </div>
</section>
