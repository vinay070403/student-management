@extends('layouts.app')

@section('title', 'Edit Profile')

@section('styles')
<style>
    .avatar {
        width: 200px;
        height: 200px;
        border-radius: 8px;
        object-fit: cover;
        border: 3px solid #e9ecef;
    }

    .personal-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .form-horizontal .form-group {
        margin-bottom: 20px;
    }

    .form-horizontal .control-label {
        font-weight: 500;
        color: #495057;
    }
</style>
@endsection

@section('content')
<div class="container bootstrap-snippets bootdey py-4">
    <h1 class="text-primary mb-4"><i class="mdi mdi-account-edit me-2"></i>Edit Profile</h1>
    <hr class="mb-4">

    <div class="row">
        <!-- Left Column: Avatar -->
        <div class="col-md-3">
            <div class="text-center mb-4">
                <div class="avatar-container position-relative mb-3">
                    <img id="avatarPreview"
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}"
                        alt="Avatar"
                        class="img-fluid mx-auto d-block avatar">
                </div>

                <h6 class="mt-3 text-muted">Upload a different photo...</h6>
                <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mb-2" accept="image/*" form="profileForm">

                @if ($user->avatar)
                <form action="{{ route('users.removeAvatar', $user->id) }}" method="POST" onsubmit="return confirm('Remove avatar?')" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">Remove Avatar</button>
                </form>
                @endif

                @error('avatar')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Right Column: Edit Form -->
        <div class="col-md-9 personal-info">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fa fa-info-circle me-2"></i>
                Update your profile details below. Changes will be saved when you click "Save Changes".
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <form id="profileForm" class="form-horizontal" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">First Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('first_name') is-invalid @enderror"
                            type="text" name="first_name"
                            value="{{ old('first_name', $user->first_name) }}" required>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Last Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('last_name') is-invalid @enderror"
                            type="text" name="last_name"
                            value="{{ old('last_name', $user->last_name) }}" required>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('email') is-invalid @enderror"
                            type="email" name="email"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Phone:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" name="phone"
                            value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Date of Birth:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="date" name="dob"
                            value="{{ old('dob', $user->dob) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Address:</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">New Password:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Confirm Password:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm new password">
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <div class="col-lg-9 offset-lg-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('avatar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush