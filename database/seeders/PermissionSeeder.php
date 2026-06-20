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
    }
}
