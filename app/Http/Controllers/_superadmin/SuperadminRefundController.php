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

    public function show($id)
    {
        $refund = Refund::with(['buyTransaction.buyer.detail', 'buyTransaction.traveler.detail', 'buyTransaction.product'])->findOrFail($id);
        return view('_superadmin.refunds.show', compact('refund'));
    }

    public function export(Request $request)
    {
        return Excel::download(new RefundsExport($request->all()), 'refund-data.xlsx');
    }
}