@include('frontend.components.home.category-showcase-item', [
    'slugPrefix' => 'soffit-panel',
    'titleImageUrl' => asset('images/home/soffit-panel/dg.png'),
    // 'sectionTitle' => 'soffit-panel Systems',
    'sectionDescription' => 'Browse durable soffit-panel systems built for reliable ceiling framework support.',
    'rightSliderImages' => [
        asset('images/home/soffit-panel/Nivoc_slider_01.jpg'),
        asset('images/home/soffit-panel/Nivoc_slider_02.jpg'),
        asset('images/home/soffit-panel/Nivoc_slider_03.jpg'),
        asset('images/home/soffit-panel/Nivoc_slider_04.jpg'),
    ],
])
