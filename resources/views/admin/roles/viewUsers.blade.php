@extends('mainLayout')

@section('title', 'Roles with Users')

@section('page-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Users with Role: {{ $role->name }}</h1>
        <a href="{{ route('roles.index') }}" class="link-dark">Back</a>
    </div>

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
</div>
@endsection