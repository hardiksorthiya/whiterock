@extends('frontend.layouts.app')
@section('content')
@include('frontend.components.breadcrumb', [
        'title' => 'ABOUT US',
        'image' => asset('frontend/images/about-banner.jpg')
    ])
@endsection