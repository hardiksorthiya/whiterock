@extends('layouts.app')

@section('content')

<h4>{{ isset($productCategory) ? 'Edit Product Category' : 'Create Product Category' }}</h4>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" 
      action="{{ isset($productCategory) ? route('backend.product-categories.update',$productCategory->id) : route('backend.product-categories.store') }}"
      enctype="multipart/form-data">
    
    @csrf
    @if(isset($productCategory)) @method('PUT') @endif

    <!-- Name -->
    <input type="text" name="name" 
        value="{{ old('name', $productCategory->name ?? '') }}" 
        class="form-control mb-3" placeholder="Name">

    <!-- Image -->
    <input type="file" name="image" class="form-control mb-3">

    <button class="btn btn-dark">
        {{ isset($productCategory) ? 'Update' : 'Save' }}
    </button>

</form>

@endsection