@include('frontend.components.home.product-grid', [
    'sectionTitle' => 'Gypsum Tile Products',
    'products' => $gypsumTileProducts,
    'viewAllUrl' => $gypsumTileCategoryUrl ?? route('products'),
    'sectionId' => 'gypsum-tile-products',
    'headerSplit' => true,
])
