<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;
use App\Models\LoginHistory;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserDetailExport implements FromCollection, WithHeadings, WithMapping
{
    protected $user;

    public function __construct($user)
    {
        // Pastikan relasi detail sudah diload
        $this->user = $user->loadMissing('detail');

        // ==== 1. Pisah alamat & kota/negara (sama seperti di controller) ====
        if ($this->user->detail?->address) {
            $address = trim($this->user->detail->address);
            $parts   = array_filter(array_map('trim', explode(',', $address)));

            if (count($parts) > 1) {
                $this->user->city_country   = trim(end($parts));
                array_pop($parts);
                $this->user->detail_address = implode(', ', $parts);
            } else {
                $this->user->city_country   = '-';
                $this->user->detail_address = $address;
            }
        } else {
            $this->user->city_country   = '-';
            $this->user->detail_address = '-';
        }

        // ==== 2. Login terakhir + device ====
        $lastLogin = LoginHistory::where('user_id', $this->user->id)
            ->latest('logged_in_at')
            ->first();

        $this->user->last_login_at = $lastLogin?->logged_in_at
            ? Carbon::parse($lastLogin->logged_in_at)->setTimezone('Asia/Jakarta')
            : null;

        $this->user->last_login_device = $lastLogin && $lastLogin->user_agent
            ? $this->parseDevice($lastLogin->user_agent)
            : '-';

        // ==== 3. Statistik transaksi (traveler & customer) ====
        if (in_array($this->user->role, ['traveler', 'customer'])) {

            // Traveler
            if ($this->user->role === 'traveler') {
                $total      = BuyTransaction::where('traveler_id', $this->user->id)->count()
                            + SendTransaction::where('sender_id', $this->user->id)->count();

                $success    = BuyTransaction::where('traveler_id', $this->user->id)
                                ->where('payment_status', 'approved')->count()
                            + SendTransaction::where('sender_id', $this->user->id)
                                ->where('payment_status', 'approved')->count();

                $failed     = BuyTransaction::where('traveler_id', $this->user->id)
                                ->where('payment_status', 'declined')->count()
                            + SendTransaction::where('sender_id', $this->user->id)
                                ->where('payment_status', 'declined')->count();
            }

            // Customer
            else {
                $total      = BuyTransaction::where('buyer_id', $this->user->id)->count()
                            + SendTransaction::where('reciever_id', $this->user->id)->count();

                $success    = BuyTransaction::where('buyer_id', $this->user->id)
                                ->where('payment_status', 'approved')->count()
                            + SendTransaction::where('reciever_id', $this->user->id)
                                ->where('payment_status', 'approved')->count();

                $failed     = BuyTransaction::where('buyer_id', $this->user->id)
                                ->where('payment_status', 'declined')->count()
                            + SendTransaction::where('reciever_id', $this->user->id)
                                ->where('payment_status', 'declined')->count();
            }

            $this->user->total_transaction       = $total;
            $this->user->successful_transaction  = $success;
            $this->user->failed_transaction      = $failed;
        } else {
            $this->user->total_transaction       = 0;
            $this->user->successful_transaction  = 0;
            $this->user->failed_transaction      = 0;
        }

        // Status aktivitas (Online/Aktif/Offline) – kalau kamu sudah punya accessor di model, tetap pakai itu
        // Kalau belum, bisa ditambahkan di model atau langsung di sini
        $this->user->display_status = $this->user->display_status ?? '-';
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
            ucfirst($user->account_status),
            $user->detail->phone ?? '-', 
            $user->detail_address ?? '-',
            $user->city_country ?? '-',
            $user->detail?->date_birth
                ? Carbon::parse($user->detail->date_birth)->format('d/m/Y')
                : '-',
            $user->detail->gender ?? '-',
            $user->detail->bank_name ?? '-',
            
            // PAKSA NOMOR REKENING JADI STRING + FORMAT TEKS
            // Cara 1 (paling aman): tambah tanda petik di depan
            $user->detail->bank_number ? "'" . $user->detail->bank_number : '-',
            
            // Alternatif cara 2 (kalau mau lebih rapi, pakai WithColumnFormatting di bawah)
            // $user->detail->bank_number ?? '-',

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

    public function columnFormats(): array
    {
        return [
            // Kolom M = Nomor Rekening (urutan kolom di headings, mulai dari A=1)
            // A=1, B=2, ..., M = kolom ke-13 (Nomor Rekening)
            'M' => NumberFormat::FORMAT_TEXT,   // @ ini yang bikin Excel anggap teks 100%
            
            // Kalau mau sekalian nomor HP juga dipaksa teks (biar 081234567890 gak jadi 8.12E+10)
            'G' => NumberFormat::FORMAT_TEXT,   // G = Telepon
        ];
    }

    // Helper untuk parse device (sama seperti di controller)
    private function parseDevice($ua)
    {
        $browser = 'Unknown';
        if (str_contains($ua, 'Edg/')) $browser = 'Edge';
        elseif (str_contains($ua, 'Chrome')) $browser = 'Chrome';
        elseif (str_contains($ua, 'Firefox')) $browser = 'Firefox';
        elseif (str_contains($ua, 'Safari') && !str_contains($ua, 'Chrome')) $browser = 'Safari';

        $os = 'Unknown';
        if (str_contains($ua, 'Windows NT 10.0')) $os = 'Windows 10/11';
        elseif (str_contains($ua, 'Windows NT 6.3')) $os = 'Windows 8.1';
        elseif (str_contains($ua, 'Windows NT 6.2')) $os = 'Windows 8';
        elseif (str_contains($ua, 'Windows NT 6.1')) $os = 'Windows 7';
        elseif (str_contains($ua, 'Macintosh')) $os = 'macOS';
        elseif (str_contains($ua, 'Android')) $os = 'Android';
        elseif (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) $os = 'iOS';

        return "$browser - $os";
    }
}