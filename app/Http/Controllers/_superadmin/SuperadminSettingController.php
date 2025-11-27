<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperadminSettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $user->load('detail');
        } else {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }        
        return view('_superadmin.settings.index', compact('user'));
    }


    public function update(Request $request)
    {
        $tab = $request->query('tab', 'profil');
        $user = Auth::user();
        if ($user) {
            $user->load('detail');
        } else {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        switch ($tab) {

            case 'profil':
                return $this->updateProfile($request, $user);

            case 'preferensi':
                return $this->updatePreference($request, $user);

            case 'keamanan':
                return $this->updateSecurity($request, $user);

            default:
                return back()->with('error', 'Tab tidak dikenali.');
        }
    }


    private function updateProfile(Request $request, $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:120',
            'email' => 'required|email',
            'username' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
        ]);

        // update users table
        $user->name = $request->full_name;
        $user->email = $request->email;
        $user->save();

        // update user_details
        $user->detail->update([
            'name' => $request->username,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }


    private function updatePreference(Request $request, $user)
    {
        $request->validate([
            'language' => 'nullable|in:id,en',
        ]);

        // Jika kamu punya tabel preferences khusus, arahkan ke situ.
        // Untuk sementara simpan ke session atau tambahkan kolom di user table.

        // Contoh sederhana: simpan ke session
        if ($request->language) {
            session(['language' => $request->language]);
        }

        return back()->with('success', 'Preferensi berhasil diperbarui.');
    }


    private function updateSecurity(Request $request, $user)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        // update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
