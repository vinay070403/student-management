@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-8">
        <div class="card shadow-sm mb-6">
            <div class="card-body p-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-title mb-0">Edit User Details</h2>
                    <a href="{{ route('admin.users') }}" class="btn btn-dark py-3 px-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
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

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3"> <!-- Increased spacing between fields -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-lg" required value="{{ $user->first_name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-lg" required value="{{ $user->last_name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" required value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control form-control-lg" value="{{ $user->phone }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control form-control-lg" value="{{ $user->dob }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" name="avatar" class="form-control form-control-lg">
                                @if ($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="Avatar" class="img-thumbnail mt-2" style="max-width: 100px;">
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-lg" value="{{ $user->address }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password (leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control form-control-lg">
                            </div>
                        </div>
                    </div>

                    <!-- Update & Delete Buttons side by side -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-dark py-3 px-3 d-flex align-items-center gap-2 rounded-3 btn-lg">Update User</button>
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" style="margin:0;">

                            <!-- Delete Button triggers dialog -->
                            <!-- <button type="button" class="btn btn-danger  px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg" onclick="document.getElementById('delete-user-dialog-{{ $user->id }}').showModal()">
                                Delete User
                            </button> -->
                        </form> <!-- <-- update form closed here -->
                        <!-- Delete Confirmation Dialog -->
                        <dialog id="delete-user-dialog-{{ $user->id }}" style="border:none; border-radius:12px; padding:25px; max-width:400px; width:90%;">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                                    <i class="mdi mdi-alert-circle-outline" style="font-size:28px; color:#f44336;"></i>
                                    <h3 style="margin:0; font-size:20px;">Confirm Deletion</h3>
                                </div>
                                <p style="font-size:16px;">Are you sure you want to delete this user? This action cannot be undone.</p>
                                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px;">
                                    <button type="submit" class="btn btn-danger px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg">Yes, Delete</button>
                                    <button type="button" class="btn btn-secondary px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg" onclick="document.getElementById('delete-user-dialog-{{ $user->id }}').close()">Cancel</button>
                                </div>
                            </form>
                        </dialog>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Increase font size for labels and inputs */
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

    .btn-danger:hover {
        background-color: #ff4d4f;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background-color: #6c757d;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    dialog::backdrop {
        background: rgba(0, 0, 0, 0.5);
    }
</style>
@endpush