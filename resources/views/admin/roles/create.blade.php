@extends('mainLayout')

@section('title','Create Role')

@section('page-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Create New Role</h1>
            <a href="{{ route('roles.index') }}" class="link-dark">Back</a>
        </div>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div>
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="permissions" class="form-label">Permissions</label>
                <div class="form-check">
                    @foreach($permissions as $permission)
                        <input type="checkbox" class="form-check-input" id="permission_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}">
                        <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label><br>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>
@endsection
