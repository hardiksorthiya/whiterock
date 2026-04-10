@extends('frontend.layouts.app')
@section('content')
    <div class="home-premium">
        {{-- Page content --}}
        @include('frontend.components.slider')
        @include('frontend.components.home.about')
        @include('frontend.components.home.services')
        @include('frontend.components.home.ceiling-products')
        @include('frontend.components.home.protfolio')
        @include('frontend.components.home.panel-products')
        @include('frontend.components.home.product')
        @include('frontend.components.home.whyus')
        @include('frontend.components.home.greview')
    </div>
@endsection