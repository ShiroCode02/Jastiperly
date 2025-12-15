<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['type' => 'bank', 'name' => 'BCA', 'account_name' => 'PT Jastiperly', 'account_number' => '1234567890'],
            ['type' => 'bank', 'name' => 'BNI', 'account_name' => 'PT Jastiperly', 'account_number' => '0987654321'],
            ['type' => 'bank', 'name' => 'Mandiri', 'account_name' => 'PT Jastiperly', 'account_number' => '1122334455'],
            ['type' => 'wallet', 'name' => 'OVO', 'account_name' => null, 'account_number' => '081234567890'],
            ['type' => 'wallet', 'name' => 'GoPay', 'account_name' => null, 'account_number' => '081298765432'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}