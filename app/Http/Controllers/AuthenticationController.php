<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function forgotPassword()
    {
        return view('authentication/forgotPassword');
    }

    public function signIn()
    {
        return view('authentication/signIn');
    }

    public function signUp()
    {
        return view('authentication/signUp');
    }

    // 👉 Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect sesuai role
            return match ($user->role) {
                'admin' => redirect('/admin/dashboard'),
                'finance' => redirect('/finance/dashboard'),
                'superadmin' => redirect('/superadmin/dashboard'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // 👉 Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // ganti sesuai route login kamu
    }
}