<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function users()
    {
        // $users = User::all();
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|string',
            'address' => 'nullable|string',
            // 'student_id' => 'nullable|string|unique:users,student_id',
            // 'country_id' => 'nullable|exists:countries,id',
            // 'state_id' => 'nullable|exists:states,id',
            // 'zipcode' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'avatar' => $request->avatar,
            'address' => $request->address,
            // 'student_id' => $request->student_id,
            // 'country_id' => $request->country_id,
            // 'state_id' => $request->state_id,
            // 'zipcode' => $request->zipcode,
            'password' => Hash::make($request->password),
        ]);

        // Role assign karna (e.g., Admin ya Super Admin)
        $user->assignRole('Admin'); // Ya 'Super Admin' agar chahiye
        $user->givePermissionTo(['user-list', 'user-create', 'school-list']); // Example permissions for Admin

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id',
        ]);

        User::whereIn('id', $request->ids)->delete();

        // Return proper JSON
        return response()->json([
            'success' => true,
            'message' => 'Selected users deleted successfully'
        ], 200);
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // File upload validation
            'address' => 'nullable|string',
            // 'student_id' => 'nullable|string|unique:users,student_id,' . $user->id,
            // 'country_id' => 'nullable|exists:countries,id',
            // 'state_id' => 'nullable|exists:states,id',
            // 'zipcode' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->all();
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }
            // Upload new
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = basename($avatarPath);
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    // public function schools()
    // {
    //     $schools = School::all();
    //     return view('admin.schools', compact('schools'));
    // }
}
