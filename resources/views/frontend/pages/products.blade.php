@extends('frontend.layouts.app')
@section('content')
@include('frontend.components.breadcrumb', [
        'title' => 'PRODUCTS',
        'image' => asset('frontend/images/products-banner.jpg')
    ])
    @include('frontend.components.home.product')
@endsection