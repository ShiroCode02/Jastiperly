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
        $type = $request->get('type', 'buy');
        $status = $request->get('status');
        $location = $request->get('location');
        $search = $request->get('search');

        $query = $type === 'buy' ? BuyTransaction::query() : SendTransaction::query();

        if ($type === 'buy') {
            $query->with(['buyer.detail', 'traveler.detail', 'paymentMethod', 'product.category']);
            $query->whereDoesntHave('refund');
        } else {
            $query->with(['sender.detail', 'reciever.detail', 'paymentMethod', 'product.category']);
            $query->addSelect([
                'calculated_total' => \App\Models\Product::select('price')
                    ->whereColumn('products.id', 'send_transactions.product_id')
                    ->limit(1)
            ]);
        }

        if ($status && in_array($status, ['selesai', 'berjalan', 'dibatalkan'])) {
            if ($status === 'selesai') $query->where('payment_status', 'approved');
            elseif ($status === 'berjalan') $query->where('payment_status', 'pending');
            elseif ($status === 'dibatalkan') $query->where('payment_status', 'declined');
        }

        if ($type === 'send' && $location) {
            $delivery_type = $location === 'dalam' ? 'Dalam Negeri' : 'Luar Negeri';
            $query->where('delivery_type', $delivery_type);
        }

        if ($search) {
            $query->where(function ($q) use ($search, $type) {
                $q->whereHas($type === 'buy' ? 'buyer.detail' : 'sender.detail', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })->orWhere('id', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10)->appends($request->query());
        return view('_superadmin.transactions.index', compact('title', 'transactions', 'type'));
    }

    public function show($transaction, Request $request)
    {
        $type = $request->get('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;

        $transaction = $model::with(
            $type === 'buy'
                ? ['buyer.detail', 'traveler.detail', 'product.category', 'paymentMethod', 'refund']
                : ['sender.detail', 'reciever.detail', 'product.category', 'paymentMethod']
        )->findOrFail($transaction);

        return view('_superadmin.transactions.detail', compact('transaction', 'type'));
    }

    public function edit($id = null)
    {
        $type = request('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;

        if (!isset($id)) {
            $id = request()->route('id') ?? request('id') ?? request('transaction');
        }

        $transaction = $model::with(
            $type === 'buy'
                ? ['buyer.detail', 'traveler.detail', 'product.category', 'paymentMethod']
                : ['sender.detail', 'reciever.detail', 'product.category', 'paymentMethod']
        )->findOrFail($id);

        return view('_superadmin.transactions.edit', compact('transaction', 'type'));
    }

    public function update($id = null)
    {
        if (!isset($id)) {
            $id = request()->route('id') ?? request('id') ?? request('transaction');
        }
        if (!$id) abort(400, 'ID Transaksi wajib diisi.');

        $type = request()->input('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;
        $transaction = $model::findOrFail($id);

        $rules = ['payment_status' => 'required|in:pending,approved,declined', 'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'];
        if ($type === 'buy') {
            $rules += ['quantity' => 'required|integer|min:1', 'total_price' => 'required|numeric|min:0'];
        } else {
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

        $validated = request()->validate($rules);

        if (request()->hasFile('payment_proof')) {
            $path = request()->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $path;
        }
        if (request()->filled('weight')) $validated['weight'] = (string) request()->input('weight');

        $transaction->update($validated);

        return redirect()
            ->route('superadmin.transactions.show', ['transaction' => $id, 'type' => $type])
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id = null)
    {
        $type = request('type', 'buy');
        $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;

        $transactionId = $id ?? request()->route('id') ?? request('id') ?? request('transaction');
        if (!$transactionId) abort(400, 'Transaction ID is required');

        $transaction = $model::findOrFail($transactionId);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function export()
    {
        $type = request()->get('type', 'buy');
        $transactionId = request()->get('transaction'); // GANTI: transaction_id → transaction

        if ($transactionId) {
            $model = $type === 'buy' ? BuyTransaction::class : SendTransaction::class;
            $with = $type === 'buy'
                ? ['buyer.detail', 'traveler.detail', 'product.category', 'paymentMethod']
                : ['sender.detail', 'reciever.detail', 'product.category', 'paymentMethod'];
            $transaction = $model::with($with)->findOrFail($transactionId);
            $filename = ($type === 'buy' ? 'Detail_Titip_Beli' : 'Detail_Titip_Kirim');
            $filename .= "_ID{$transaction->id}_" . now()->format('Y-m-d') . '.xlsx';
            return Excel::download(new TransactionsDetailExport($transaction, $type), $filename);
        }

        $filename = $type === 'buy' ? 'Transaksi_Titip_Beli' : 'Transaksi_Titip_Kirim';
        $filename .= '_' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new TransactionsExport(request()->all()), $filename);
    }
}