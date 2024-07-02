@extends('mainLayout')

@section('title', 'Manage Roles')

@section('page-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manage Roles and Permissions</h1>
        <a href="{{ route('usertool') }}" class="link-dark">Back</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <p>
        <a href="{{ route('usertool') }}" class="link-primary">Manage Users and Roles</a>
    </p>
    <p>
        <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Create New Role</a>
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach($role->permissions as $permission)
                            <p>{{ $permission->name }}</p>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('roles.viewUsers', $role->id) }}" class="btn btn-sm btn-primary">View Users</a>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('roles.delete', $role->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection