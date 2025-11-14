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

    public function approve(Refund $refund)
    {
        $refund->update(['status' => 'approved']);
        return back()->with('success', 'Refund disetujui!');
    }

    public function decline(Refund $refund)
    {
        $refund->update(['status' => 'declined']);
        return back()->with('error', 'Refund ditolak!');
    }

    public function export(Request $request)
    {
        return Excel::download(new RefundsExport($request->all()), 'refund-data.xlsx');
    }
}