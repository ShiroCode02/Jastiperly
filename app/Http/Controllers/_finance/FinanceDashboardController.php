<?php

namespace App\Http\Controllers\_finance;

use App\Http\Controllers\Controller;

class FinanceDashboardController extends Controller
{
    public function index()   { return view('_finance.dashboard.index'); }
    public function index2()  { return view('_finance.dashboard.index2'); }
    // Tambah method index3 sampai index10 sesuai kebutuhan
}
