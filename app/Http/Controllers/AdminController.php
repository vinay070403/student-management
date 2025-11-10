<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\BulkDeleteUserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use SweetAlert2\Laravel\Swal;

class AdminController extends Controller
{
    // ----------------------------------------------------------------
    // ✅ USER MANAGEMENT (Admin Panel)
    // ----------------------------------------------------------------
    public function index()
    {
        if (request()->ajax()) {
            $users = User::latest()->paginate(2);
            return view('admin.users.partials.users_table', compact('users'))->render();
        }

        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->dob        = $request->dob;
        $user->address    = $request->address;
        $user->password   = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        // ✅ Role assign from form input (radio / card / button)
        if ($request->filled('role')) {
            $user->assignRole($request->role);
        } else {
            $user->assignRole('Admin'); // fallback (optional)
        }

        // Optionally: Give permissions based on role
        if ($request->role === 'Super Admin') {
            $user->givePermissionTo(\Spatie\Permission\Models\Permission::all());
        } elseif ($request->role === 'Admin') {
            $user->givePermissionTo(['user-list', 'user-create', 'school-list']);
        }

        Swal::success([
            'title' => 'User Created!',
            'text'  => 'The new user has been added successfully.',
            'confirmButtonText' => 'OK',
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->first_name = $data['first_name'];
        $user->last_name  = $data['last_name'];
        $user->email      = $data['email'];
        $user->phone      = $data['phone'] ?? $user->phone;
        $user->dob        = $data['dob'] ?? $user->dob;
        $user->address    = $data['address'] ?? $user->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatar', 'public');
        }

        $user->save();

        Swal::toastSuccess(['title' => 'User updated successfully!']);

        return redirect()->route('users.index', $user->id);
    }

    public function removeAvatar(User $user)
    {
        try {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Avatar removed successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove avatar'], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    public function bulkDelete(BulkDeleteUserRequest $request)
    {
        User::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true, 'message' => 'Selected users deleted successfully']);
    }
}
