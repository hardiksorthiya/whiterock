@extends('frontend.layouts.app')
@section('content')
@include('frontend.components.breadcrumb', [
        'title' => 'ABOUT US',
        'image' => asset('frontend/images/about-banner.jpg')
    ])
    @include('frontend.components.about.about')
    @include('frontend.components.about.mission-vision-values')
    @include('frontend.components.about.counter')
    @include('frontend.components.about.roadmap')
    @include('frontend.components.about.founder')
@endsection