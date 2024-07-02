@extends('mainLayout')

@section('title','Manage Users')

@section('page-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manage Users and Roles</h1>
        <a href="{{ route('dash') }}" class="link-dark">Back</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <p>
        <a href="{{ route('roles.index') }}" class="link-primary">Manage Roles and Permissions</a>
    </p>
    <form action="{{ route('updateRoles') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Permissions</th>
                    @foreach($roles as $role)
                        <th>{{ $role->name }}</th>
                    @endforeach
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->userInfo->user_firstname.' '.$user->userInfo->user_lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->permissions as $permission)
                               <p>{{ $permission->name }}</p>
                            @endforeach
                        </td>

                        @foreach($roles as $role)
                        <td>
                            <input type="checkbox" name="roles[{{ $user->id }}][]" value="{{ $role->id }}"
                            {{ $user->roles->contains($role) ? 'checked' : '' }}>
                        </td>
                        @endforeach
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete('{{ route('users.delete', $user->id) }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Update Roles</button>
    </form>
</div>

<script>
    function confirmDelete(deleteUrl) {
        if (confirm('Are you sure you want to delete this user?')) {
            let form = document.createElement('form');
            form.action = deleteUrl;
            form.method = 'POST';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

@endsection
