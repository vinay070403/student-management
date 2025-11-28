@extends('layouts.app')

@section('title', 'Edit Permission Group')

@section('content')
    <div class="row">
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color:#adb5bd;">
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="container-fluid">
                        <h3>Edit Permission Group</h3>

                        <form id="groupForm" method="POST" action="{{ route('permission-groups.update', $group->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Group Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $group->name }}"
                                    required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Group</button>
                            <a href="{{ route('rolesPermission.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
