@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => $category->name,
        'subtitle' => 'Products in this category',
        'image' => asset('images/nproduct.jpeg'),
        'crumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products')],
            ['label' => $category->name, 'url' => null],
        ],
    ])

    @include('frontend.components.products.category-nav', [
        'productCategories' => $productCategories,
        'activeSlug' => $category->slug,
    ])

    <section class="products-page-main py-4 py-lg-5 bg-white">
        <div class="container">
            @include('frontend.components.products.products-toolbar', [
                'toolbarLabel' => $category->name,
                'sort' => $sort,
                'perPage' => $perPage,
            ])
            @include('frontend.components.products.products-listing', [
                'products' => $products,
                'showSectionHeader' => false,
            ])
        </div>
    </section>

    @if ($products->hasPages())
        <div class="container pb-5">
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    @endif
@endsection
