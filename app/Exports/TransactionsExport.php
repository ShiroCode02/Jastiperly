<?php

namespace App\Exports;

use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $type = $this->request['type'] ?? 'buy';
        $query = $type === 'buy' ? BuyTransaction::query() : SendTransaction::query();

        if ($type === 'buy') {
            $query->with(['buyer', 'traveler', 'paymentMethod', 'product']);
        } else {
            $query->with(['sender', 'reciever', 'paymentMethod', 'product']);
        }

        // Apply same filters as index
        if (isset($this->request['status'])) {
            // ... (sama seperti di index)
        }

        return $query->get();
    }

    public function headings(): array
    {
        $base = ['ID', 'Tanggal', 'Penitip/Pengirim', 'Traveler/Penerima', 'Total', 'Metode', 'Status'];
        return $this->request['type'] === 'send'
            ? array_merge($base, ['Lokasi', 'Resi'])
            : array_merge($base, ['Jumlah', 'Produk']);
    }

    public function map($trx): array
    {
        $isBuy = $this->request['type'] === 'buy';

        $row = [
            'JST' . $trx->id,
            $trx->created_at->format('d-m-Y H:i'),
            $isBuy ? $trx->buyer->name : $trx->sender->name,
            $isBuy ? $trx->traveler->name : $trx->reciever->name,
            'Rp' . number_format($trx->total_price ?? 0, 0, ',', '.'),
            $trx->paymentMethod->name ?? '-',
            ucfirst($trx->payment_status),
        ];

        if ($isBuy) {
            $row[] = $trx->quantity;
            $row[] = $trx->product->name;
        } else {
            $row[] = $trx->delivery_type;
            $row[] = $trx->delivery_code ?? '-';
        }

        return $row;
    }
}