<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
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
            //'student_id' => 'nullable|string|unique:users,student_id',
            //'country_id' => 'nullable|exists:countries,id',
            //'state_id' => 'nullable|exists:states,id',
            //'zipcode' => 'nullable|string|max:20',
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
            //'student_id' => $request->student_id,
            //'country_id' => $request->country_id,
            //'state_id' => $request->state_id,
            //'zipcode' => $request->zipcode,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function schools()
    {
        $schools = School::all();
        return view('admin.schools', compact('schools'));
    }
}
