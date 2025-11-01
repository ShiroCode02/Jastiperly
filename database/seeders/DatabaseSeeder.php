<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class); // Seed user dulu
        $this->call(ProductCategorySeeder::class); // Lalu category
        $this->call(ProductSeeder::class); // Terakhir produk
        // Kalau mau tambah seeder lain seperti PaymentMethodSeeder, tambahin di sini
    }
}
