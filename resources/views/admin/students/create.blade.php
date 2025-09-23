@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
<div class="row">
    <div class="col-6"> <!-- Full width, no centering -->
        <div class="card shadow-sm mb-4" style="max-width: 950px; margin: auto;">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Add New Students</h4>
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
                <form action="{{ route('students.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="input-group input-group-sm">
                                    <select name="phone_code" class="form-select form-select-sm" style="max-width: 80px;">
                                        <option value="+91">+ 91</option>
                                        <!-- Add more codes if needed, e.g., +1, +44 -->
                                    </select>
                                    <input type="text" name="phone" class="form-control form-control-sm" placeholder="1234567890">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Avatar URL</label>
                                <input type="text" name="avatar" class="form-control form-control-sm" placeholder="https://example.com/avatar.jpg">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-sm">
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" name="student_id" class="form-control form-control-sm">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="country_id" class="form-label">Country</label>
                                <input type="number" name="country_id" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state_id" class="form-label">State</label>
                                <input type="number" name="state_id" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zipcode" class="form-label">Zipcode</label>
                                <input type="text" name="zipcode" class="form-control form-control-sm">
                            </div> 
                         </div>  -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection