@extends('frontend.layouts.app')
@section('content')
    <div class="home-premium">
        {{-- Page content --}}
        @include('frontend.components.slider')

        @include('frontend.components.home.about')
        @include('frontend.components.home.counter')
        @include('frontend.components.home.services')

        
        @include('frontend.components.home.whyus')

        @include('frontend.components.home.gypsum-tile-showcase')
        @include('frontend.components.home.ceiling-products')

        @include('frontend.components.home.t-grid-showcase')
        @include('frontend.components.home.t-grid-products')

        @include('frontend.components.home.soffit-panel-showcase')
        @include('frontend.components.home.soffit-panel-products')

        @include('frontend.components.home.fluted-panel-showcase')
        @include('frontend.components.home.fluted-panel-products')

        

        

        @include('frontend.components.home.applications', ['applicationIds' => [1]])

        @include('frontend.components.home.applications', ['applicationIds' => [2]])

        @include('frontend.components.home.greview')
        @include('frontend.components.home.contact-us')
        @include('frontend.components.home.sticky-enquiry')
    </div>
@endsection
