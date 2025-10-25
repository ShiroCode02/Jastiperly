<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SuperadminUserController extends Controller
{
    public function __construct()
    {
        // Menu Superadmin, sama dengan Dashboard
        $menus = [
            ['name' => 'Dashboard', 'icon' => 'dashboard.svg', 'route' => 'superadmin.dashboard'],
            ['name' => 'Manajemen Pengguna', 'icon' => 'users.svg', 'route' => 'superadmin.users'],
            ['name' => 'Manajemen Produk', 'icon' => 'product.svg'],
            ['name' => 'Transaksi', 'icon' => 'transaction.svg'],
            ['name' => 'Refund', 'icon' => 'refund.svg'],
            ['name' => 'Pengaturan', 'icon' => 'settings.svg'],
        ];

        View::share('menus', $menus);
    }

    public function index()
    {
        // Data dummy untuk simulasi (ganti dengan model User jika sudah ada)
        $users = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['id' => 3, 'name' => 'Alice Johnson', 'email' => 'alice@example.com'],
        ];

        return view('_superadmin.User.index', [
            'users' => $users,
        ]);
    }
}