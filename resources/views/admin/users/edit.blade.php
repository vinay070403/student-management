@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-6">
            <div class="card-body p-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-title mb-0">Edit User Details</h2>
                    <a href="{{ route('users.index') }}" class="btn btn-dark py-3 px-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
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

                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">

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
                            <div class="form-group ">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" name="avatar" class="form-control form-control-lg">
                                @if ($user->avatar_url)
                                <div id="avatar-wrapper" class="position-relative mt-2 d-inline-block">
                                    <img src="{{ $user->avatar_url }}" id="user-avatar" alt="Avatar" class="img-thumbnail mt-2" style="max-width: 100px;">

                                    <!-- ❌ Cross button -->
                                    <button type="button" id="remove-avatar-btn"
                                        class="btn btn-sm btn-danger position-absolute top-0 end-6 translate-middle rounded-circle"
                                        style="padding:3px 6px;font-size:12px;line-height:1;">
                                        ×
                                    </button>
                                </div>
                                @else
                                <img id="user-avatar" src="{{ asset('images/default1-avatar.png') }}"
                                    alt="Default Avatar"
                                    class="img-thumbnail mt-2"
                                    style="max-width: 100px;">
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-lg" value="{{ $user->address }}">
                            </div>
                        </div>

                        <!-- 🧩 Current Password -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control form-control-lg" placeholder="Enter your current password">
                            </div>
                        </div>

                        <!-- 🆕 New Password -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter new password">
                            </div>
                        </div>

                        <!-- 🔁 Confirm New Password -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm new password">
                            </div>
                        </div>


                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-dark py-3 px-3 d-flex align-items-center gap-2 rounded-3 btn-lg">Update User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeBtn = document.getElementById('remove-avatar-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (!confirm('Are you sure you want to remove this avatar?')) return;

                axios.post("{{ route('users.removeAvatar', $user->id) }}", {}, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        document.getElementById('user-avatar').src = "{{ asset('images/default-avatar.png') }}";
                        removeBtn.remove(); // remove the cross
                        alert('Avatar removed successfully!');
                    })
                    .catch(error => {
                        console.error('Error removing avatar:', error);
                        alert('Failed to remove avatar.');
                    });
            });
        }
    });
</script>
@endpush