<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * IMPORTANT: this seeder used to create the super admin with the
     * password literally equal to their email address, and that exact
     * password was then printed on the public login page's "Quick Login"
     * button. That is how your account was compromised. This version:
     *
     *   1. Never writes a real, guessable password into a seeder or a view
     *      again.
     *   2. Generates a random password for the super admin every time this
     *      seeder runs (unless you set SUPER_ADMIN_PASSWORD in .env), and
     *      prints it ONCE to the console. Copy it down immediately - it is
     *      not stored anywhere else and is not recoverable afterwards.
     *   3. Creates two separate, low-privilege "Admin" and "Cashier" demo
     *      accounts that ARE safe to show/quick-login on the login page,
     *      because their role has no edit/delete permissions at all
     *      (see RoleSeeder).
     */
    public function run(): void
    {
        $superAdminEmail = env('SUPER_ADMIN_EMAIL', 'owner@yourdomain.com');
        $superAdminPassword = env('SUPER_ADMIN_PASSWORD');
        $generated = false;

        if (empty($superAdminPassword)) {
            $superAdminPassword = Str::password(16);
            $generated = true;
        }

        $superAdmin = Admin::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => $superAdminEmail,
                'password' => Hash::make($superAdminPassword),
                'phone' => null,
                'status' => 1,
            ]
        );
        $superAdmin->syncRoles(['Super Admin']);

        // Demo "Admin" account - safe to put on the login page as a quick
        // login button. Can view every module and create records, cannot
        // edit or delete anything (enforced by the "Admin" role's
        // permissions, seeded in RoleSeeder).
        $demoAdminPassword = env('DEMO_ADMIN_PASSWORD', 'Demo@Admin123');
        $demoAdmin = Admin::updateOrCreate(
            ['username' => 'demo_admin'],
            [
                'first_name' => 'Demo',
                'last_name' => 'Admin',
                'email' => 'demo.admin@yourdomain.com',
                'password' => Hash::make($demoAdminPassword),
                'phone' => null,
                'status' => 1,
            ]
        );
        $demoAdmin->syncRoles(['Admin']);

        // Demo "Cashier" account - also safe to show. Can use the POS
        // terminal and view catalog/customer data, cannot edit or delete.
        $demoCashierPassword = env('DEMO_CASHIER_PASSWORD', 'Demo@Cashier123');
        $demoCashier = Admin::updateOrCreate(
            ['username' => 'demo_cashier'],
            [
                'first_name' => 'Demo',
                'last_name' => 'Cashier',
                'email' => 'demo.cashier@yourdomain.com',
                'password' => Hash::make($demoCashierPassword),
                'phone' => null,
                'status' => 1,
            ]
        );
        $demoCashier->syncRoles(['Cashier']);

        if ($generated) {
            $this->command?->warn('=====================================================================');
            $this->command?->warn(' SUPER ADMIN CREDENTIALS (shown once - copy these now)');
            $this->command?->warn(' Username: superadmin');
            $this->command?->warn(' Email:    ' . $superAdminEmail);
            $this->command?->warn(' Password: ' . $superAdminPassword);
            $this->command?->warn(' This account is hidden from the admin-user list and the login page.');
            $this->command?->warn(' Store this password in a password manager, not in any file in this repo.');
            $this->command?->warn('=====================================================================');
        }
    }
}
