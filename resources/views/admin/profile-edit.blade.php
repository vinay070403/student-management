@extends('layouts.app')

@section('content')
<div class="p-5 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
    <div class="container mt-5">
        <h4 class="mb-4">Edit Profile</h4>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control"
                    value="{{ old('first_name', $user->first_name) }}">
                @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control"
                    value="{{ old('last_name', $user->last_name) }}">
                @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $user->email) }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Avatar</label>
                <input type="file" name="avatar" class="form-control">
                @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror

                @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="mt-3 rounded-circle" width="100">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
    @endsection