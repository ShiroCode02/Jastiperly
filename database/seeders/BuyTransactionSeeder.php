<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuyTransaction;
use App\Models\Refund;
use Illuminate\Support\Facades\Storage;

class BuyTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan folder storage/app/public/proofs ada
        Storage::makeDirectory('public/proofs');

        $transactions = [
            // Selesai
            [
                'buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 1, 'quantity' => 2,
                'total_price' => 300000, 'payment_method_id' => 1, 'payment_status' => 'approved',
                'payment_proof' => $this->fakeProof('approved_1.jpg'),
            ],
            [
                'buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 5, 'quantity' => 1,
                'total_price' => 800000, 'payment_method_id' => 2, 'payment_status' => 'approved',
                'payment_proof' => $this->fakeProof('approved_2.jpg'),
            ],

            // Berjalan
            [
                'buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 9, 'quantity' => 3,
                'total_price' => 150000, 'payment_method_id' => 4, 'payment_status' => 'pending',
                'payment_proof' => $this->fakeProof('pending_1.jpg'),
            ],
            [
                'buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 10, 'quantity' => 5,
                'total_price' => 150000, 'payment_method_id' => 5, 'payment_status' => 'pending',
                'payment_proof' => $this->fakeProof('pending_2.jpg'),
            ],

            // Dibatalkan
            [
                'buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 3, 'quantity' => 1,
                'total_price' => 200000, 'payment_method_id' => 1, 'payment_status' => 'declined',
                'payment_proof' => $this->fakeProof('declined_1.jpg'),
            ],

            // Refund
            [
                'buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 7, 'quantity' => 1,
                'total_price' => 700000, 'payment_method_id' => 3, 'payment_status' => 'approved',
                'payment_proof' => $this->fakeProof('refund_1.jpg'),
                'refund' => ['reason' => 'Barang rusak saat pengiriman', 'status' => 'pending'],
            ],
        ];

        foreach ($transactions as $trx) {
            $refund = $trx['refund'] ?? null;
            unset($trx['refund']);

            $transaction = BuyTransaction::create($trx);

            if ($refund) {
                Refund::create(array_merge($refund, ['buy_transaction_id' => $transaction->id]));
            }
        }
    }

    private function fakeProof($filename)
    {
        $path = 'proofs/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            // Buat gambar dummy 300x300
            $image = imagecreatetruecolor(300, 300);
            $bg = imagecolorallocate($image, 240, 240, 240);
            $text = imagecolorallocate($image, 100, 100, 100);
            imagefill($image, 0, 0, $bg);
            imagestring($image, 5, 50, 130, 'Bukti Transfer', $text);
            imagestring($image, 3, 50, 160, $filename, $text);
            imagejpeg($image, $fullPath);
            imagedestroy($image);
        }

        return $path;
    }
}