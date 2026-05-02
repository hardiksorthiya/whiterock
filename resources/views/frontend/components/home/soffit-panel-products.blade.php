@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Soffit Panel Products',
    'products' => $soffitPanelProducts,
    'viewAllUrl' => $soffitPanelCategoryUrl ?? route('products'),
    'sectionId' => 'Soffit Panel Products',
    'headerSplit' => true,
])
