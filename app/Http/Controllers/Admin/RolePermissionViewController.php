<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\PermissionGroup;
use Spatie\Permission\Models\Permission;

class RolePermissionViewController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $permissionGroups = PermissionGroup::orderBy('id', 'desc')->get();
        $permissions = Permission::orderBy('id', 'desc')->get();

        return view('admin.rolesPermission.index', compact('roles', 'permissionGroups', 'permissions'));
    }
}
