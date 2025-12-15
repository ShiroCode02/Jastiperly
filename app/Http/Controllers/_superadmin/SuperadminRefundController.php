<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperadminRefundController extends Controller
{
    public function index()
    {
        $title = 'Refund';
        return view('_superadmin.refunds.index', compact('title'));
    }
}
