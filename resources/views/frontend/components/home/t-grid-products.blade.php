@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'T-Grid Products',
    'products' => $tGridProducts,
    'viewAllUrl' => $tGridCategoryUrl ?? route('products'),
    'sectionId' => 'T-Grid Products',
    'headerSplit' => true,
])
