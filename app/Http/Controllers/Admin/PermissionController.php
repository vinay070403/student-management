<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use Spatie\Permission\Models\Permission;
use App\Models\Permission;
use App\Models\PermissionGroup;
// use DataTables;
use Yajra\DataTables\Facades\DataTables;
// use DB;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class PermissionController extends Controller implements HasMiddleware
{
    // Middleware permissions
    public static function middleware(): array
    {
        return [
            new Middleware('permission:permission-list|permission-create|permission-edit|permission-delete', only: ['index', 'show']),
            new Middleware('permission:permission-create', only: ['create', 'store']),
            new Middleware('permission:permission-edit', only: ['edit', 'update']),
            new Middleware('permission:permission-delete', only: ['destroy', 'bulkDestroy']),
        ];
    }

    // List Permissions
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::with('group')->select('id', 'name', 'display_name', 'group_id');

            return DataTables::of($permissions)
                ->addColumn('group', function ($permission) {
                    return $permission->group->name ?? '-';
                })
                ->addColumn('actions', function ($permission) {

                    $edit = '
            <a href="' . route('permissions.edit', $permission->id) . '"
               class="text-dark"
               style="font-size:18px;">
               <i class="fa-solid fa-pen-to-square"></i>
            </a>';

                    $delete = '
            <a href="javascript:;"
               data-url="' . route('permissions.destroy', $permission->id) . '"
               class="text-danger delete-permission"
               style="font-size:18px;">
               <i class="fa-solid fa-trash-can"></i>
            </a>';

                    return '
            <div class="d-flex justify-content-end align-items-center gap-4">
                ' . $edit . $delete . '
            </div>';
                })
                ->rawColumns(['actions'])
                ->toJson();
        }

        return view('admin.rolesPermission.permissions.index');
    }

    // Create Form
    public function create()
    {
        $groups = PermissionGroup::all();
        return view('admin.rolesPermission.permissions.create', compact('groups'));
    }

    // Store Permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'display_name' => 'nullable|string|max:255',
            'group_id' => 'required|exists:permission_groups,id',
        ]);

        try {
            Permission::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'group_id' => $request->group_id,
                'guard_name' => 'web',
            ]);

            return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Edit Form
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $groups = PermissionGroup::all();

        return view('admin.rolesPermission.permissions.edit', compact('permission', 'groups'));
    }

    // Update Permission
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', Rule::unique('permissions')->ignore($id)],
            'display_name' => 'nullable|string|max:255',
            'group_id' => 'required|exists:permission_groups,id',
        ]);

        try {
            $permission->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'group_id' => $request->group_id,
            ]);

            return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Delete Permission
    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);

            DB::transaction(function () use ($permission) {
                $permission->delete();
            });

            return response()->json([
                'message' => 'Permission deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Bulk Delete
    public function bulkDestroy(Request $request)
    {
        try {
            $ids = $request->input('ids');
            if (!empty($ids)) {
                DB::transaction(function () use ($ids) {
                    Permission::whereIn('id', $ids)->delete();
                });

                return response()->json([
                    'message' => 'Permissions deleted successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'No permissions selected for deletion.'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
