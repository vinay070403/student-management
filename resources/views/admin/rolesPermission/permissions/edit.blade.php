@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
    <div class="row">
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color:#adb5bd;">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Edit Permission</h3>

                    <a href="{{ route('rolesPermission.index') }}"
                        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                    </a>

                </div>

                <form id="permissionForm" method="POST" action="{{ route('permissions.update', $permission->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Permission Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Permission Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $permission->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Display Name --}}
                    <div class="mb-3">
                        <label for="display_name" class="form-label">Display Name</label>
                        <input type="text" name="display_name" class="form-control"
                            value="{{ old('display_name', $permission->display_name) }}">
                        @error('display_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Permission Group Dropdown --}}
                    <div class="mb-3">
                        <label for="group_id" class="form-label">Group</label>
                        <select name="group_id" class="form-select" required>
                            <option value="">-- Select Group --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}"
                                    {{ old('group_id', $permission->group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Permission</button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
