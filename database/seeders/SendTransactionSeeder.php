<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SendTransaction;
use Illuminate\Support\Facades\Storage;

class SendTransactionSeeder extends Seeder
{
    public function run(): void
    {
        Storage::makeDirectory('public/delivery');

        $transactions = [
            // Dalam Negeri - Selesai
            [
                'sender_id' => 6, 'reciever_id' => 7, 'product_id' => 2,
                'dimension' => '20x15x10', 'weight' => '0.5 kg', 'delivery_code' => 'JNE123456789',
                'delivery_method' => 'Reguler', 'delivery_type' => 'Dalam Negeri',
                'delivery_image' => $this->fakeDelivery('jne_reguler.jpg'),
                'payment_method_id' => 1, 'payment_status' => 'approved',
                'payment_proof' => $this->fakeProof('send_approved_1.jpg'),
                'pickup_address' => 'Jl. Thamrin No. 78, Jakarta Pusat', // DARI USER DETAIL
                'delivery_address' => 'Jl. Malioboro No. 56, Yogyakarta', // DARI USER DETAIL
            ],
            // Luar Negeri - Berjalan
            [
                'sender_id' => 7, 'reciever_id' => 6, 'product_id' => 6,
                'dimension' => '30x20x15', 'weight' => '1.2 kg', 'delivery_code' => null,
                'delivery_method' => 'Express', 'delivery_type' => 'Luar Negeri',
                'delivery_image' => null,
                'payment_method_id' => 4, 'payment_status' => 'pending',
                'payment_proof' => $this->fakeProof('send_pending_1.jpg'),
                'pickup_address' => 'Jl. Malioboro No. 56, Yogyakarta',
                'delivery_address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            ],
            // Dalam Negeri - Dibatalkan
            [
                'sender_id' => 6, 'reciever_id' => 7, 'product_id' => 8,
                'dimension' => '25x18x12', 'weight' => '0.8 kg', 'delivery_code' => 'JNT987654321',
                'delivery_method' => 'Kargo', 'delivery_type' => 'Dalam Negeri',
                'delivery_image' => $this->fakeDelivery('jnt_kargo.jpg'),
                'payment_method_id' => 2, 'payment_status' => 'declined',
                'payment_proof' => $this->fakeProof('send_declined_1.jpg'),
                'pickup_address' => 'Jl. Thamrin No. 78, Jakarta Pusat',
                'delivery_address' => 'Jl. Malioboro No. 56, Yogyakarta',
            ],
        ];

        foreach ($transactions as $trx) {
            SendTransaction::create($trx);
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

    private function fakeDelivery($filename)
    {
        $path = 'delivery/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            $image = imagecreatetruecolor(400, 200);
            $bg = imagecolorallocate($image, 255, 255, 255);
            $border = imagecolorallocate($image, 0, 0, 0);
            $text = imagecolorallocate($image, 0, 0, 0);
            imagefill($image, 0, 0, $bg);
            imagerectangle($image, 0, 0, 399, 199, $border);
            imagestring($image, 5, 100, 80, 'RESI PENGIRIMAN', $text);
            imagestring($image, 4, 100, 110, $filename, $text);
            imagestring($image, 3, 100, 140, 'JNE EXPRESS', $text);
            imagejpeg($image, $fullPath);
            imagedestroy($image);
        }

        return $path;
    }
}