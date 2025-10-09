@extends('layouts.app')

@section('title', 'Add User')

@section('content')
<div class="row">
    <div class="col-12"> <!-- Full width -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Add New User</h4>
                    <a href="{{ route('admin.users') }}" class="btn btn-dark px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                    </a>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-lg" required pattern="[A-Za-z]+" placeholder="John">
                            </div>
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-lg" required pattern="[A-Za-z]+" placeholder="Doe">
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" required placeholder="example@mail.com">
                            </div>
                        </div>
                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="input-group">
                                    <select name="phone_code" class="form-select form-select-lg" style="max-width: 90px;">
                                        <option value="+91">+91</option>
                                        <!-- More codes if needed -->
                                    </select>
                                    <input type="text" name="phone" class="form-control form-control-lg" required pattern="\d{10}" placeholder="1234567890" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control form-control-lg">
                            </div>
                        </div>
                        <!-- Avatar URL -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Avatar URL</label>
                                <input type="url" name="avatar" class="form-control form-control-lg" placeholder="https://example.com/avatar.jpg">
                            </div>
                        </div>
                        <!-- Address -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-lg" placeholder="123 Main St">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg" required placeholder="********">
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
@endsection

@push('styles')
<style>
    /* Form labels and inputs */
    .form-label {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .form-control-lg {
        height: 48px;
        font-size: 1rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }

    /* Buttons hover effect */
    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    /* Input group spacing */
    .input-group .form-select {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .input-group .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endpush