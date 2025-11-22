<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class SuperadminUserController extends Controller
{
    public function index(Request $request)
    {
        // Role yang dapat ditampilkan oleh Superadmin
        $allowedRoles = ['traveler', 'customer', 'admin', 'finance'];

        // Total pengguna untuk tampilan
        $totalUsers = User::whereIn('role', $allowedRoles)->count();

        // Query user
        $query = User::with('detail')
            ->whereIn('role', $allowedRoles)
            ->orderBy('id', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('detail', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('email', 'like', "%{$search}%");
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

        return view('_superadmin.users.index', compact('users', 'totalUsers'));
    }

    public function show(User $user)
    {
        $user->load('detail');

        $last = LoginHistory::where('user_id', $user->id)
        ->latest('logged_in_at')
        ->first();

        // Perbaiki timezone jadi WIB (UTC+7)
        $user->last_login_at = $last?->logged_in_at
            ? \Carbon\Carbon::parse($last->logged_in_at)->timezone('UTC')
            : null;

        $user->last_login_device = $last && $last->user_agent
            ? $this->parseDevice($last->user_agent)
            : '-';

        // Hitung statistik traveler
        if ($user->role === 'traveler') {
            $user->total_transaction = BuyTransaction::where('traveler_id', $user->id)->count() + SendTransaction::where('sender_id', $user->id)->count();
            $user->successful_transaction = BuyTransaction::where('traveler_id', $user->id)->where('payment_status', 'approved')->count() + SendTransaction::where('sender_id', $user->id)->where('payment_status', 'approved')->count();
            $user->failed_transaction = BuyTransaction::where('traveler_id', $user->id)->where('payment_status', 'declined')->count() + SendTransaction::where('sender_id', $user->id)->where('payment_status', 'declined')->count();
        }

        // Hitung statistik customer
        if ($user->role === 'customer') {
            $user->total_transaction = BuyTransaction::where('buyer_id', $user->id)->count() + SendTransaction::where('reciever_id', $user->id)->count();
            $user->successful_transaction = BuyTransaction::where('buyer_id', $user->id)->where('payment_status', 'approved')->count() + SendTransaction::where('reciever_id', $user->id)->where('payment_status', 'approved')->count();
            $user->failed_transaction = BuyTransaction::where('buyer_id', $user->id)->where('payment_status', 'declined')->count() + SendTransaction::where('reciever_id', $user->id)->where('payment_status', 'declined')->count();
        }

        return view('_superadmin.users.detail', compact('user'));
    }

    private function parseDevice($ua)
    {
        $browser = 'Unknown';
        if (str_contains($ua, 'Edg/'))     $browser = 'Edge';
        elseif (str_contains($ua, 'Chrome'))  $browser = 'Chrome';
        elseif (str_contains($ua, 'Firefox')) $browser = 'Firefox';
        elseif (str_contains($ua, 'Safari') && !str_contains($ua, 'Chrome')) $browser = 'Safari';

        $os = 'Unknown';
        if (str_contains($ua, 'Windows NT 10.0')) $os = 'Windows 10/11';
        elseif (str_contains($ua, 'Windows NT 6.3'))  $os = 'Windows 8.1';
        elseif (str_contains($ua, 'Windows NT 6.2'))  $os = 'Windows 8';
        elseif (str_contains($ua, 'Windows NT 6.1'))  $os = 'Windows 7';
        elseif (str_contains($ua, 'Macintosh'))   $os = 'macOS';
        elseif (str_contains($ua, 'Android'))     $os = 'Android';
        elseif (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) $os = 'iOS';

        return "$browser - $os";
    }

    public function destroy(User $user)
    {
        // Hapus detail dulu (cascade manual kalau perlu)
        if ($user->detail) {
            $user->detail->delete();
        }

        $user->delete();

        return redirect()
            ->route('superadmin.users')
            ->with('success', 'Pengguna berhasil dihapus permanen.');
    }

    public function export(Request $request)
    {
        // SEMENTARA: EXPORT KOSONG / DUMMY BIAR TIDAK ERROR
        // Nanti diganti pakai Excel kalau sudah siap
        return response()->json(['message' => 'Export user belum tersedia'])->send();
        exit;

        // KALAU SUDAH SIAP PAKAI EXCEL:
        // return Excel::download(new UsersExport($request->all()), 'data-pengguna.xlsx');
    }
}