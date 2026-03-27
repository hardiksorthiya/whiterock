@extends('layouts.app')
@section('page_title', 'Users')
@section('content')

<a href="{{ route('backend.users.create') }}" class="btn btn-dark mb-3">Add User</a>

<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->roles->pluck('name')->first() }}</td>
        <td>
            <a href="{{ route('backend.users.edit',$user->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('backend.users.destroy',$user->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection