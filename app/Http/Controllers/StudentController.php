<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::role('Student')->get();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            //'student_id' => 'required|unique:users,student_id',
            'password' => 'required|min:8',
        ]);

        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $data['password'] = Hash::make($request->password);
        $student = User::create($data);
        $student->assignRole('Student');

        return redirect()->route('students.index')->with('success', 'Student added!');
    }

    public function edit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            //'student_id' => 'required|unique:users,student_id,' . $student->id,
            'password' => 'nullable|min:8',
        ]);

        //$data = $request->all();
        if ($request->hasFile('avatar')) {
            //$data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        // if ($request->filled('password')) {
        //     $data['password'] = Hash::make($request->password);
        // }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // ✅ remove so it won't overwrite with NULL
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated!');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted!');
    }
}
