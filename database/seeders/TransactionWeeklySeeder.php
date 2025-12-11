<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Carbon\Carbon;

class TransactionWeeklySeeder extends Seeder
{
    public function run(): void
    {
        $traveler = User::where('email', 'traveler1@example.com')->first();
        $customer = User::where('email', 'customer1@example.com')->first();
        $product = Product::first();
        $paymentMethod = PaymentMethod::first();

        if (!$traveler || !$customer || !$product || !$paymentMethod) {
            $this->command->error('Seeder lain belum dijalankan!');
            return;
        }

        // DATA DI BUAT DI UTC — SESUAI DATABASE!
        $data = [
            ['days_ago' => 6, 'count' => 5],
            ['days_ago' => 5, 'count' => 8],
            ['days_ago' => 4, 'count' => 3],
            ['days_ago' => 3, 'count' => 12],
            ['days_ago' => 2, 'count' => 7],
            ['days_ago' => 1, 'count' => 4],
            ['days_ago' => 0, 'count' => 9],
        ];

        foreach ($data as $item) {
            for ($i = 0; $i < $item['count']; $i++) {
                // WAKTU DALAM UTC — PASTI KETEMU DI QUERY!
                $createdAt = Carbon::now('UTC')
                    ->subDays($item['days_ago'])
                    ->setHour(rand(8, 22))
                    ->setMinute(rand(0, 59))
                    ->setSecond(rand(0, 59));

                if (rand(1, 10) <= 7) {
                    BuyTransaction::create([
                        'buyer_id' => $customer->id,
                        'traveler_id' => $traveler->id,
                        'product_id' => $product->id,
                        'quantity' => 1,
                        'total_price' => $product->price,
                        'payment_method_id' => $paymentMethod->id,
                        'payment_status' => 'approved',
                        'payment_proof' => 'proofs/dummy.jpg',
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                } else {
                    SendTransaction::create([
                        'sender_id' => $customer->id,
                        'reciever_id' => $customer->id + 1,
                        'product_id' => $product->id,
                        'dimension' => '20x15x10',
                        'weight' => '0.5',
                        'delivery_method' => 'Reguler',
                        'delivery_type' => 'Dalam Negeri',
                        'payment_method_id' => $paymentMethod->id,
                        'payment_status' => 'approved',
                        'payment_proof' => 'proofs/dummy.jpg',
                        'pickup_address' => 'Jakarta',
                        'delivery_address' => 'Bandung',
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                }
            }
        }

        $this->command->info('SEEDER SELESAI! 48 transaksi dibuat di minggu ini (UTC) → grafik pasti muncul!');
    }
}