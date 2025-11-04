<?php

namespace App\Http\Controllers\_admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()   { return view('_admin.dashboard.index'); }
    public function index2()  { return view('_admin.dashboard.index2'); }
    // Tambah method index3 sampai index10 sesuai kebutuhan
}