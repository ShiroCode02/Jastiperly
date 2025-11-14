<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuyTransaction;
use App\Models\Refund;

class RefundSeeder extends Seeder
{
    public function run(): void
    {
        // AMBIL 6 TRANSAKSI APPROVED DENGAN ID TERTENTU (BUKAN ACAK)
        $transactions = BuyTransaction::where('payment_status', 'approved')
            ->orderBy('id') // urut dari kecil → konsisten
            ->take(6)
            ->get();

        if ($transactions->count() < 6) {
            $this->command->error('Kurang dari 6 transaksi approved! Jalankan BuyTransactionSeeder dulu.');
            return;
        }

        // ALASAN & STATUS DITENTUKAN MANUAL → SESUAI BRD
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

        $this->command->info('6 data refund DITENTUKAN berhasil dibuat: 3 pending, 2 approved, 1 declined.');
    }
}