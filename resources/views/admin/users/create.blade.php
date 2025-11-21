@extends('layouts.app')
@section('title', 'Add User')
@section('content')
    <div class="row">
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title mb-0">
                        <i class="fa-solid fa-user-plus"></i>
                        Add New User
                    </h3>
                    <a href="{{ route('users.index') }}"
                        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success"> {{ session('success') }} </div>
                @endif
                <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">

                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group p-4 mb-2" style="background-color: #f8f9fa; border-radius: 8px;">
                            <label class="form-label fw-bold text-dark d-block">Select Role</label>
                            <div class="form-check form-check-inline mb-2">
                                <input class="form-check-input" type="radio" name="role" id="super_admin"
                                    value="Super Admin" required>
                                <label class="form-check-label" for="super_admin">Super Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role" id="admin" value="Admin">
                                <label class="form-check-label" for="admin">Admin</label>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- First Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="form-label fw-bold text-dark">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="first_name"
                                        class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                                        required pattern="[A-Za-z]+" placeholder="John" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="form-label fw-bold text-dark">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="last_name"
                                        class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                                        required pattern="[A-Za-z]+" placeholder="Doe" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label fw-bold text-dark">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror" required
                                        placeholder="example@mail.com" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label fw-bold text-dark">Phone <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="phone_code"
                                            class="form-select form-select-lg @error('phone') is-invalid @enderror"
                                            style="max-width: 90px;">
                                            <option value="+91" {{ old('phone_code') == '+91' ? 'selected' : '' }}>+91
                                            </option>
                                        </select>
                                        <input type="text" name="phone"
                                            class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                            required pattern="\d{10}" placeholder="1234567890" maxlength="10"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob" class="form-label fw-bold text-dark">Date of Birth</label>
                                    <input type="date" name="dob"
                                        class="form-control form-control-lg @error('dob') is-invalid @enderror"
                                        value="{{ old('dob') }}">
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Avatar -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="avatar" class="form-label fw-bold text-dark">Avatar (optional)</label>
                                    <input type="file" name="avatar"
                                        class="form-control form-control-lg @error('avatar') is-invalid @enderror"
                                        accept="image/*">
                                    @isset($user->avatar_url)
                                        <div class="mt-2">
                                            <img src="{{ $user->avatar_url }}" alt="Avatar" class="img-thumbnail"
                                                style="max-width: 100px;">
                                            <div class="form-check mt-2">
                                                <input type="checkbox" name="remove_avatar" value="1"
                                                    id="remove_avatar" class="form-check-input">
                                                <label for="remove_avatar" class="form-check-label">Remove current
                                                    avatar</label>
                                            </div>
                                        </div>
                                    @endisset
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address" class="form-label fw-bold text-dark">Address</label>
                                    <input type="text" name="address"
                                        class="form-control form-control-lg @error('address') is-invalid @enderror"
                                        placeholder="123 Main St" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password" class="form-label fw-bold text-dark">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        required placeholder="Create your password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label fw-bold text-dark">Confirm
                                        Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                        required placeholder="Confirm password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit"
                                class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">Add
                                User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('styles')
        <style>
            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-label fw-bold text-dark {
                font-weight: 600;
            }

            .form-control-lg {
                height: 48px;
                font-size: 1rem;
                padding: 0.5rem 0.75rem;
                border-radius: 8px;
            }

            .input-group .form-select {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .input-group .form-control {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

            .is-invalid {
                border-color: #dc3545 !important;
            }

            .invalid-feedback {
                display: block;
                font-size: 0.875rem;
                color: #dc3545;
            }

            .btn-dark:hover {
                background-color: #343a40;
                transform: scale(1.05);
                transition: all 0.2s ease;
            }

            .btn:active {
                transform: scale(0.97);
                transition: transform 0.1s ease;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        var valid = true;
                        form.querySelectorAll('input, select').forEach(function(field) {
                            field.classList.remove('is-invalid');
                            var feedback = field.nextElementSibling;
                            if (feedback && feedback.classList.contains('invalid-feedback')) {
                                feedback.remove();
                            }
                            var name = field.name;
                            var value = field.value.trim();

                            if (field.hasAttribute('required') && value === '') {
                                valid = false;
                                field.classList.add('is-invalid');
                                var msg = field.name.replace('_', ' ') + ' is required';
                                var div = document.createElement('div');
                                div.className = 'invalid-feedback';
                                div.innerText = msg.charAt(0).toUpperCase() + msg.slice(1);
                                field.parentNode.appendChild(div);
                            }

                            if (valid && field.hasAttribute('pattern')) {
                                var pattern = new RegExp(field.getAttribute('pattern'));
                                if (!pattern.test(value)) {
                                    valid = false;
                                    field.classList.add('is-invalid');
                                    var div = document.createElement('div');
                                    div.className = 'invalid-feedback';
                                    div.innerText = 'Invalid ' + name.replace('_', ' ');
                                    field.parentNode.appendChild(div);
                                }
                            }

                            if (valid && name === 'email') {
                                var emailPattern = /^[^\s@]+@[^\s@]+\.[A-Za-z]{2,6}$/;
                                if (!emailPattern.test(value)) {
                                    valid = false;
                                    field.classList.add('is-invalid');
                                    var div = document.createElement('div');
                                    div.className = 'invalid-feedback';
                                    div.innerText = 'Please enter a valid email';
                                    field.parentNode.appendChild(div);
                                }
                            }

                            if (valid && name === 'password_confirmation') {
                                var pwd = form.querySelector('input[name="password"]').value;
                                if (value !== pwd) {
                                    valid = false;
                                    field.classList.add('is-invalid');
                                    var div = document.createElement('div');
                                    div.className = 'invalid-feedback';
                                    div.innerText = 'Passwords do not match';
                                    field.parentNode.appendChild(div);
                                }
                            }
                        });

                        if (!valid) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }, false);
                });
            })();
        </script>
    @endpush
