<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class UserDetailExport implements FromCollection, WithHeadings, WithMapping
{
    protected $user;

    public function __construct($user)
    {
        // Controller sudah load detail, jadi aman
        $this->user = $user;
    }

    public function collection(): Collection
    {
        return collect([$this->user]);
    }

    public function headings(): array
    {
        return [
            'ID User',
            'Nama Lengkap',
            'Username',
            'Email',
            'Role',
            'Status Akun',
            'Telepon',
            'Alamat',
            'Kota/Negara',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Nama Bank',
            'Nomor Rekening',
            'Tanggal Bergabung',

            'Login Terakhir',
            'Device Login',
            'Status Aktivitas',

            'Total Transaksi',
            'Transaksi Berhasil',
            'Transaksi Dibatalkan',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->detail->name ?? '-',
            $user->name,
            $user->email,
            ucfirst($user->role),
            $user->account_status,

            $user->detail->phone ?? '-',
            $user->detail_address ?? '-',
            $user->city_country ?? '-',

            $user->detail->date_birth
                ? \Carbon\Carbon::parse($user->detail->date_birth)->format('d/m/Y')
                : '-',

            $user->detail->gender ?? '-',

            $user->detail->bank_name ?? '-',
            $user->detail->bank_number ?? '-',

            $user->created_at->format('d F Y'),

            $user->last_login_at
                ? $user->last_login_at->translatedFormat('d F Y, H:i') . ' WIB'
                : '-',

            $user->last_login_device ?? '-',
            $user->display_status ?? '-',

            $user->total_transaction ?? 0,
            $user->successful_transaction ?? 0,
            $user->failed_transaction ?? 0,
        ];
    }
}
