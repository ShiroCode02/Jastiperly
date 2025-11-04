<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductDetailExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function collection()
    {
        return collect([$this->product]); // Hanya 1 row
    }

    public function title(): string
    {
        return 'Detail Produk ' . $this->product->name;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Deskripsi Lengkap',
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
            $product->description ?? '-', // Lengkap, tanpa strip_tags
            'Rp ' . number_format($product->price, 0, ',', '.'),
            $product->submiter->name ?? '-',
            $product->category->name ?? '-',
            $product->status ?? '-',
            ucfirst(str_replace(['pending', 'approved', 'declined'], ['Validasi', 'Disetujui', 'Ditolak'], $product->approval))
        ];
    }
}