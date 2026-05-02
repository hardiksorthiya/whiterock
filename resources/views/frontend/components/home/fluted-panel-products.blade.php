@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Fluted Panel Products',
    'products' => $flutedPanelProducts,
    'viewAllUrl' => $flutedPanelCategoryUrl ?? route('products'),
    'sectionId' => 'fluted-panel-products',
    'headerSplit' => true,
])
