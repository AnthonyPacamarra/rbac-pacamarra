@extends('mainLayout')

@section('title','Manage Users')

@section('page-content')
<div class="container-fluid">
    <h1>Manage Users</h1>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('updateRoles') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    @foreach($roles as $role)
                        <th>{{ $role->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->userInfo->user_firstname.' '.$user->userInfo->user_lastname }}</td>
                        <td>{{ $user->email }}</td>
                        @foreach($roles as $role)
                            <td>
                                <input type="checkbox" name="roles[{{ $user->id }}][]" value="{{ $role->id }}"
                                {{ $user->roles->contains($role) ? 'checked' : '' }}>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Update Roles</button>
    </form>
    <p>
        <a href="{{ route('dash') }}" class="link-dark">Back</a>
    </p>
</div>
@endsection
