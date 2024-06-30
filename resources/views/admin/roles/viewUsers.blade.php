@extends('mainLayout')

@section('title', 'Roles with Users')

@section('page-content')
<div class="container-fluid">
    <h1>Users with Role: {{ $role->name }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->userInfo->user_firstname . ' ' . $user->userInfo->user_lastname }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        <a href="{{ route('roles.index') }}" class="link-dark">Back to Roles</a>
    </p>
</div>
@endsection