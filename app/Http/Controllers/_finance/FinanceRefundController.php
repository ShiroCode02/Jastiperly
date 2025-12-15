<?php

namespace App\Http\Controllers\_finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceRefundController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Refund';

        // sementara kosong, bisa ditambah data refund nanti
        return view('_finance.refunds.index', compact('title'));
    }
}
