@extends('layouts.app')
@section('page_title', 'Roles')
@section('content')

<a href="{{ route('backend.roles.create') }}" class="btn btn-dark mb-3">Add Role</a>

<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>

    @foreach($roles as $role)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a href="{{ route('backend.roles.edit',$role->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('backend.roles.destroy',$role->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection