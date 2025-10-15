@extends('layouts.app')

@section('title', 'Add User')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card shadow-sm mb-4" style="max-width: 950px; margin: auto;">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Add New User</h4>

                {{-- Error + success messages --}}
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

                {{-- ✅ Add enctype for file upload --}}
                <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone *</label>
                                <div class="input-group input-group-sm">
                                    <select name="phone_code" class="form-select form-select-sm" style="max-width: 80px;">
                                        <option value="+91">+91</option>
                                        <option value="+1">+1</option>
                                        <option value="+44">+44</option>
                                    </select>
                                    <input type="text" name="phone" class="form-control form-control-sm" placeholder="1234567890" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date of Birth *</label>
                                <input type="date" name="dob" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        {{-- ✅ Updated Avatar Section --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Avatar (optional)</label>
                                <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*">
                                
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
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address *</label>
                                <input type="text" name="address" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" name="password" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Client-side validation --}}
<script>
document.getElementById("addUserForm").addEventListener("submit", function(e) {
    const form = e.target;
    let valid = true;
    let errorMsg = [];

    // Get form data
    const firstName = form.first_name.value.trim();
    const lastName = form.last_name.value.trim();
    const email = form.email.value.trim();
    const phone = form.phone.value.trim();
    const dob = form.dob.value.trim();
    const avatar = form.avatar.value.trim();
    const address = form.address.value.trim();
    const password = form.password.value.trim();

    // Validation logic
    const emailPattern = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
    const phonePattern = /^[0-9]{7,15}$/;
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&]).{8,}$/;

    if (!firstName) { valid = false; errorMsg.push("First name is required."); }
    if (!lastName) { valid = false; errorMsg.push("Last name is required."); }
    if (!email || !emailPattern.test(email)) { valid = false; errorMsg.push("Valid email is required."); }
    if (!phone || !phonePattern.test(phone)) { valid = false; errorMsg.push("Valid phone number is required."); }
    if (!dob) { valid = false; errorMsg.push("Date of birth is required."); }
    if (!avatar) { valid = false; errorMsg.push("Please upload an avatar image."); }
    if (!address) { valid = false; errorMsg.push("Address is required."); }
    if (!passwordPattern.test(password)) {
        valid = false;
        errorMsg.push("Password must include uppercase, lowercase, number, and special character, min 8 chars.");
    }

    if (!valid) {
        e.preventDefault();
        alert(errorMsg.join("\\n"));
    }
});
</script>
@endsection








public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|min:2|max:50',
        'last_name'  => 'required|string|min:2|max:50',
        'email'      => 'required|email|unique:users,email',
        'phone'      => 'required|digits_between:7,15',
        'phone_code' => 'required|string',
        'dob'        => 'required|date|before:today',
        'address'    => 'required|string|max:255',
        'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'password'   => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*?&]/',
        ],
    ]);

    // ✅ Optional avatar upload
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $validated['avatar_url'] = '/storage/' . $path;
    }

    $validated['password'] = bcrypt($validated['password']);

    \App\Models\User::create($validated);

    return redirect()->back()->with('success', 'User added successfully!');
}





public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'first_name' => 'required|string|min:2|max:50',
        'last_name'  => 'required|string|min:2|max:50',
        'email'      => 'required|email|unique:users,email,' . $user->id,
        'phone'      => 'required|digits_between:7,15',
        'phone_code' => 'required|string',
        'dob'        => 'required|date|before:today',
        'address'    => 'required|string|max:255',
        'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // ✅ If remove avatar is checked
    if ($request->has('remove_avatar') && $request->remove_avatar == 1) {
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }
        $validated['avatar_url'] = null;
    }

    // ✅ If new avatar uploaded
    if ($request->hasFile('avatar')) {
        // Remove old avatar if exists
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }
        $path = $request->file('avatar')->store('avatars', 'public');
        $validated['avatar_url'] = '/storage/' . $path;
    }

    $user->update($validated);

    return redirect()->back()->with('success', 'User updated successfully!');
}





now for edit file 

@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Edit User Details</h4>

                {{-- Error messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Success message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-2">
                        {{-- FIRST NAME --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-sm" 
                                       required value="{{ old('first_name', $user->first_name) }}">
                            </div>
                        </div>

                        {{-- LAST NAME --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-sm" 
                                       required value="{{ old('last_name', $user->last_name) }}">
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control form-control-sm" 
                                       required value="{{ old('email', $user->email) }}">
                            </div>
                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control form-control-sm" 
                                       required value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>

                        {{-- DOB --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control form-control-sm"
                                       required value="{{ old('dob', $user->dob) }}">
                            </div>
                        </div>

                        {{-- ADDRESS --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-sm"
                                       required value="{{ old('address', $user->address) }}">
                            </div>
                        </div>

                        {{-- AVATAR --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Avatar (optional)</label>
                                <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*">

                                @if ($user->avatar_url)
                                    <div class="mt-2">
                                        <img src="{{ $user->avatar_url }}" alt="Avatar" class="img-thumbnail" style="max-width: 100px;">
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="remove_avatar" value="1" id="remove_avatar" class="form-check-input">
                                            <label for="remove_avatar" class="form-check-label">Remove current avatar</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- PASSWORD UPDATE --}}
                        <div class="col-md-12 mt-3">
                            <h6 class="fw-bold">Change Password (optional)</h6>
                            <p class="text-muted" style="font-size: 13px;">Leave blank if you don't want to change the password.</p>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Enter new password">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Update User</button>
                    </div>
                </form>

                <hr>

                {{-- DELETE USER --}}
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                            Delete User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection





   public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'first_name' => 'required|string|min:2|max:50',
        'last_name'  => 'required|string|min:2|max:50',
        'email'      => 'required|email|unique:users,email,' . $user->id,
        'phone'      => 'required|digits_between:7,15',
        'dob'        => 'required|date|before:today',
        'address'    => 'required|string|max:255',
        'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'password'   => 'nullable|string|min:8|confirmed', // ✅ password_confirmation handled automatically
    ]);

    // ✅ Remove avatar if requested
    if ($request->has('remove_avatar') && $request->remove_avatar == 1) {
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }
        $validated['avatar_url'] = null;
    }

    // ✅ If a new avatar is uploaded
    if ($request->hasFile('avatar')) {
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }
        $path = $request->file('avatar')->store('avatars', 'public');
        $validated['avatar_url'] = '/storage/' . $path;
    }

    // ✅ If password field is filled, hash it
    if (!empty($request->password)) {
        $validated['password'] = bcrypt($request->password);
    } else {
        unset($validated['password']); // keep existing password
    }

    $user->update($validated);

    return redirect()->back()->with('success', 'User updated successfully!');
}


