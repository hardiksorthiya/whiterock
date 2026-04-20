@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Panel products',
    'sectionDescription' => 'Featured panel range — our latest picks from the panel category.',
    'products' => $panelProducts,
    'viewAllUrl' => $panelCategoryUrl ?? route('products'),
    'sectionId' => 'panel-products',
])
