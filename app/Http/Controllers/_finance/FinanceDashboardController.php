<?php

namespace App\Http\Controllers\_finance;

use App\Http\Controllers\Controller;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FinanceDashboardController extends Controller
{
    public function index(Request $request)
    {
        // === PENDAPATAN HARI INI ===
        $todayIncome = BuyTransaction::where('payment_status', 'approved')
            ->whereDate('created_at', today())
            ->sum('total_price');

        $todayIncome += SendTransaction::where('payment_status', 'approved')
            ->whereDate('created_at', today())
            ->sum('total_price');

        // === PENDAPATAN BULAN INI ===
        $monthIncome = BuyTransaction::where('payment_status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $monthIncome += SendTransaction::where('payment_status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // === DATA GRAFIK (per bulan, Titip Beli vs Titip Kirim) ===
        $chartData = $this->getChartData();

        // === PENGGUNA YANG SERING AKTIF (10 TERATAS + PAGINATION) ===
        $activeUsers = User::query()
            ->whereIn('role', ['customer', 'traveler'])
            ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
            ->leftJoin('buy_transactions as bt', function ($join) {
                $join->on('users.id', '=', 'bt.buyer_id')
                     ->orOn('users.id', '=', 'bt.traveler_id');
            })
            ->leftJoin('send_transactions as st', function ($join) {
                $join->on('users.id', '=', 'st.sender_id')
                     ->orOn('users.id', '=', 'st.reciever_id');
            })
            ->select([
                'users.id',
                'users.email',
                'user_details.name',
                DB::raw('COALESCE(COUNT(bt.id), 0) + COALESCE(COUNT(st.id), 0) as total_transactions')
            ])
            ->groupBy('users.id', 'users.email', 'user_details.name')
            ->orderByDesc('total_transactions')
            ->paginate(10);

        // Tambahkan nomor urut di pagination
        $activeUsers->getCollection()->transform(function ($user, $key) use ($activeUsers) {
            $user->no = $activeUsers->firstItem() + $key;
            return $user;
        });

        return view('_finance.dashboard.index', compact(
            'todayIncome',
            'monthIncome',
            'chartData',
            'activeUsers'
        ));
    }

    private function getChartData()
    {
        // Ambil 12 bulan terakhir
        $months = collect(range(0, 11))->map(function ($i) {
            return now()->subMonths($i)->format('M');
        })->reverse()->values();

        // Titip Beli (BuyTransaction)
        $beliData = collect(range(0, 11))->map(function ($i) {
            return BuyTransaction::where('payment_status', 'approved')
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->sum('total_price');
        })->reverse()->values();

        // Titip Kirim (SendTransaction)
        $kirimData = collect(range(0, 11))->map(function ($i) {
            return SendTransaction::where('payment_status', 'approved')
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->sum('total_price');
        })->reverse()->values();

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Titip Kirim',
                    'data' => $kirimData,
                    'backgroundColor' => '#FFF500'
                ],
                [
                    'label' => 'Titip Beli Barang',
                    'data' => $beliData,
                    'backgroundColor' => '#8FD14F'
                ]
            ]
        ];
    }

    public function index2() 
    { 
        return view('_finance.dashboard.index2'); 
    }
}