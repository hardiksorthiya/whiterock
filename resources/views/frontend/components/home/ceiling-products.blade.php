@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Ceiling products',
    'sectionDescription' =>
        'Featured ceiling solutions — our latest picks from the ceiling category.',
    'products' => $ceilingProducts,
    'sectionId' => 'ceiling-products',
])
