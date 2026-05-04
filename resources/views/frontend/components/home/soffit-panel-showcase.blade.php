@include('frontend.components.home.category-showcase-item', [
    'slugPrefix' => 'soffit-panels',
    // 'titleImageUrl' => asset('images/home/soffit-panel/dg.png'),
    'sectionTitle' => 'Soffit Panels',
    'sectionDescription' => 'Soffit panels are designed to enhance ceilings with a premium wooden look while ensuring long-lasting performance. Suitable for both interior and semi-exterior applications, they provide a clean, structured finish with minimal maintenance.',
    'rightSliderImages' => [
        asset('images/home/soffit-panel/s1.jpg'),
        asset('images/home/soffit-panel/s2.jpg'),
        asset('images/home/soffit-panel/s3.jpg'),
    ],
])
