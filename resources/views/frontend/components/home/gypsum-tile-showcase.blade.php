@include('frontend.components.home.category-showcase-item', [
    'slugPrefix' => 'gypsum-tile',
    'titleImageUrl' => asset('images/gypsum.png'),
    // 'sectionTitle' => 'Gypsum Tile',
    'sectionDescription' => 'Explore premium gypsum tile solutions for clean and modern ceiling finishes.',
    'rightSliderImages' => [
        asset('images/n1.jpeg'),
        asset('images/n2.jpeg'),
        asset('images/n3.jpeg'),
    ],
])
