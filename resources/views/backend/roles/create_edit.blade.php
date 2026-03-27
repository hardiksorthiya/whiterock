@extends('layouts.app')

@section('content')

<h4>{{ isset($role) ? 'Edit Role' : 'Create Role' }}</h4>

<form method="POST" 
      action="{{ isset($role) ? route('backend.roles.update',$role->id) : route('backend.roles.store') }}">
    
    @csrf

    @if(isset($role))
        @method('PUT')
    @endif

    <!-- Role Name -->
    <div class="mb-3">
        <label class="form-label">Role Name</label>
        <input type="text" 
               name="name" 
               value="{{ old('name', $role->name ?? '') }}" 
               class="form-control"
               placeholder="Enter role name">

        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Permissions -->
    <h5>Permissions</h5>

    <div class="row">
        @foreach($permissions as $permission)
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" 
                           name="permissions[]" 
                           value="{{ $permission->name }}"
                           class="form-check-input"

                           {{ 
                               isset($rolePermissions) && in_array($permission->name, $rolePermissions) 
                               ? 'checked' : '' 
                           }}>

                    <label class="form-check-label">
                        {{ $permission->name }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Submit -->
    <button class="btn btn-dark mt-3">
        {{ isset($role) ? 'Update' : 'Save' }}
    </button>

</form>

@endsection