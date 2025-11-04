<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithStrictNullComparison
{
    protected $tab;
    protected $filter;

    public function __construct($tab = null, $filter = null)
    {
        $this->tab = $tab;
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = Product::with(['submiter', 'category']);

        // Filter berdasarkan tab (Traveler/Customer)
        if ($this->tab === 'Traveler') {
            $query->whereHas('submiter', fn($q) => $q->where('role', 'traveler'));
        } elseif ($this->tab === 'Customer') {
            $query->whereHas('submiter', fn($q) => $q->where('role', 'customer'));
        }

        // Filter berdasarkan status
        if ($this->filter === 'Validasi') {
            $query->where('approval', 'pending');
        } elseif ($this->filter === 'Disetujui') {
            $query->where('approval', 'approved');
        } elseif ($this->filter === 'Ditolak') {
            $query->where('approval', 'declined');
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Deskripsi',
            'Harga (Rp)',
            'Nama Pengirim (Traveler/Penitip)',
            'Kategori',
            'Status',
            'Approval'
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            strip_tags($product->description ?? '-'), // Hilangkan HTML tags
            'Rp ' . number_format($product->price, 0, ',', '.'),
            $product->submiter->name ?? '-',
            $product->category->name ?? '-',
            $product->status ?? '-',
            ucfirst(str_replace(['pending', 'approved', 'declined'], ['Validasi', 'Disetujui', 'Ditolak'], $product->approval))
        ];
    }
}