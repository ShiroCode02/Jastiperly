<?php


namespace App\Exports;

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
        $common = [
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
            'Deskripsi Barang',
        ];

        if ($this->type === 'buy') {
            return array_merge($common, [
                'Jumlah Barang',
                'Asal Barang',
            ]);
        } else {
            return array_merge($common, [
                'Berat Barang',
                'Ukuran/Dimensi',
                'Alamat Pengambilan',
                'Alamat Tujuan',
                'Metode Pengiriman',
                'Resi Pengiriman',
                'Jenis Pengiriman',
            ]);
        }
    }

    public function map($trx): array
    {
        $isBuy = $this->type === 'buy';

        // === DATA PENGGUNA ===
        $user1Name = $isBuy 
            ? ($trx->buyer->detail->name ?? $trx->buyer->name) 
            : ($trx->sender->detail->name ?? $trx->sender->name);
        $user1Phone = $isBuy 
            ? ($trx->buyer->detail->phone ?? '-') 
            : ($trx->sender->detail->phone ?? '-');
        $user2Name = $isBuy 
            ? ($trx->traveler->detail->name ?? $trx->traveler->name) 
            : ($trx->reciever->detail->name ?? $trx->reciever->name);
        $user2Phone = $isBuy 
            ? ($trx->traveler->detail->phone ?? '-') 
            : ($trx->reciever->detail->phone ?? '-');

        // === DATA BARANG ===
        $quantity = $isBuy ? $trx->quantity . ' Unit' : null;
        $weight = !$isBuy ? (preg_replace('/[^0-9.]/', '', $trx->weight ?? '') . ' kg') : null;
        $dimension = !$isBuy ? ($trx->dimension ?? '-') : null;
        $origin = $isBuy ? ($trx->product->origin ?? '-') : null;

        // === DATA PENGIRIMAN ===
        $pickup = !$isBuy ? ($trx->pickup_address ?? '-') : null;
        $delivery = !$isBuy ? ($trx->delivery_address ?? '-') : null;
        $method = !$isBuy ? ($trx->delivery_method ?? '-') : null;
        $code = !$isBuy ? ($trx->delivery_code ?? '-') : null;
        $typeDelivery = !$isBuy ? ($trx->delivery_type ?? '-') : null;

        // === DATA UMUM ===
        $commonData = [
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
            $trx->product->description ?? '-',
        ];

        if ($isBuy) {
            return array_merge($commonData, [
                $quantity,
                $origin,
            ]);
        } else {
            return array_merge($commonData, [
                $weight,
                $dimension,
                $pickup,
                $delivery,
                $method,
                $code,
                $typeDelivery,
            ]);
        }
    }

    private function getStatusText($status)
    {
        return match ($status) {
            'approved' => 'Selesai',
            'pending' => $this->type === 'buy' ? 'Belum Bayar' : 'Belum Selesai',
            'declined' => 'Dibatalkan',
            default => '-',
        };
    }
}