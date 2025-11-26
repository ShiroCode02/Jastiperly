<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Carbon\Carbon;

class TransactionTestingSeeder extends Seeder
{
    public function run(): void
    {
        $days = [0, 0, 0, 0, 0, 1, 1, 1, 1, 2, 3, 4, 5, 6]; // 5 hari ini, 4 kemarin, dst
        $types = ['buy', 'send'];

        foreach ($days as $dayOffset) {
            $date = Carbon::today()->subDays($dayOffset);
            $count = $dayOffset == 0 ? 6 : (6 - $dayOffset); // hari ini paling banyak

            for ($i = 0; $i < $count; $i++) {
                $type = $types[array_rand($types)];

                if ($type === 'buy') {
                    BuyTransaction::create([
                        'buyer_id' => rand(6,7),
                        'traveler_id' => rand(4,5),
                        'product_id' => rand(1,10),
                        'quantity' => rand(1,3),
                        'total_price' => rand(100000, 1500000),
                        'payment_method_id' => rand(1,5),
                        'payment_status' => 'approved',
                        'payment_proof' => 'proofs/dummy.jpg',
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                } else {
                    SendTransaction::create([
                        'sender_id' => rand(4,5),
                        'reciever_id' => rand(6,7),
                        'product_id' => rand(1,10),
                        'total_price' => rand(100000, 1500000),
                        'payment_method_id' => rand(1,5),
                        'payment_status' => 'approved',
                        'payment_proof' => 'proofs/dummy.jpg',
                        'pickup_address' => 'Jl. Test',
                        'delivery_address' => 'Jl. Test 2',
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                }
            }
        }
    }
}