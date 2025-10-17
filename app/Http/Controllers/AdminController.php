<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\BulkDeleteUserRequest;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        if (request()->ajax()) {
            $users = User::latest()->paginate(2);
            return view('admin.users.partials.users_table', compact('users'))->render();
        }

        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));

        // $users = User::paginate(10);
        // return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'dob'        => $request->dob,
            'avatar'     => $request->avatar,
            'address'    => $request->address,
            'password'   => Hash::make($request->password),
        ]);

        $user->assignRole('Admin');
        $user->givePermissionTo(['user-list', 'user-create', 'school-list']);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        // Fill non-password fields (guarding password)
        $user->first_name = $data['first_name'];
        $user->last_name  = $data['last_name'];
        $user->email      = $data['email'];
        $user->phone      = $data['phone'] ?? $user->phone;
        $user->dob        = $data['dob'] ?? $user->dob;
        $user->address    = $data['address'] ?? $user->address;


        if (! empty($data['remove_avatar'])) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }


        // if ($request->filled('password')) {
        //     $user->password = Hash::make($request->password);
        // }

        // if ($request->boolean('remove_avatar')) {
        //     if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        //         Storage::disk('public')->delete($user->avatar);
        //     }
        //     $user->avatar = null
        // }

        // if ($request->hasFile('avatar')) {

        //     if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        //         Storage::disk('public')->delete($user->avatar);
        //     }

        //     $path = $request->file('avatar')->store('avatars', 'public');
        //     $user->avatar = $path;
        // }
        // if ($request->filled('password')) {
        //     $user->password = bcrypt($request->password);
        // }

        $user->save();

        return redirect()->route('users.edit', $user->id)->with('success', 'User updated successfully.');
    }

    public function removeAvatar(User $user)
    {
        try {
            // Delete avatar file if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Set avatar field to null
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

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the user.'
            ], 500);
        }
    }

    public function bulkDelete(BulkDeleteUserRequest $request)
    {
        User::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected users deleted successfully',
        ]);
    }
}
