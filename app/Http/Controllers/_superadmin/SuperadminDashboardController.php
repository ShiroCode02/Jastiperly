<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperadminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // ==== 1️⃣ TOTAL PENGGUNA & TRANSAKSI ====
        $totalUsers = User::count();
        $totalTransactions = BuyTransaction::count() + SendTransaction::count();

        // ==== 2️⃣ TOTAL AKTIVITAS ====
        $transaksiSelesai = BuyTransaction::where('payment_status', 'approved')->count();
        $transaksiBerjalan = BuyTransaction::where('payment_status', 'pending')->count();
        $transaksiDibatalkan = BuyTransaction::where('payment_status', 'declined')->count();
        $titipKirim = SendTransaction::count();

        // ==== 3️⃣ GRAFIK TOTAL PENGGUNA ====
        // Ambil jumlah user baru per bulan berdasarkan role
        $months = collect(range(1, 12))->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)));
        $chartData = [
            'months' => $months,
            'traveler' => [],
            'customer' => [],
        ];

        foreach (range(1, 12) as $month) {
            $chartData['traveler'][] = User::where('role', 'traveler')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->count();
            $chartData['customer'][] = User::where('role', 'customer')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->count();
        }

        // ==== 4️⃣ TRANSAKSI TERBARU (Gabungan Buy & Send) ====
        $latestBuy = BuyTransaction::with(['buyer', 'traveler', 'paymentMethod'])
            ->select(
                'id',
                'buyer_id',
                'traveler_id',
                'total_price',
                'payment_status',
                'payment_method_id',
                DB::raw("'buy' as type"),
                'created_at'
            )
            ->latest();

        $latestSend = SendTransaction::with(['sender', 'reciever', 'paymentMethod'])
            ->select(
                'id',
                'sender_id as traveler_id',
                'reciever_id as buyer_id',
                DB::raw("0 as total_price"),
                'payment_status',
                'payment_method_id',
                DB::raw("'send' as type"),
                'created_at'
            )
            ->latest();

        // UNION dua tipe transaksi dan paginate
        $latestTransactions = $latestBuy
            ->unionAll($latestSend)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // ==== 5️⃣ RETURN VIEW ====
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
}