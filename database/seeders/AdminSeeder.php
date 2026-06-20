<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'Ahmad',
            'last_name' => 'Raza',
            'username' => 'superadmin',
            'email' => 'engr.ahmadraza348@gmail.com',
            'password' => Hash::make('engr.ahmadraza348@gmail.com'), 
            'phone' => '+923499153486',
            'status' => '1',
        ]);
    }
}
