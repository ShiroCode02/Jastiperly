<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class SuperadminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'buy'); // buy | send
        $status = $request->get('status');
        $location = $request->get('location');
        $search = $request->get('search');
        $transaction_id = $request->get('transaction_id');

        if ($transaction_id) {
            $transaction = $type === 'buy'
                ? BuyTransaction::with(['buyer', 'traveler', 'product', 'paymentMethod', 'refund'])->findOrFail($transaction_id)
                : SendTransaction::with(['sender', 'reciever', 'product', 'paymentMethod'])->findOrFail($transaction_id);

            return view('_superadmin.transactions.index', compact('transaction', 'type'));
        }

        $query = $type === 'buy' ? BuyTransaction::query() : SendTransaction::query();

        // Join dengan user & payment method
        if ($type === 'buy') {
            $query->with(['buyer', 'traveler', 'paymentMethod', 'product', 'refund']);
        } else {
            $query->with(['sender', 'reciever', 'paymentMethod', 'product']);
        }

        // Filter Status
        if ($status && in_array($status, ['selesai', 'berjalan', 'dibatalkan', 'refund'])) {
            if ($status === 'refund') {
                $query->whereHas('refund', fn($q) => $q->whereIn('status', ['pending', 'approved']));
            } elseif ($status === 'selesai') {
                $query->where('payment_status', 'approved');
            } elseif ($status === 'berjalan') {
                $query->where('payment_status', 'pending');
            } elseif ($status === 'dibatalkan') {
                $query->where('payment_status', 'declined');
            }
        }

        // Filter Lokasi (hanya untuk Titip Kirim)
        if ($type === 'send' && $location) {
            $delivery_type = $location === 'dalam' ? 'Dalam Negeri' : 'Luar Negeri';
            $query->where('delivery_type', $delivery_type);
        }

        // Search
        if ($search) {
            $query->whereHas($type === 'buy' ? 'buyer' : 'sender', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        $transactions = $query->latest()->paginate(10)->appends($request->query());

        return view('_superadmin.transactions.index', compact('transactions', 'type'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'buy');
        $filename = $type === 'buy' ? 'Transaksi_Titip_Beli' : 'Transaksi_Titip_Kirim';
        $filename .= '_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new TransactionsExport($request->all()), $filename);
    }

    public function destroy($id)
    {
        $type = request('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;

        $transaction = $model::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}