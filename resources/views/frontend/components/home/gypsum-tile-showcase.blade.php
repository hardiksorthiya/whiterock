@include('frontend.components.home.category-showcase-item', [
    'slugPrefix' => 'gypsum-tile',
    // 'titleImageUrl' => asset('images/home/gypsum/gd.png'),
    'sectionTitle' => 'Gypsum Ceiling Tiles',
    'sectionDescription' => 'Gypsum ceiling tiles offer a clean and efficient solution for modern interiors. Designed for uniform finish and easy installation, they are ideal for commercial and residential spaces. With consistent quality, they help achieve a refined ceiling with long-term performance.',
    'rightSliderImages' => [
        asset('images/home/gypsum/n1.jpg'),
        asset('images/home/gypsum/n2.jpg'),
        asset('images/home/gypsum/n3.jpg'),
        asset('images/home/gypsum/n4.jpg'),
    ],
])
