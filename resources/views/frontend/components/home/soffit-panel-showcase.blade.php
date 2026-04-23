@include('frontend.components.home.category-showcase-item', [
    'slugPrefix' => 'soffit-panel',
    'titleImageUrl' => asset('images/home/soffit-panel/dg.png'),
    // 'sectionTitle' => 'soffit-panel Systems',
    'sectionDescription' => 'Browse durable soffit-panel systems built for reliable ceiling framework support.',
    'rightSliderImages' => [
        asset('images/home/soffit-panel/n1.jpg'),
        asset('images/home/soffit-panel/n2.jpg'),
        asset('images/home/soffit-panel/n3.jpg'),
        asset('images/home/soffit-panel/n4.jpg'),
    ],
])
