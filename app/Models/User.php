<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'account_status',
        'profile_image',
        'preference',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'account_status' => 'string',
            'preference' => 'array',
        ];
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function detailHistories()
    {
        return $this->hasMany(UserDetailHistory::class)->latest('changed_at');
    }

    // FIX: Status online/offline yang benar & aman
    public function getDisplayStatusAttribute(): string
    {
        if ($this->account_status === 'inactive') {
            return __('messages.users_status.inactive');
        }

        $isOnline = DB::table('sessions')
            ->where('user_id', $this->id)
            ->whereNotNull('user_id')
            ->exists();

        if ($isOnline) {
            return __('messages.users_status.Online');
        }

        $hasLoggedIn = \App\Models\LoginHistory::where('user_id', $this->id)->exists();

        return $hasLoggedIn ? __('messages.users_status.Offline') : __('messages.users_status.active');
    }

    // Profile image
    protected $appends = ['profile_image_url'];

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image
            ? Storage::url($this->profile_image)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) 
              . '&color=344CB7&background=EBF4FF&bold=true&size=256';
    }
}