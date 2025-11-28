<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
// use DataTables;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class PermissionGroupController extends Controller // implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:permission-group-list|permission-group-create|permission-group-edit|permission-group-delete', only: ['index', 'show']),
            new Middleware('permission:permission-group-create', only: ['create', 'store']),
            new Middleware('permission:permission-group-edit', only: ['edit', 'update']),
            new Middleware('permission:permission-group-delete', only: ['destroy', 'bulkDestroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $groups = PermissionGroup::select('id', 'name');

            return DataTables::of($groups)
                ->editColumn('id', function ($group) {
                    return '
            <input type="checkbox" class="select-group" data-id="' . $group->id . '">
        ';
                })
                ->addColumn('actions', function ($group) {

                    $edit = '
            <a href="' . route('permission-groups.edit', $group->id) . '"
               class="text-dark me-3"
               style="font-size:18px;">
               <i class="fa-solid fa-pen-to-square"></i>
            </a>';

                    $delete = '
            <a href="javascript:;"
               data-url="' . route('permission-groups.destroy', $group->id) . '"
               class="text-danger delete-group"
               style="font-size:18px;">
               <i class="fa-solid fa-trash-can"></i>
            </a>';

                    return '
            <div class="d-flex justify-content-end align-items-center gap-3">
                ' . $edit . $delete . '
            </div>';
                })
                ->rawColumns(['id', 'actions'])
                ->startsWithSearch()
                ->toJson();
        }

        return view('admin.rolesPermission.permissiongroups.index');
    }

    public function create()
    {
        return view('admin.rolesPermission.permissiongroups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45|unique:permission_groups,name',
        ]);

        try {
            $group = PermissionGroup::create(['name' => $request->name]);
            return view('admin.rolesPermission.permissiongroups.create');
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $group = PermissionGroup::findOrFail($id);
        return view('admin.rolesPermission.permissiongroups.edit', compact('group'));
    }

    public function update(Request $request, $id)
    {
        $group = PermissionGroup::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permission_groups')->ignore($id)],
        ]);

        try {
            $group->update(['name' => $request->name]);
            return response()->json($group);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $group = PermissionGroup::findOrFail($id);
            $group->delete();
            return response()->json(['message' => 'Permission group deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function bulkDestroy(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (!empty($ids)) {
                PermissionGroup::whereIn('id', $ids)->get()->each->delete();
                return response()->json(['message' => 'Permission groups deleted successfully.']);
            } else {
                return response()->json(['message' => 'No permission groups selected.'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
