<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Add this import
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // Use Auth::user() instead of auth()->user()
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        // dd(Auth::user());
        // dd($user);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'address' => 'nullable|string',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // $data = $request->all();
        $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'dob', 'address']); // Safe fields

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        foreach ($data as $key => $value) {
            $user->$key = $value;
        }
        $user;

        // Auth::setUser($user->fresh());


        // session()->flash('avatarUpdated', true); // Flag to indicate avatar change

        return redirect()->route('dashboard')->with('success', 'Profile updated!');
    }
}
