<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BuyTransaction;
use App\Models\SendTransaction;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
            $query->where(function($q) use ($search) {
                $q->whereHas('detail', fn($qq) => $qq->where('name', 'like', "%{$search}%"))
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

        return view('_superadmin.users.index', compact('users', 'totalUsers'));
    }

    public function show(User $user)
    {
        $user->load('detail');

        $last = LoginHistory::where('user_id', $user->id)
        ->latest('logged_in_at')
        ->first();

        // Data login terakhir
        $user->last_login_at = $last?->logged_in_at
            ? \Carbon\Carbon::parse($last->logged_in_at)->setTimezone('Asia/Jakarta')
            : null;

        $user->last_login_device = $last && $last->user_agent
            ? $this->parseDevice($last->user_agent)
            : '-';
        // ===========================================================================

        // Pisah alamat dan kota/negara
        if ($user->detail?->address) {
            $address = trim($user->detail->address);
            $parts = array_filter(array_map('trim', explode(',', $address)));

            // Kalau ada koma DAN lebih dari 1 bagian → bagian terakhir = Kota/Negara
            if (count($parts) > 1) {
                $user->city_country = end($parts);
                array_pop($parts);
                $user->detail_address = implode(', ', $parts);
            }
            // Kalau gak ada koma atau cuma 1 bagian → semua jadi alamat, kota kosong
            else {
                $user->city_country = '-';
                $user->detail_address = $address;
            }
        } else {
            $user->city_country = '-';
            $user->detail_address = '-';
        }
        // ===========================================================================

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
        // ===========================================================================

        // Grafik aktivitas login 7 hari terakhir
        $weekStart = Carbon::now('UTC')->startOfWeek()->startOfDay();
        $weekEnd = Carbon::now('UTC')->endOfWeek()->endOfDay();

        // Ambil data login dalam seminggu terakhir
        $rawLogins = LoginHistory::where('user_id', $user->id)
            ->where('logged_in_at', '>=', $weekStart)
            ->orderBy('logged_in_at')
            ->get();

        $dailyActivity = [];

        foreach ($rawLogins as $login) {
            // Pastikan semua waktu dalam WIB (Asia/Jakarta)
            $loginTime = $login->logged_in_at->setTimezone('Asia/Jakarta');
            $dateKey = $loginTime->format('Y-m-d');

            $endTime = $login->logged_out_at
                ? $login->logged_out_at->setTimezone('Asia/Jakarta')
                : now()->setTimezone('Asia/Jakarta');

            // Hitung durasi dalam jam
            $hours = $loginTime->diffInSeconds($endTime) / 3600.0;

            if (!isset($dailyActivity[$dateKey])) {
                $dailyActivity[$dateKey] = 0;
            }
            $dailyActivity[$dateKey] += $hours;
        }

        // Isi 7 hari terakhir (kalau gak ada data = 0 jam)
        $chartData = [];
        $chartLabels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $dayName = $date->locale('id')->translatedFormat('l, j F');

            $chartLabels[] = $dayName;
            $chartData[] = round($dailyActivity[$dateKey] ?? 0, 2); // 2 desimal
        }

        $user->chart_labels = $chartLabels;
        $user->chart_data = $chartData;
        // ===========================================================================

        // Grafik transaksi (traveler & customer)
        if (in_array($user->role, ['traveler', 'customer'])) {
            // MINGGU MULAI DARI SENIN — SESUAI INDONESIA!
            $now = Carbon::now('Asia/Jakarta');
            $startOfWeek = $now->copy()->startOfWeek(Carbon::MONDAY); // Senin
            $endOfWeek = $now->copy()->endOfWeek(Carbon::MONDAY);     // Minggu depan

            $start = $startOfWeek->startOfDay();
            $end = $endOfWeek->addWeek()->startOfDay(); // sampai Minggu malam

            // Query dengan CONVERT_TZ + tanggal WIB
            $buyCount = BuyTransaction::where(
                    $user->role === 'traveler' ? 'traveler_id' : 'buyer_id', $user->id
                )
                ->whereBetween('created_at', [$start->copy()->utc(), $end->copy()->utc()])
                ->selectRaw('DATE(CONVERT_TZ(created_at, "+00:00", "+07:00")) as date, COUNT(*) as total')
                ->groupBy('date')
                ->pluck('total', 'date');

            $sendCount = SendTransaction::where(
                    $user->role === 'traveler' ? 'sender_id' : 'reciever_id', $user->id
                )
                ->whereBetween('created_at', [$start->copy()->utc(), $end->copy()->utc()])
                ->selectRaw('DATE(CONVERT_TZ(created_at, "+00:00", "+07:00")) as date, COUNT(*) as total')
                ->groupBy('date')
                ->pluck('total', 'date');

            $dailyTransactions = $buyCount->merge($sendCount)
                ->groupBy('date')
                ->map->sum();

            $transactionData = [];
            $transactionLabels = [];

            // Loop 7 hari: Senin → Minggu
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $dateKey = $date->format('Y-m-d');
                $dayName = $date->locale('id')->translatedFormat('l, j F');

                $transactionLabels[] = $dayName;
                $transactionData[] = $dailyTransactions[$dateKey] ?? 0;
            }

            $user->transaction_labels = $transactionLabels;
            $user->transaction_data = $transactionData;
        } else {
            $user->transaction_labels = [];
            $user->transaction_data = [];
        }
        // ===========================================================================

        $user->detailHistories = $user->detailHistories()
            ->orderBy ('changed_at', 'desc')
            ->paginate(5);
        
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

    public function edit(User $user)
    {
        $user->load('detail');
        return view('_superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:traveler,customer,admin,finance,superadmin',
            'account_status' => 'required|in:active,inactive',
            // detail
            'detail.name' => 'required|string|max:255',
            'detail.phone' => 'nullable|string|max:20',
            'detail.address' => 'nullable|string',
            'detail.date_birth' => 'nullable|date',
            'detail.gender' => 'nullable|in:Laki-laki,Perempuan',
            'detail.bank_name' => 'nullable|string',
            'detail.bank_number' => 'nullable|string',
        ]);

        // Update user
        $user->update($request->only('name', 'email', 'role', 'account_status'));

        // Update atau buat user_detail
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $request->input('detail', [])
        );

        return redirect()
            ->route('superadmin.users.show', $user)
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function toggleStatus(User $user)
    {
        $user->account_status = $user->account_status === 'active' ? 'inactive' : 'active';
        $user->save();

        return back()->with('success', 'Status akun berhasil diubah!');
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
        $userId = $request->get('user');

        // Jika user ID dikirim → Export detail user
        if ($userId) {
            $user = User::with('detail')->findOrFail($userId);
            $filename = 'Detail_User_ID' . $user->id . '_' . now()->format('Y-m-d') . '.xlsx';

            return Excel::download(new \App\Exports\UserDetailExport($user), $filename);
        }

        // Jika tidak ada user → export daftar user (default)
        return Excel::download(new UsersExport($request), 'data-pengguna.xlsx');
    }
}