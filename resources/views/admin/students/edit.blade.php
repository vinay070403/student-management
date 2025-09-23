@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Edit Student Details</h4>
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
                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-sm" required value="{{ $student->first_name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-sm" required value="{{ $student->last_name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control form-control-sm" required value="{{ $student->email }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control form-control-sm" value="{{ $student->phone }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control form-control-sm" value="{{ $student->dob }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" name="avatar" class="form-control form-control-sm">
                                @if ($student->avatar_url)
                                <img src="{{ $student->avatar_url }}" alt="Avatar" class="img-thumbnail mt-2" style="max-width: 100px;">
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-sm" value="{{ $student->address }}">
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" name="student_id" class="form-control form-control-sm" value="{{ $student->student_id }}">
                            </div>
                        </div>
                        <div class="md-6">
                            <div class="form-group">
                                <label for="country_id" class="form-label">Country</label>
                                <input type="number" name="country_id" class="form-control form-control-sm" value="{{ $student->country_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state_id" class="form-label">State</label>
                                <input type="number" name="state_id" class="form-control form-control-sm" value="{{ $student->state_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zipcode" class="form-label">Zipcode</label>
                                <input type="text" name="zipcode" class="form-control form-control-sm" value="{{ $student->zipcode }}">
                            </div>
                        </div> -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password (leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Update User</button>
                    </div>
                </form>
                <hr>
                <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection