<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Order matters: permissions must exist before roles can be assigned
     * permissions, and roles must exist before admins can be assigned
     * roles.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
