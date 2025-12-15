<?php

namespace App\Http\Controllers\_finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceTransactionController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Transaksi';

        // sementara belum ambil dari DB (dummy data)
        $transactions = [
            [
                'no' => 1,
                'penitip' => 'Anya Geraldine',
                'id_trx' => 'JSTP1234',
                'tanggal' => '07-03-2025',
                'status' => 'Selesai',
                'total' => 'Rp 450.000',
                'pembayaran' => 'BRI'
            ],
            [
                'no' => 2,
                'penitip' => 'Komang Lau',
                'id_trx' => 'JSTP1235',
                'tanggal' => '07-03-2025',
                'status' => 'Selesai',
                'total' => 'Rp 450.000',
                'pembayaran' => 'BRI'
            ],
        ];

        return view('_finance.transactions.index', compact('title', 'transactions'));
    }
}
