<?php

namespace App\Exports;

use App\Models\Refund;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class RefundsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $query = Refund::with(['buyTransaction.buyer.detail', 'buyTransaction.product']);

        // HANYA SEARCH
        if ($this->request['search'] ?? null) {
            $query->whereHas('buyTransaction', function ($q) {
                $q->where('id', 'like', "%{$this->request['search']}%")
                  ->orWhereHas('buyer.detail', function ($qq) {
                      $qq->where('name', 'like', "%{$this->request['search']}%");
                  });
            });
        }

        // DETAIL: Hanya 1 refund
        if ($this->request['refund'] ?? null) {
            $query->where('id', $this->request['refund']);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Refund',
            'ID Transaksi',
            'Nama Penitip',
            'Nama Barang',
            'Tanggal Refund',
            'Status',
            'Total Refund',
            'Metode Pembayaran',
            'Alasan',
        ];
    }

    public function map($refund): array
    {
        static $index = 0;
        $index++;

        $trx = $refund->buyTransaction;
        $buyer = $trx->buyer->detail ?? null;

        $statusText = match ($refund->status) {
            'pending' => 'Proses',
            'approved' => 'Disetujui',
            'declined' => 'Ditolak',
            default => '-',
        };

        return [
            $index,
            'REF' . $refund->id,
            '#JSTP' . $trx->id,
            $buyer?->name ?? '-',
            $trx->product->name ?? '-',
            $refund->created_at->format('d-m-Y'),
            $statusText,
            'Rp' . number_format($trx->total_price, 0, ',', '.'),
            $trx->paymentMethod->name ?? '-',
            $refund->reason,
        ];
    }
}