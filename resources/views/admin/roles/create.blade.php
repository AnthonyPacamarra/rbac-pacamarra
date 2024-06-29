@extends('mainLayout')

@section('page-content')
    <div class="container-fluid">
        <h1>Create New Role</h1>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
        <p>
            <a href="{{ route('roles.index') }}" class="link-dark">Back to Roles</a>
        </p>
    </div>
@endsection
