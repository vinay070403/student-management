@extends('layouts.app')

@section('title', 'Add Role')

@section('content')
    <div class="row">
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5" style="border-color:#adb5bd;">
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h3>Create Role</h3>

                    <a href="{{ route('rolesPermission.index') }}"
                        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                    </a>

                </div>
                <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
                    <form id="roleForm" method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="row g-3">

                            {{-- Role Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold text-dark">Role Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="please enter the role" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Display Name --}}
                            <div class="col-md-6">
                                <label for="display_name" class="form-label fw-bold text-dark">Display Name</label>
                                <input type="text" name="display_name" class="form-control"
                                    value="{{ old('display_name') }}">
                                @error('display_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">

                                {{-- Permission Groups --}}
                                <div class="mt-0">

                                    <h5 class="mb-3">Roles Permissions</h5>

                                    @foreach ($permissionGroups as $group)
                                        <div class="border p-3 rounded mb-3">
                                            <h6 class="fw-bold">{{ $group->name }}</h6>

                                            <div class="row mt-3">
                                                @foreach ($group->permissions as $permission)
                                                    <div class="col-md-3">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="permission[]" value="{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permission', [])) ? 'checked' : '' }}>
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
                                    <button type="submit"
                                        class="btn btn-dark px-4 py-3 d-flex align-items-right gap-2 rounded-3 btn-lg">Create
                                        Role</button>
                                    {{-- <a href="{{ route('rolesPermission.index') }}" class="btn btn-secondary">Cancel</a> --}}
                                </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection
