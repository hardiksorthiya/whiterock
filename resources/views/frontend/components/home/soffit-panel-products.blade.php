@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Soffit Panel Products',
    'sectionDescription' =>
        'Featured Soffit Panel solutions — our latest picks from the Soffit Panel category.',
    'products' => $soffitPanelProducts,
    'viewAllUrl' => $soffitPanelCategoryUrl ?? route('products'),
    'sectionId' => 'Soffit Panel Products',
])
