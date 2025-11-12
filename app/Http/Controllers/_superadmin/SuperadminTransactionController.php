<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Exports\TransactionsDetailExport;

class SuperadminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Transaksi';
        $type = $request->get('type', 'buy'); // buy | send
        $status = $request->get('status');
        $location = $request->get('location');
        $search = $request->get('search');
        $transaction_id = $request->get('transaction_id');

        if ($transaction_id) {
            $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;

            $transaction = $model::with(
                $type === 'buy'
                    ? ['buyer.detail', 'traveler.detail', 'product.category', 'paymentMethod']
                    : ['sender.detail', 'reciever.detail', 'product.category', 'paymentMethod']
            )->findOrFail($transaction_id);

            return view('_superadmin.transactions.detail', compact('transaction', 'type'));
        }

        $query = $type === 'buy' ? BuyTransaction::query() : SendTransaction::query();

        // Join dengan user & payment method
        if ($type === 'buy') {
            $query->with(['buyer.detail', 'traveler.detail', 'paymentMethod', 'product.category']);
        } else {
            $query->with(['sender.detail', 'reciever.detail', 'paymentMethod', 'product.category']);
        }

        if ($type === 'send') {
            $query->addSelect([
                'calculated_total' => \App\Models\Product::select('price')
                    ->whereColumn('products.id', 'send_transactions.product_id')
                    ->limit(1)
            ]);
        }

        if ($type === 'buy') {
            $query->whereDoesntHave('refund');
        }

        // Filter Status
        if ($status && in_array($status, ['selesai', 'berjalan', 'dibatalkan'])) { // HAPUS 'refund'
            if ($status === 'selesai') {
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
        return view('_superadmin.transactions.index', compact('title', 'transactions', 'type'));
    }

    public function export(Request $request)
    {
        // $transactionId = $request->get('transaction_id');
        $type = $request->get('type', 'buy');

        // JIKA ADA transaction_id → EXPORT 1 TRANSAKSI SAJA
        //if ($transactionId) {
        //    $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;
        //    $transaction = $model::with([
        //        'buyer.detail', 'traveler.detail', 'sender.detail', 'reciever.detail',
        //        'product.category', 'paymentMethod'
        //    ])->findOrFail($transactionId);

        //    $filename = ($type === 'buy' ? 'Detail_Titip_Beli' : 'Detail_Titip_Kirim');
        //    $filename .= "_ID{$transaction->id}_" . now()->format('Y-m-d') . '.xlsx';

        //    return Excel::download(
        //        new TransactionsDetailExport($transaction, $type),
        //        $filename
        //    );
        //}

        // JIKA TIDAK → EXPORT DAFTAR (SEPERTI BIASA)
        $filename = $type === 'buy' ? 'Transaksi_Titip_Beli' : 'Transaksi_Titip_Kirim';
        $filename .= '_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new TransactionsExport($request->all()), $filename);
    }

    public function edit($id)
    {
        $type = request('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;

        $transaction = $model::with(
            $type === 'buy'
                ? ['buyer.detail', 'traveler.detail', 'product.category', 'paymentMethod']
                : ['sender.detail', 'reciever.detail', 'product.category', 'paymentMethod']
        )->findOrFail($id);

        return view('_superadmin.transactions.edit', compact('transaction', 'type'));
    }

    public function update(Request $request, $id)
    {
        $type = $request->input('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;
        $transaction = $model::findOrFail($id);

        // VALIDASI BERBEDA PER TIPE
        $rules = [
            'payment_status' => 'required|in:pending,approved,declined',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($type === 'buy') {
            $rules += [
                'quantity' => 'required|integer|min:1',
                'total_price' => 'required|numeric|min:0',
            ];
        } else { // send
            $rules += [
                'weight' => 'nullable|numeric|min:0',
                'dimension' => 'nullable|string|max:50',
                'delivery_code' => 'nullable|string|max:50',
                'delivery_method' => 'nullable|string|max:50',
                'delivery_type' => 'nullable|in:Dalam Negeri,Luar Negeri',
                'pickup_address' => 'nullable|string',
                'delivery_address' => 'nullable|string',
            ];
        }

        $validated = $request->validate($rules);

        // Upload bukti
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $path;
        }

        // SIMPAN weight JIKA DIISI
        if ($request->filled('weight')) {
            $validated['weight'] = (string) $request->weight;
        }

        $transaction->update($validated);

        return redirect()
            ->route('superadmin.transactions', ['type' => $type, 'transaction_id' => $id])
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id = null)
    {
        $type = request('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;

        // Support when $id is not provided as a method parameter (use route param or request input)
        if (!isset($id)) {
            $id = request()->route('id') ?? request('id') ?? request('transaction_id');
        }

        $transaction = $model::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}