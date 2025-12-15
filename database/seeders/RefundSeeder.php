<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuyTransaction;
use App\Models\Refund;

class RefundSeeder extends Seeder
{
    public function run(): void
    {
        // AMBIL 3 TRANSAKSI "Dalam Negeri"
        $dalam = BuyTransaction::where('payment_status', 'approved')
            ->where('delivery_type', 'Dalam Negeri')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // AMBIL 3 TRANSAKSI "Luar Negeri"
        $luar = BuyTransaction::where('payment_status', 'approved')
            ->where('delivery_type', 'Luar Negeri')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // GABUNGKAN
        $transactions = $dalam->merge($luar);

        if ($transactions->count() < 6) {
            $this->command->error('Kurang data untuk variasi Dalam/Luar Negeri. Pastikan BuyTransactionSeeder punya keduanya.');
            return;
        }

        // ALASAN & STATUS TETAP SAMA
        $refunds = [
            ['reason' => 'Barang rusak saat pengiriman', 'status' => 'pending'],
            ['reason' => 'Warna tidak sesuai pesanan', 'status' => 'pending'],
            ['reason' => 'Ukuran terlalu kecil', 'status' => 'approved'],
            ['reason' => 'Produk kadaluarsa', 'status' => 'approved'],
            ['reason' => 'Salah kirim barang', 'status' => 'declined'],
            ['reason' => 'Kemasan penyok', 'status' => 'pending'],
        ];

        foreach ($transactions as $i => $trx) {
            Refund::create([
                'buy_transaction_id' => $trx->id,
                'reason' => $refunds[$i]['reason'],
                'status' => $refunds[$i]['status'],
            ]);
        }

        $this->command->info('6 refund berhasil dibuat: 3 Dalam Negeri, 3 Luar Negeri.');
    }
}