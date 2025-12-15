<?php

namespace App\Http\Controllers\_finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceSettingController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Pengaturan';

        // sementara kosong, bisa ditambah pengaturan nanti
        return view('_finance.settings.index', compact('title'));
    }
}
