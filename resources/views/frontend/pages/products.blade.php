@extends('frontend.layouts.app')
@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'PRODUCTS',
        'image' => asset('images/nproduct.jpeg'),
    ])

    @include('frontend.components.products.category-nav', [
        'productCategories' => $productCategories,
        'activeSlug' => null,
    ])

    <section class="products-page-main py-4 py-lg-5 bg-white">
        <div class="container">
            @include('frontend.components.products.products-toolbar', [
                'toolbarLabel' => 'All products',
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

@include('frontend.components.home.sticky-enquiry')

@endsection
