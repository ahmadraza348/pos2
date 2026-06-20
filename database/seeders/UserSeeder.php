<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Ahmad',
            'last_name' => 'Raza',
            'username' => 'testuser',
            'email' => 'engr.ahmadraza348@gmail.com',
            'password' => Hash::make('engr.ahmadraza348@gmail.com'), 
            'phone' => '+923499153486',
            'gender' => 'male',
         
        ]);
    }
}
