<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
// use DataTables;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RoleController extends Controller implements HasMiddleware
{
    // Apply middleware for permissions
    public static function middleware(): array
    {
        return [
            new Middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]),
            new Middleware('permission:role-create', ['only' => ['create', 'store']]),
            new Middleware('permission:role-edit', ['only' => ['edit', 'update']]),
            new Middleware('permission:role-delete', ['only' => ['destroy', 'bulkDestroy']]),
        ];
    }

    // List Roles (with DataTables support)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select('id', 'name', 'display_name');

            return DataTables::of($roles)
                ->editColumn('id', function ($role) {
                    return '<input type="checkbox" class="select-role" data-id="' . $role->id . '">';
                })
                ->addColumn('actions', function ($role) {

                    $edit = '
            <a href="' . route('roles.edit', $role->id) . '"
               class="text-dark me-3"
               style="font-size:18px;">
               <i class="fa-solid fa-pen-to-square"></i>
            </a>';

                    $delete = '
            <a href="javascript:;"
               data-url="' . route('roles.destroy', $role->id) . '"
               class="text-danger delete-role"
               style="font-size:18px;">
               <i class="fa-solid fa-trash-can"></i>
            </a>';

                    return '
            <div class="d-flex justify-content-end align-items-center gap-2">
                ' . $edit . $delete . '
            </div>';
                })
                ->rawColumns(['id', 'actions'])
                ->startsWithSearch()
                ->toJson();
        }

        return view('admin.rolesPermission.roles.index');
    }

    // Create Role Form
    public function create()
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();
        return view('admin.rolesPermission.roles.create', compact('permissionGroups'));
    }

    // Store Role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'nullable|string|max:255',
            'permission' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'guard_name' => 'web',
            ]);

            $permissions = Permission::whereIn('id', $request->permission)->get();
            if ($permissions->count() != count($request->permission)) {
                return back()->withErrors('Some selected permissions are invalid.');
            }

            $role->syncPermissions($permissions);
            DB::commit();
            return redirect()->route('rolesPermission.index')->with('success', 'Role created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    // Edit Role Form
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissionGroups = PermissionGroup::with('permissions')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.rolesPermission.roles.edit', compact('role', 'permissionGroups', 'rolePermissions'));
    }

    // Update Role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($id)],
            'display_name' => 'nullable|string|max:255',
            'permission' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'guard_name' => 'web',
            ]);

            $permissions = Permission::whereIn('id', $request->permission)->get();
            if ($permissions->count() != count($request->permission)) {
                return back()->withErrors('Some selected permissions are invalid.');
            }

            $role->syncPermissions($permissions);
            DB::commit();
            return redirect()->route('rolesPermission.index')->with('success', 'Role updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    // Delete Role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            return response()->json(['message' => 'Role deleted successfully.'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Bulk Delete Roles
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['message' => 'No roles selected.'], 400);
        }

        DB::beginTransaction();
        try {
            Role::whereIn('id', $ids)->delete();
            DB::commit();
            return response()->json(['message' => 'Selected roles deleted successfully.'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
