<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'account_status' => 'active',
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'account_status' => 'active',
        ]);

        // Finance
        User::create([
            'name' => 'Finance',
            'email' => 'finance@example.com',
            'password' => Hash::make('password'),
            'role' => 'finance',
            'account_status' => 'active',
        ]);
    }
}