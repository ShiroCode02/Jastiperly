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
        // Superadmin (ID 1)
        User::create([
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'account_status' => 'active',
        ]);

        // Admin (ID 2)
        User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'account_status' => 'active',
        ]);

        // Finance (ID 3)
        User::create([
            'email' => 'finance@example.com',
            'password' => Hash::make('password'),
            'role' => 'finance',
            'account_status' => 'active',
        ]);

        // Traveler 1 (ID 4)
        User::create([
            'email' => 'traveler1@example.com',
            'password' => Hash::make('password'),
            'role' => 'traveler',
            'account_status' => 'active',
        ]);

        // Traveler 2 (ID 5)
        User::create([
            'email' => 'traveler2@example.com',
            'password' => Hash::make('password'),
            'role' => 'traveler',
            'account_status' => 'active',
        ]);

        // Customer 1 (ID 6)
        User::create([
            'email' => 'customer1@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'account_status' => 'active',
        ]);

        // Customer 2 (ID 7)
        User::create([
            'email' => 'customer2@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'account_status' => 'active',
        ]);
    }
}