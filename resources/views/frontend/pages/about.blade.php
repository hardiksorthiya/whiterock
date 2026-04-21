@extends('frontend.layouts.app')
@section('content')
@include('frontend.components.breadcrumb', [
        'title' => 'ABOUT US',
        'image' => asset('images/a3.png')
    ])
    @include('frontend.components.about.about')
    @include('frontend.components.about.counter')

    @include('frontend.components.about.what-makes-nivoc')
    @include('frontend.components.about.complete-system')
    @include('frontend.components.about.roadmap-scroll')
    @include('frontend.components.about.mission-vision-values')
    @include('frontend.components.about.our-expertise')
    @include('frontend.components.about.our-presence')

    @include('frontend.components.about.founder')
    @include('frontend.components.home.contact-us')
    @include('frontend.components.home.sticky-enquiry')
@endsection