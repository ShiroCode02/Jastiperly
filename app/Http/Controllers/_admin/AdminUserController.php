<?php

namespace App\Http\Controllers\_admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Manajemen Pelanggan';

        // Role yang dapat dilihat oleh Admin
        $allowedRoles = ['traveler', 'customer'];

        // Query user
        $query = User::with('detail')
            ->whereIn('role', $allowedRoles)
            ->orderBy('id', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter tab (Traveler, Penitip)
        if ($request->filled('tab')) {
            $tab = $request->input('tab');
            $roleMap = [
                'Traveler' => 'traveler',
                'Penitip' => 'customer',
            ];
            if (isset($roleMap[$tab])) {
                $query->where('role', $roleMap[$tab]);
            }
        }

        $users = $query->paginate(10);

        return view('_admin.user.index', compact('users', 'title'));
    }
}