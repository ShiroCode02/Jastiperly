<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperadminSettingController extends Controller
{
    public function index()
    {        
        $user = Auth::user();
        if ($user) {
            $user = User::with('detail')->find($user->id);
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
            $user = User::with('detail')->find($user->id);
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
        $rules = [
            'profile_image' => 'nullable|image|mimes:jpg,png|max:10240',
        ];
        $messages = [
            'profile_image.image' => 'Foto profil harus berupa gambar.',
            'profile_image.mimes' => 'Foto profil harus format jpg atau png.',
            'profile_image.max' => 'Foto profil maksimal 10MB.',
        ];

        if ($request->filled('username') || $request->filled('email') || $request->filled('full_name')) { // Kalau ada input teks (dari tab profil), require mereka
            $rules = array_merge($rules, [
                'username' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'full_name' => 'required|string|max:120',
                'phone' => 'nullable|string|max:20',
                'gender' => 'nullable|in:Laki-laki,Perempuan',
                'address' => 'nullable|string',
            ]);
            $messages = array_merge($messages, [
                'username.required' => 'Username tidak boleh kosong.',
                'username.max' => 'Username maksimal 100 karakter.',
                'email.required' => 'Email tidak boleh kosong.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'full_name.required' => 'Nama lengkap tidak boleh kosong.',
                'full_name.max' => 'Nama lengkap maksimal 120 karakter.',
                'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            ]);
        }

        $request->validate($rules, $messages);

        // update users table kalau ada input
        if ($request->filled('username')) $user->name = $request->username;
        if ($request->filled('email')) $user->email = $request->email;
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
        $user->save();

        // update user_details kalau ada input
        $detailUpdates = [];
        if ($request->filled('full_name')) $detailUpdates['name'] = $request->full_name;
        if ($request->filled('phone')) $detailUpdates['phone'] = $request->phone;
        if ($request->filled('gender')) $detailUpdates['gender'] = $request->gender;
        if ($request->filled('address')) $detailUpdates['address'] = $request->address;
        if (!empty($detailUpdates)) $user->detail->update($detailUpdates);

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
