@extends('layouts.app')

@section('title', 'Edit Profile')

@section('styles')
<style>
    .avatar {
        width: 200px;
        height: 200px;
        border-radius: 8px;
        /* Soft square corners */
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
                    <img id="avatarPreview" src="{{ $user->avatar_url }}" alt="Avatar" class="img-fluid mx-auto d-block" style="width: 250px; height: 250px; object-fit: cover; border: 4px solid #e9ecef; border-radius: 8px;">
                </div>
                <h6 class="mt-3 text-muted">Upload a different photo...</h6>
                <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mb-2" accept="image/*">
                @error('avatar')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Right Column: Edit Form -->
        <div class="col-md-9 personal-info">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fa fa-info-circle me-2"></i>
                Update your profile details below. Changes will be saved immediately.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <h3 class="mb-3"><i class="mdi mdi-account-details me-2 text-primary"></i>Personal Info</h3>

            <form class="form-horizontal" role="form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">First Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" required value="{{ old('first_name', $user->first_name) }}">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Last Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" required value="{{ old('last_name', $user->last_name) }}">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required value="{{ old('email', $user->email) }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Phone:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Date of Birth:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('dob') is-invalid @enderror" type="date" name="dob" value="{{ old('dob', $user->dob) }}">
                        @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Address:</label>
                    <div class="col-lg-8">
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Country:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('country_id') is-invalid @enderror" type="string" name="country_id" value="{{ old('country_id', $user->country_id) }}">
                        @error('country_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">State:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('state_id') is-invalid @enderror" type="string" name="state_id" value="{{ old('state_id', $user->state_id) }}">
                        @error('state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Zipcode:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('zipcode') is-invalid @enderror" type="text" name="zipcode" value="{{ old('zipcode', $user->zipcode) }}">
                        @error('zipcode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">New Password:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Leave blank to keep current">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Confirm Password:</label>
                    <div class="col-lg-8">
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm new password">
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
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
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush