<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'admins',
            'roles',
            'permissions',
            'roles_permissions',
            'categories',
            'brands',
            'products',
            'colors',
            'varients',
            'orders',
            'customers',
            'reports',
            'coupons',
            'settings',
            // Added so every admin module used for route/menu protection has
            // full view/create/edit/delete permissions, following the exact
            // same naming convention already used above.
            'suppliers',
            'purchases',
            'expenses',
            'units',
        ];
        $actions = [
            'view',
            'create',
            'edit',
            'delete',
        ];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                // Formatting the name, e.g., "view_categories"
                $permissionName = "{$action}_{$module}";
                
                Permission::updateOrCreate(
                    [
                        'name' => $permissionName,
                        'guard_name' => 'admin'
                    ],
                    [
                        'group_name' => $module
                    ]
                );
            }
        }

        // Sales and Returns don't follow the generic full CRUD pattern above
        // (a "sale" is created via POS checkout, not through a create/edit
        // form, and a return has no edit/delete action in the app), so their
        // permissions are defined explicitly with only the actions that
        // actually exist as routes.
        $extraPermissions = [
            'view_sales' => 'sales',
            'void_sales' => 'sales',
            'view_returns' => 'returns',
            'create_returns' => 'returns',
        ];

        foreach ($extraPermissions as $permissionName => $groupName) {
            Permission::updateOrCreate(
                [
                    'name' => $permissionName,
                    'guard_name' => 'admin',
                ],
                [
                    'group_name' => $groupName,
                ]
            );
        }
    }
}