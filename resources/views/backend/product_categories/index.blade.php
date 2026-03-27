@extends('layouts.app')
@section('page_title', 'Product Categories')
@section('content')
<a href="{{ route('backend.product-categories.create') }}" class="btn btn-dark mb-3">Add Product Category</a>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>

    @foreach($productCategories as $productCategory)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $productCategory->name }}</td>
        <td>{{ $productCategory->slug }}</td>
        <td>
            @if($productCategory->image)
                <img src="{{ asset('storage/' . $productCategory->image) }}" alt="{{ $productCategory->name }}" width="100">
            @else
                No Image
            @endif
        </td>
        <td>
            <a href="{{ route('backend.product-categories.edit',$productCategory->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('backend.product-categories.destroy',$productCategory->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach