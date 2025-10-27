<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Tentukan judul halaman berdasarkan role
        $title = Auth::user()->role === 'superadmin' ? 'Manajemen Pengguna' : 'Manajemen Pelanggan';

        // Ambil role yang diizinkan berdasarkan user yang login
        $allowedRoles = Auth::user()->role === 'superadmin' 
            ? ['traveler', 'customer', 'admin', 'finance'] 
            : ['traveler', 'customer'];

        // Query user berdasarkan role yang diizinkan
        $query = User::with('detail')
            ->whereIn('role', $allowedRoles)
            ->orderBy('id', 'desc');

        // Filter pencarian (opsional)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tab (Traveler, Penitip, Admin, Finance)
        if ($request->filled('tab')) {
            $tab = $request->input('tab');
            $roleMap = [
                'Traveler' => 'traveler',
                'Penitip' => 'customer',
                'Admin' => 'admin',
                'Finance' => 'finance'
            ];
            if (isset($roleMap[$tab])) {
                $query->where('role', $roleMap[$tab]);
            }
        }

        $users = $query->paginate(10);

        return view(Auth::user()->role === 'superadmin' ? '_superadmin.user.index' : '_admin.user.index', compact('users', 'title'));
    }
}