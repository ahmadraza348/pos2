<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates three roles on the "admin" guard:
     *
     *  - Super Admin: full, unrestricted access (also short-circuits every
     *    Gate check in AuthServiceProvider). This role is never shown on
     *    the login page and is not selectable in the demo/quick-login UI.
     *
     *  - Admin: can see every module and create new records, but has NO
     *    edit_* or delete_* permission, and no access to
     *    admins/roles/permissions management at all. This is the account
     *    safe to show recruiters/demo users.
     *
     *  - Cashier: read-only on catalog/customer data plus the ability to
     *    create returns. The POS terminal itself (creating sales, holding
     *    orders, printing receipts) is intentionally NOT gated by a
     *    permission in routes/web.php, so any authenticated admin
     *    (including Cashier) can use it - that's the actual job of a
     *    cashier. What Cashier can never do is edit or delete anything.
     */
    public function run(): void
    {
        $allPermissions = Permission::where('guard_name', 'admin')->pluck('name');

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $superAdmin->syncPermissions($allPermissions);

        $adminAllowed = $allPermissions->filter(function (string $name) {
            // Admin gets every "view_*" and "create_*" permission, EXCEPT
            // anything to do with managing admins/roles/permissions - that
            // stays exclusive to Super Admin so Admin/Cashier can never
            // create another account, change roles, or escalate themselves.
            if (str_starts_with($name, 'edit_') || str_starts_with($name, 'delete_')) {
                return false;
            }

            if (in_array($name, ['void_sales'])) {
                return false;
            }

            $blockedGroups = ['admins', 'roles', 'permissions', 'roles_permissions'];
            foreach ($blockedGroups as $group) {
                if (str_ends_with($name, "_{$group}")) {
                    return false;
                }
            }

            return true;
        })->values();

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'admin']);
        $admin->syncPermissions($adminAllowed);

        $cashierAllowed = [
            'view_categories',
            'view_brands',
            'view_units',
            'view_products',
            'view_customers',
            'create_customers',
            'view_suppliers',
            'view_sales',
            'view_returns',
            'create_returns',
            'view_reports',
        ];
        $cashierAllowed = $allPermissions->intersect($cashierAllowed)->values();

        $cashier = Role::firstOrCreate(['name' => 'Cashier', 'guard_name' => 'admin']);
        $cashier->syncPermissions($cashierAllowed);
    }
}
