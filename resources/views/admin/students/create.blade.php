@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
<div class="row">
    <div class="app-wrapper flex-column flex-row-fluid">
        <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Add New Student</h4>
                <a href="{{ route('students.index') }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
            </div>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
                <form action="{{ route('students.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label fw-bold text-dark">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control form-control-lg rounded-3 shadow-sm @error('first_name') is-invalid @enderror" required pattern="[A-Za-z]+" placeholder="John" value="{{ old('first_name') }}">
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label fw-bold text-dark">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control form-control-lg rounded-3 shadow-sm @error('last_name') is-invalid @enderror" required pattern="[A-Za-z]+" placeholder="Doe" value="{{ old('last_name') }}">
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label fw-bold text-dark">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3 shadow-sm @error('email') is-invalid @enderror" required placeholder="example@mail.com" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label fw-bold text-dark">Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="phone_code" class="form-control form-control-lg rounded-3 shadow-sm @error('phone') is-invalid @enderror" style="max-width: 90px;">
                                        <option value="+91" {{ old('phone_code') == '+91' ? 'selected' : '' }}>+91</option>
                                        <!-- Add more codes if needed -->
                                    </select>
                                    <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror" required pattern="\d{10}" placeholder="1234567890" maxlength="10" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- DOB -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label fw-bold text-dark">Date of Birth</label>
                                <input type="date" name="dob" class="form-control form-control-lg rounded-3 shadow-sm @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
                                @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Avatar Upload -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label fw-bold text-dark">Avatar</label>
                                <input type="file" name="avatar" class="form-control form-control-lg rounded-3 shadow-sm" id="avatarInput" accept="image/*">

                                <div id="avatar-wrapper" class="position-relative mt-2 d-inline-block">
                                    <img id="user-avatar" src="{{ asset('assets/images/default-avatar1.jpg') }}" alt="Avatar" class="img-thumbnail" style="max-width: 100px;">

                                    <!-- ❌ Remove button -->
                                    <button type="button" id="remove-avatar-btn"
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle rounded-circle"
                                        style="padding:3px 6px;font-size:12px;line-height:1; display:none;">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address" class="form-label fw-bold text-dark">Address</label>
                                <input type="text" name="address" class="form-control form-control-lg rounded-3 shadow-sm @error('address') is-invalid @enderror" placeholder="123 Main St" value="{{ old('address') }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label fw-bold text-dark">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control form-control-lg rounded-3 shadow-sm @error('password') is-invalid @enderror" required placeholder="********">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> -->
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                            <i class="mdi mdi-plus"></i> Add Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

    @push('styles')
    <style>
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

        .is-invalid {
            border-color: #dc3545 !important;
            background-image: none !important;
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

    @push('scripts')
    <script>
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    var valid = true;
                    form.querySelectorAll('input, select').forEach(function(field) {
                        // remove previous invalid
                        field.classList.remove('is-invalid');
                        var feedback = field.nextElementSibling;
                        if (feedback && feedback.classList.contains('invalid-feedback')) {
                            feedback.remove();
                        }

                        var name = field.name;
                        var value = field.value.trim();

                        // required check
                        if (field.hasAttribute('required') && value === '') {
                            valid = false;
                            field.classList.add('is-invalid');
                            var msg = field.name.replace('_', ' ') + ' is required';
                            var div = document.createElement('div');
                            div.className = 'invalid-feedback';
                            div.innerText = msg.charAt(0).toUpperCase() + msg.slice(1);
                            field.parentNode.appendChild(div);
                        }

                        // pattern check
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

                        // stricter email validation
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
                    });

                    if (!valid) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                }, false);
            });
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatarInput');
            const avatarImg = document.getElementById('user-avatar');
            const removeBtn = document.getElementById('remove-avatar-btn');

            // Preview uploaded avatar
            avatarInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarImg.src = e.target.result;
                        removeBtn.style.display = 'block';
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Remove avatar
            removeBtn.addEventListener('click', function() {
                avatarImg.src = "{{ asset('assets/images/default-avatar1.jpg') }}";
                avatarInput.value = '';
                removeBtn.style.display = 'none';
            });
        });
    </script>

    @endpush