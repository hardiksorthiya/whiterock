@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Gypsum Tile Products',
    'sectionDescription' =>
        'Featured ceiling solutions — our latest picks from the ceiling category.',
    'products' => $ceilingProducts,
    'viewAllUrl' => $ceilingCategoryUrl ?? route('products'),
    'sectionId' => 'ceiling-products',
])
