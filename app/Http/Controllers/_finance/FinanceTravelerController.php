<?php

namespace App\Http\Controllers\_finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceTravelerController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Traveler';

        // sementara kosong, bisa ditambah data traveler nanti
        return view('_finance.travelers.index', compact('title'));
    }
}
