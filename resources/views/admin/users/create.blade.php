@extends('layouts.app')
@section('title', 'Add User')
@section('content')
<div class="row">
    <div class="app-wrapper flex-column flex-row-fluid">
        <!-- Full width -->
        <!-- <div class="card shadow-sm mb-4"> -->
        <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Add New User</h4>
                <a href="{{ route('users.index') }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="mdi mdi-arrow-left me-2"></i> Back </a>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif @if (session('success'))
            <div class="alert alert-success"> {{ session('success') }} </div>
            @endif
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                @csrf
                <div class="row g-3">
                    <!-- First Name -->
                    <div class="col-md-6">
                        <div class="form-group"> <label for="first_name" class="form-label">First Name</label> <input type="text" name="first_name" class="form-control form-control-lg" required pattern="[A-Za-z]+" placeholder="John"> </div>
                    </div>
                    <!-- Last Name -->
                    <div class="col-md-6">
                        <div class="form-group"> <label for="last_name" class="form-label">Last Name</label> <input type="text" name="last_name" class="form-control form-control-lg" required pattern="[A-Za-z]+" placeholder="Doe"> </div>
                    </div>
                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="form-group"> <label for="email" class="form-label">Email</label> <input type="email" name="email" class="form-control form-control-lg" required placeholder="example@mail.com"> </div>
                    </div>
                    <!-- Phone -->
                    <div class="col-md-6">
                        <div class="form-group"> <label for="phone" class="form-label">Phone</label>
                            <div class="input-group"> <select name="phone_code" class="form-select form-select-lg" style="max-width: 90px;">
                                    <option value="+91">+91</option>
                                    <!-- More codes if needed -->
                                </select> <input type="text" name="phone" class="form-control form-control-lg" required pattern="\d{10}" placeholder="1234567890" maxlength="10"> </div>
                        </div>
                    </div>
                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <div class="form-group"> <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control form-control-lg">
                        </div>
                    </div>
                    <!-- Avatar URL -->
                    {{-- ✅ Updated Avatar Section --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="avatar" class="form-label">Avatar (optional)</label>
                            <input type="file" name="avatar" class="form-control form-control-lg" accept="image/*">

                            {{-- If user already has an avatar, show it --}}
                            @isset($user->avatar_url)
                            <div class="mt-2">
                                <img src="{{ $user->avatar_url }}" alt="Avatar" class="img-thumbnail" style="max-width: 100px;">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="remove_avatar" value="1" id="remove_avatar" class="form-check-input">
                                    <label for="remove_avatar" class="form-check-label">Remove current avatar</label>
                                </div>
                            </div>
                            @endisset
                        </div>
                    </div>
                    <!-- Address -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control form-control-lg" placeholder="123 Main St">
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="create your password">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection @push('styles')
<style>
    /* Custom styles for better spacing and alignment */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
    }

    .input-group .form-select {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-group .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endpush