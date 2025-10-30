<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperadminUserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Manajemen Pengguna';

        // Role yang dapat ditampilkan oleh Superadmin
        $allowedRoles = ['traveler', 'customer', 'admin', 'finance'];

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

        // Filter tab (Traveler, Penitip, Admin, Finance)
        if ($request->filled('tab')) {
            $tab = $request->input('tab');
            $roleMap = [
                'Traveler' => 'traveler',
                'Penitip' => 'customer',
                'Admin' => 'admin',
                'Finance' => 'finance',
            ];
            if (isset($roleMap[$tab])) {
                $query->where('role', $roleMap[$tab]);
            }
        }

        $users = $query->paginate(10);

        return view('_superadmin.users.index', compact('users', 'title'));
    }
}