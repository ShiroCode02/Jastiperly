<?php

namespace App\Http\Controllers\_finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceConsignorController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Penitip';

        // sementara kosong, bisa ditambah data penitip nanti
         return view('_finance.consignors.index', compact('title'));
    }
}
