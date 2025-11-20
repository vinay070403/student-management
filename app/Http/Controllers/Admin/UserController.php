<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\BulkDeleteUserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SweetAlert2\Laravel\Swal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // ----------------------------------------------------------------
    // ✅ USER MANAGEMENT (Admin Panel)
    // ----------------------------------------------------------------

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Student');
            })
                ->select('id', 'ulid', 'first_name', 'last_name', 'email', 'avatar', 'status', 'created_at');


            $search = $request->input('custom_search');
            if (!empty($search)) {
                $users->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            return DataTables::of($users)
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="select-user" data-id="' . $user->ulid . '">';
                })
                ->addColumn('user', function ($user) {
                    $avatar = $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/images/default-avatar.png');
                    return '
                <div class="d-flex align-items-center gap-2">
                    <img src="' . $avatar . '" width="42" height="42" style="object-fit:cover; border-radius:0; border:1px solid #dee2e6;">

                    <div style="line-height: 1.4;">
                        <div class="fw-bold text-dark" style="font-size: 15px;">' . e($user->first_name . ' ' . $user->last_name) . '</div>
                       <div class="text-muted" style="font-size: 13px; margin-top: 3px;">' . e($user->email) . '</div>
                    </div>
                </div>';
                })
                ->addColumn('status', function ($user) {
                    $checked = $user->status ? 'checked' : '';
                    return '
    <label class="status-toggle">
        <span>Inactive</span>
        <input type="checkbox" class="statusToggle" data-id="' . $user->ulid . '" ' . $checked . '>
        <span class="slider"></span>
        <span>Active</span>
    </label>
    ';
                })

                ->addColumn('created_at', function ($user) {
                    return $user->created_at ? $user->created_at->format('d M Y, h:i A') : '';
                })
                ->addColumn('actions', function ($user) {
                    return '
                <div class="d-flex justify-content-end gap-2">
                    <a href="' . route('users.edit', $user->ulid) . '"
                       class="btn btn-outline-old-dark btn-sm d-flex align-items-center justify-content-center"
                       style="width:36px; height:36px; border-radius:8px;" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <button type="button"
                       class="btn btn-outline-old-dark btn-sm d-flex align-items-center justify-content-center delete-user-btn"
                       style="width:36px; height:36px; border-radius:8px;" data-id="' . $user->ulid . '" title="Delete">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>';
                })
                ->rawColumns(['checkbox', 'user', 'status', 'actions'])
                ->make(true);
        }

        return view('admin.users.index');
    }


    // ------------------------
    // Create user form
    // ------------------------
    public function create()
    {
        return view('admin.users.create');
    }

    // ----------------------------------------------------------------
    // ✅ Store New User
    // ----------------------------------------------------------------
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
            $user->avatar = $request->file('avatar')->store('avatar', 'public');
        }

        $user->save();

        //  Role assign from form input (radio / card / button)
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

    // ----------------------------------------------------------------
    // ✅ Edit User
    // ----------------------------------------------------------------
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ----------------------------------------------------------------
    // ✅ Update User
    // ----------------------------------------------------------------
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

        return redirect()->route('users.index', $user->ulid);
    }

    // ----------------------------------------------------------------
    // ✅ Update User Status (Active / Inactive) via AJAX
    // ----------------------------------------------------------------
    public function updateStatus(Request $request, $ulid)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive',
        ]);

        $user = User::where('ulid', $ulid)->firstOrFail();
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "User status updated to {$request->status}.",
            'status' => $user->status,
        ]);
    }

    // ----------------------------------------------------------------
    // ✅ Remove User Avatar via AJAX
    // ----------------------------------------------------------------
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

    // ----------------------------------------------------------------
    // ✅ Delete User
    // ----------------------------------------------------------------
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

    // ----------------------------------------------------------------
    // ✅ Bulk Delete Users
    // ----------------------------------------------------------------
    public function bulkDelete(BulkDeleteUserRequest $request)
    {
        User::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true, 'message' => 'Selected users deleted successfully']);
    }
}
