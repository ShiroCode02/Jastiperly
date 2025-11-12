<?php
// app/Exports/TransactionsDetailExport.php

namespace App\Exports;

use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class TransactionsDetailExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transaction;
    protected $type;

    public function __construct($transaction, $type)
    {
        $this->transaction = $transaction;
        $this->type = $type;
    }

    public function collection(): Collection
    {
        return collect([$this->transaction]);
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tipe',
            'Tanggal Transaksi',
            'Status',
            'Total Harga',
            'Metode Pembayaran',
            'Nama Pengguna 1',
            'Kontak Pengguna 1',
            'Nama Pengguna 2',
            'Kontak Pengguna 2',
            'Nama Barang',
            'Kategori',
            'Jumlah/Berat',
            'Ukuran/Dimensi',
            'Asal Barang',
            'Deskripsi Barang',
            'Alamat Pengambilan',
            'Alamat Tujuan',
            'Metode Pengiriman',
            'Resi Pengiriman',
            'Jenis Pengiriman',
        ];
    }

    public function map($trx): array
    {
        $isBuy = $this->type === 'buy';

        // Pengguna 1 & 2
        $user1Name = $isBuy ? ($trx->buyer->detail->name ?? $trx->buyer->name) : ($trx->sender->detail->name ?? $trx->sender->name);
        $user1Phone = $isBuy ? ($trx->buyer->detail->phone ?? '-') : ($trx->sender->detail->phone ?? '-');
        $user2Name = $isBuy ? ($trx->traveler->detail->name ?? $trx->traveler->name) : ($trx->reciever->detail->name ?? $trx->reciever->name);
        $user2Phone = $isBuy ? ($trx->traveler->detail->phone ?? '-') : ($trx->reciever->detail->phone ?? '-');

        // Barang
        $quantityWeight = $isBuy ? ($trx->quantity . ' Unit') : ($trx->weight . ' kg');
        $dimension = $isBuy ? '-' : ($trx->dimension ?? '-');
        $origin = $isBuy ? ($trx->product->origin ?? '-') : '-';

        return [
            $isBuy ? '#JSTP' . $trx->id : 'TKR' . $trx->id,
            $isBuy ? 'Titip Beli' : 'Titip Kirim',
            $trx->created_at->format('d-m-Y H:i'),
            $this->getStatusText($trx->payment_status),
            'Rp' . number_format($trx->total_price ?? 0, 0, ',', '.'),
            $trx->paymentMethod->name ?? '-',
            $user1Name,
            $user1Phone,
            $user2Name,
            $user2Phone,
            $trx->product->name,
            $trx->product->category->name ?? '-',
            $quantityWeight,
            $dimension,
            $origin,
            $trx->product->description ?? '-',
            $isBuy ? '-' : ($trx->pickup_address ?? '-'),
            $isBuy ? '-' : ($trx->delivery_address ?? '-'),
            $isBuy ? '-' : ($trx->delivery_method ?? '-'),
            $isBuy ? '-' : ($trx->delivery_code ?? '-'),
            $isBuy ? '-' : ($trx->delivery_type ?? '-'),
        ];
    }

    private function getStatusText($status)
    {
        return match ($status) {
            'approved' => 'Selesai',
            'pending' => 'Belum Bayar / Belum Selesai',
            'declined' => 'Dibatalkan',
            default => '-',
        };
    }
}