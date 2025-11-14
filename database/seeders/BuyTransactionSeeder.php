<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuyTransaction;
use Illuminate\Support\Facades\Storage;

class BuyTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan folder storage/app/public/proofs ada
        Storage::makeDirectory('public/proofs');

        $transactions = [
            // === DATA LAMA (6) ===
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 1, 'quantity' => 2, 'total_price' => 300000, 'payment_method_id' => 1, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_1.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 5, 'quantity' => 1, 'total_price' => 800000, 'payment_method_id' => 2, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_2.jpg')],
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 9, 'quantity' => 3, 'total_price' => 150000, 'payment_method_id' => 4, 'payment_status' => 'pending', 'payment_proof' => $this->fakeProof('pending_1.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 10, 'quantity' => 5, 'total_price' => 150000, 'payment_method_id' => 5, 'payment_status' => 'pending', 'payment_proof' => $this->fakeProof('pending_2.jpg')],
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 3, 'quantity' => 1, 'total_price' => 200000, 'payment_method_id' => 1, 'payment_status' => 'declined', 'payment_proof' => $this->fakeProof('declined_1.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 7, 'quantity' => 1, 'total_price' => 700000, 'payment_method_id' => 3, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_3.jpg')],

            // === DATA BARU (12) ===
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 10, 'quantity' => 2, 'total_price' => 60000,  'payment_method_id' => 1, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_4.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 1,  'quantity' => 1, 'total_price' => 150000, 'payment_method_id' => 2, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_5.jpg')],
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 2,  'quantity' => 1, 'total_price' => 500000, 'payment_method_id' => 4, 'payment_status' => 'pending',  'payment_proof' => $this->fakeProof('pending_3.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 8,  'quantity' => 1, 'total_price' => 300000, 'payment_method_id' => 3, 'payment_status' => 'declined','payment_proof' => $this->fakeProof('declined_2.jpg')],
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 6,  'quantity' => 1, 'total_price' => 1200000,'payment_method_id' => 1, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_6.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 4,  'quantity' => 1, 'total_price' => 250000, 'payment_method_id' => 5, 'payment_status' => 'pending',  'payment_proof' => $this->fakeProof('pending_4.jpg')],
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 3,  'quantity' => 2, 'total_price' => 400000, 'payment_method_id' => 2, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_7.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 5,  'quantity' => 2, 'total_price' => 1600000,'payment_method_id' => 1, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_8.jpg')],
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 9,  'quantity' => 1, 'total_price' => 50000,  'payment_method_id' => 4, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_9.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 10, 'quantity' => 3, 'total_price' => 90000,  'payment_method_id' => 5, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_10.jpg')],
            ['buyer_id' => 6, 'traveler_id' => 4, 'product_id' => 1,  'quantity' => 1, 'total_price' => 150000, 'payment_method_id' => 3, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_11.jpg')],
            ['buyer_id' => 7, 'traveler_id' => 5, 'product_id' => 2,  'quantity' => 2, 'total_price' => 1000000,'payment_method_id' => 1, 'payment_status' => 'approved', 'payment_proof' => $this->fakeProof('approved_12.jpg')],
        ];

        foreach ($transactions as $trx) {
            BuyTransaction::create($trx);
        }
    }

    private function fakeProof($filename)
    {
        $path = 'proofs/' . $filename;
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) {
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