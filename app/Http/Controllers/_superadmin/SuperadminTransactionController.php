<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SuperadminTransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi gabungan (titip beli & titip kirim)
     * dengan filter tipe & status.
     */
    public function index(Request $request)
    {
        $filterType = $request->input('type', 'all');
        $filterStatus = $request->input('status', 'all');

        // Ambil data titip beli
        $buyTransactions = BuyTransaction::with(['buyer', 'traveler', 'paymentMethod'])
            ->when($filterStatus !== 'all', fn($q) => $q->where('payment_status', $filterStatus))
            ->get()
            ->map(function ($trx) {
                $trx->type = 'buy';
                return $trx;
            });

        // Ambil data titip kirim
        $sendTransactions = SendTransaction::with(['sender', 'reciever', 'paymentMethod'])
            ->when($filterStatus !== 'all', fn($q) => $q->where('payment_status', $filterStatus))
            ->get()
            ->map(function ($trx) {
                $trx->type = 'send';
                // Samakan struktur dengan buy agar view tidak error
                $trx->buyer = $trx->reciever;
                $trx->total_price = $trx->total_price ?? 0;
                return $trx;
            });

        // Gabungkan & filter berdasarkan tipe
        $transactions = match ($filterType) {
            'buy' => $buyTransactions,
            'send' => $sendTransactions,
            default => $buyTransactions->concat($sendTransactions),
        };

        // Urutkan transaksi terbaru
        $transactions = $transactions->sortByDesc('created_at')->values();

        // Manual pagination (karena digabung dari dua tabel)
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $paginated = new LengthAwarePaginator(
            $transactions->forPage($page, $perPage),
            $transactions->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('_superadmin.transactions.index', [
            'transactions' => $paginated,
            'filterType' => $filterType,
            'filterStatus' => $filterStatus,
        ]);
    }

    /**
     * Detail transaksi titip beli
     */
    public function showBuy($id)
    {
        $trx = BuyTransaction::with(['buyer', 'traveler', 'product', 'paymentMethod', 'refund'])
            ->findOrFail($id);

        return view('_superadmin.transactions.show-buy', compact('trx'));
    }

    /**
     * Detail transaksi titip kirim
     */
    public function showSend($id)
    {
        $trx = SendTransaction::with(['sender', 'reciever', 'product', 'paymentMethod'])
            ->findOrFail($id);

        return view('_superadmin.transactions.show-send', compact('trx'));
    }

    /**
     * Edit transaksi (placeholder)
     */
    public function edit($type, $id)
    {
        return "Halaman edit transaksi tipe {$type} dengan ID: {$id}";
    }
}