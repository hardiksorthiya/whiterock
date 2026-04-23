@include('frontend.components.home.category-showcase-item', [
    'slugPrefix' => 'gypsum-tile',
    'titleImageUrl' => asset('images/home/gypsum/Gypsum_tile_01.png'),
    // 'sectionTitle' => 'Gypsum Tile',
    'sectionDescription' => 'Explore premium gypsum tile solutions for clean and modern ceiling finishes.',
    'rightSliderImages' => [
        asset('images/home/gypsum/Nivoc_slider_01.jpg'),
        asset('images/home/gypsum/Nivoc_slider_02.jpg'),
        asset('images/home/gypsum/Nivoc_slider_03.jpg'),
        asset('images/home/gypsum/Nivoc_slider_04.jpg'),
    ],
])
