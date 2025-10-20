<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $role = auth()->user()->role;

        return match ($role) {
            'admin' => redirect('/admin/dashboard'),
            'finance' => redirect('/finance/dashboard'),
            'superadmin' => redirect('/superadmin/dashboard'),
            default => redirect('/'),
        };
    }
}