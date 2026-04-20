@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'T-Grid Products',
    'sectionDescription' =>
        'Featured T-Grid solutions — our latest picks from the T-Grid category.',
    'products' => $tGridProducts,
    'viewAllUrl' => $tGridCategoryUrl ?? route('products'),
    'sectionId' => 'T-Grid Products',
])
