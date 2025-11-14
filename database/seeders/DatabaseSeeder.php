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
        $this->call(UserDetailSeeder::class); // Lalu detail user
        $this->call(ProductCategorySeeder::class); // Lalu category
        $this->call(ProductSeeder::class); // Terakhir produk
        $this->call(PaymentMethodSeeder::class); // Seed metode pembayaran
        $this->call(BuyTransactionSeeder::class); // Seed transaksi pembelian
        $this->call(SendTransactionSeeder::class); // Seed transaksi pengiriman
        $this->call(RefundSeeder::class); // Seed Refund transaksi pembelian
        // Kalau mau tambah seeder lain, tambahin di sini
    }
}
