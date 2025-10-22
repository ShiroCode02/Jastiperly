<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;

class SuperadminDashboardController extends Controller
{
    public function index()   { return view('_superadmin.dashboard.index'); }
    public function index2()  { return view('_superadmin.dashboard.index2'); }
    // Tambah method index3 sampai index10 sesuai kebutuhan
}