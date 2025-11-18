<?php

namespace App\Exports;

use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $type = $this->request['type'] ?? 'buy';
        $status = $this->request['status'] ?? null;
        $location = $this->request['location'] ?? null;
        $search = $this->request['search'] ?? null;

        $query = $type === 'buy' ? BuyTransaction::query() : SendTransaction::query();

        if ($type === 'buy') {
            $query->with(['buyer.detail', 'traveler.detail', 'paymentMethod', 'product.category']);
            $query->whereDoesntHave('refund');
        } else {
            $query->with(['sender.detail', 'reciever.detail', 'paymentMethod', 'product.category']);
        }

        // FILTER STATUS
        if ($status && in_array($status, ['selesai', 'berjalan', 'dibatalkan'])) {
            if ($status === 'selesai') {
                $query->where('payment_status', 'approved');
            } elseif ($status === 'berjalan') {
                $query->where('payment_status', 'pending');
            } elseif ($status === 'dibatalkan') {
                $query->where('payment_status', 'declined');
            }
        }

        // FILTER LOKASI — JALAN DI BUY & SEND
        if ($location) {
            $delivery_type = $location === 'dalam' ? 'Dalam Negeri' : 'Luar Negeri';
            $query->where('delivery_type', $delivery_type);
        }

        // SEARCH
        if ($search) {
            $query->whereHas($type === 'buy' ? 'buyer.detail' : 'sender.detail', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Transaksi',
            'Nama Penitip/Pengirim',
            'Tanggal',
            'Status',
            'Total',
            'Metode Pembayaran',
            'Jenis',
        ];
    }

    public function map($trx): array
    {
        static $index = 0;
        $index++;

        $isBuy = $trx instanceof BuyTransaction;

        $statusText = match ($trx->payment_status) {
            'approved' => 'Selesai',
            'pending'   => $isBuy ? 'Belum Bayar' : 'Belum Selesai',
            'declined'  => 'Dibatalkan',
            default     => '-',
        };

        return [
            $index,
            $isBuy ? '#JSTP' . $trx->id : 'TKR' . $trx->id,
            $isBuy ? $trx->buyer->detail->name : $trx->sender->detail->name,
            $trx->created_at->format('d-m-Y'),
            $statusText,
            'Rp' . number_format($trx->total_price ?? 0, 0, ',', '.'),
            $trx->paymentMethod->name ?? '-',
            $isBuy ? 'Titip Beli' : 'Titip Kirim',
        ];
    }
}