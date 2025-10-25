<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Illuminate\Support\Facades\View;

class SuperadminDashboardController extends Controller
{
    public function __construct()
    {
        // Menu Superadmin
        $menus = [
            ['name' => 'Dashboard', 'icon' => 'dashboard.svg', 'route' => 'superadmin.dashboard'],
            ['name' => 'Manajemen Pengguna', 'icon' => 'users.svg', 'route' => 'superadmin.users'],
            ['name' => 'Manajemen Produk', 'icon' => 'product.svg'],
            ['name' => 'Transaksi', 'icon' => 'transaction.svg'],
            ['name' => 'Refund', 'icon' => 'refund.svg'],
            ['name' => 'Pengaturan', 'icon' => 'settings.svg'],
        ];

        View::share('menus', $menus);
    }

    public function index()
    {
        // Statistik dasar
        $totalUsers = User::count();
        $totalTransactions = BuyTransaction::count() + SendTransaction::count();

        // Aktivitas transaksi
        $transaksiSelesai = BuyTransaction::where('payment_status', 'approved')->count();
        $transaksiBerjalan = BuyTransaction::where('payment_status', 'pending')->count();
        $transaksiDibatalkan = BuyTransaction::where('payment_status', 'declined')->count();
        $titipKirim = SendTransaction::count();

        // Data untuk grafik (bulan vs jumlah user)
        $chartData = [
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'traveler' => [10000, 20000, 18000, 22000, 20000, 15000],
            'customer' => [15000, 24000, 20000, 23000, 21000, 18000],
        ];

        // Transaksi terbaru
        $latestTransactions = BuyTransaction::with(['buyer', 'traveler'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('_superadmin.dashboard.index', compact(
            'totalUsers',
            'totalTransactions',
            'transaksiSelesai',
            'transaksiBerjalan',
            'transaksiDibatalkan',
            'titipKirim',
            'chartData',
            'latestTransactions'
        ));
    }

    public function index2()
    {
        return view('_superadmin.dashboard.index2');
    }
    // Tambah method index3 sampai index10 sesuai kebutuhan
}