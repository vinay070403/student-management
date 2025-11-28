@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="row">
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5" style="border-color:#adb5bd;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Edit Role</h3>

                    <a href="{{ route('rolesPermission.index') }}"
                        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                    </a>

                </div>

                <div class="container-fluid">
                    <form id="roleForm" method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Role Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}"
                                required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Display Name --}}
                        <div class="mb-3">
                            <label for="display_name" class="form-label">Display Name</label>
                            <input type="text" name="display_name" class="form-control"
                                value="{{ old('display_name', $role->display_name) }}">
                            @error('display_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Permission Groups --}}
                        <div class="mt-4">
                            <h5 class="mb-3">Assign Permissions</h5>

                            @foreach ($permissionGroups as $group)
                                <div class="border p-3 rounded mb-3">
                                    <h6 class="fw-bold">{{ $group->name }}</h6>

                                    <div class="row mt-2">
                                        @foreach ($group->permissions as $permission)
                                            <div class="col-md-3">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="permission[]"
                                                        value="{{ $permission->id }}"
                                                        {{ in_array($permission->id, old('permission', $rolePermissions)) ? 'checked' : '' }}>
                                                    {{ $permission->display_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            @error('permission')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Role</button>
                            <a href="{{ route('rolesPermission.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div> <!-- container-fluid -->
            </div> <!-- white card -->
        </div> <!-- app-wrapper -->
    </div> <!-- row -->
@endsection
