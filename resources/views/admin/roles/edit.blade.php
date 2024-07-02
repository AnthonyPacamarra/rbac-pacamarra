@extends('mainLayout')

@section('title','Edit Role')

@section('page-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Edit Role: {{ $role->name }}</h1>
            <a href="{{ route('roles.index') }}" class="link-dark">Back</a>
        </div>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $role->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="form-label">Permissions</label>
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}"
                        {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>
@endsection
