@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Panel products',
    'sectionDescription' => 'Featured panel range — our latest picks from the panel category.',
    'products' => $panelProducts,
    'sectionId' => 'panel-products',
])
