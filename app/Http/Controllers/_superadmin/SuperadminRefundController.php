<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RefundsExport;

class SuperadminRefundController extends Controller
{
    public function index(Request $request)
    {
        $query = Refund::with(['buyTransaction.buyer.detail', 'buyTransaction.product']);

        if ($request->location) {
            $query->whereHas('buyTransaction.product', function ($q) use ($request) {
                $q->where('origin', 'like', "%{$request->location}%");
            });
        }

        if ($request->search) {
            $query->whereHas('buyTransaction', function ($q) use ($request) {
                $q->where('id', 'like', "%{$request->search}%")
                  ->orWhereHas('buyer.detail', function ($qq) use ($request) {
                      $qq->where('name', 'like', "%{$request->search}%");
                  });
            });
        }

        $refunds = $query->paginate(10);

        return view('_superadmin.refunds.index', compact('refunds'));
    }

    public function show(Refund $refund)
    {
        $refund->load(['buyTransaction.buyer.detail', 'buyTransaction.traveler.detail', 'buyTransaction.product.category', 'buyTransaction.paymentMethod']);
        return view('_superadmin.refunds.detail', compact('refund'));
    }

    public function edit(Refund $refund)
    {
        $refund->load(['buyTransaction.buyer.detail', 'buyTransaction.product']);
        return view('_superadmin.refunds.edit', compact('refund'));
    }

    public function update(Request $request, Refund $refund)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
            'status' => 'required|in:pending,approved,declined',
        ]);

        $refund->update($validated);

        return redirect()
            ->route('superadmin.refunds.show', $refund)
            ->with('success', 'Refund berhasil diperbarui.');
    }

    public function destroy(Refund $refund)
    {
        $refund->delete();

        return redirect()
            ->route('superadmin.refunds')
            ->with('success', 'Refund berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $filename = $request->has('refund')
            ? 'refund-detail-' . $request->refund . '.xlsx'
            : 'refund-data.xlsx';

        return Excel::download(new RefundsExport($request->all()), $filename);
    }
}