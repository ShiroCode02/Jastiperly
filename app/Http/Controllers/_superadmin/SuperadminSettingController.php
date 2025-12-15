<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperadminSettingController extends Controller
{
    public function index()
    {
        $title = 'Pengaturan';
        return view('_superadmin.settings.index', compact('title'));
    }
}
