@include('frontend.components.home.category-showcase-item', [
    'slugPrefix' => 'gypsum-tile',
    'titleImageUrl' => asset('images/home/gypsum/gd.png'),
    // 'sectionTitle' => 'Gypsum Tile',
    'sectionDescription' => 'Explore premium gypsum tile solutions for clean and modern ceiling finishes.',
    'rightSliderImages' => [
        asset('images/home/gypsum/n1.jpg'),
        asset('images/home/gypsum/n2.jpg'),
        asset('images/home/gypsum/n3.jpg'),
        asset('images/home/gypsum/n4.jpg'),
    ],
])
