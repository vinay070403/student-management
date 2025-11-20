<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Roles - Use firstOrCreate to avoid duplicates
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'web'],
            ['display_name' => 'Super Admin']
        );

        // Other roles (uncomment and add as needed)
        $roles = [
            'Admin' => 'Admin',
            'School Admin' => 'School Admin',
            'Counsellor' => 'Counsellor',
            'Student' => 'Student',
            'Developer' => 'Developer',
        ];

        foreach ($roles as $roleName => $displayName) {
            Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web'],
                ['display_name' => $displayName]
            );
        }

        // Permission Groups and Permissions
        $permissionGroups = [
            'User Management' => [
                'user-list' => 'User List',
                'user-create' => 'User Create',
                'user-edit' => 'User Edit',
                'user-delete' => 'User Delete',
            ],
            'Country Management' => [
                'country-list' => 'Country List',
                'country-create' => 'Country Create',
                'country-edit' => 'Country Edit',
                'country-delete' => 'Country Delete',
            ],
            'State Management' => [
                'state-list' => 'State List',
                'state-create' => 'State Create',
                'state-edit' => 'State Edit',
                'state-delete' => 'State Delete',
            ],
            'Role Management' => [
                'role-list' => 'Role List',
                'role-create' => 'Role Create',
                'role-edit' => 'Role Edit',
                'role-delete' => 'Role Delete',
            ],
            'Permission Management' => [
                'permission-list' => 'Permission List',
                'permission-create' => 'Permission Create',
                'permission-edit' => 'Permission Edit',
                'permission-delete' => 'Permission Delete',
            ],
            'School Management' => [
                'school-list' => 'School List',
                'school-create' => 'School Create',
                'school-edit' => 'School Edit',
                'school-delete' => 'School Delete',
            ],
            'Class Management' => [
                'class-list' => 'Class List',
                'class-create' => 'Class Create',
                'class-edit' => 'Class Edit',
                'class-delete' => 'Class Delete',
            ],
            'Subject Management' => [
                'subject-list' => 'Subject List',
                'subject-create' => 'Subject Create',
                'subject-edit' => 'Subject Edit',
                'subject-delete' => 'Subject Delete',
            ],
        ];

        foreach ($permissionGroups as $groupName => $permissions) {
            // Create or find permission group
            $group = PermissionGroup::firstOrCreate(['name' => $groupName]);

            // Create or find permissions
            foreach ($permissions as $permission => $displayName) {
                Permission::firstOrCreate(
                    ['name' => $permission, 'guard_name' => 'web'],
                    ['display_name' => $displayName, 'group_id' => $group->id]
                );
            }
        }

        // Assign all permissions to Super Admin role
        $allPermissions = Permission::pluck('id')->toArray();
        $superAdminRole->syncPermissions($allPermissions);

        // Sample Super Admin User - Create only if not exists
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'ulid'       => Str::ulid(),       // generate ULID explicitly
                'password'   => Hash::make('password'),
                'status'     => 1,                  // active by default
            ]
        );
        $superAdmin->assignRole('Super Admin');

        // Assign specific permissions to Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminPermissions = [
                'user-list',
                'user-create',
                'user-edit',
                'user-delete',
                // Add more as needed (e.g., 'school-list')
            ];
            $adminRole->syncPermissions($adminPermissions);
        }
    }
}
