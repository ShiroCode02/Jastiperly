<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        ];
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function detailHistories()
    {
        return $this->hasMany(UserDetailHistory::class);
    }

    // FIX: Status online/offline yang benar & aman
    public function getDisplayStatusAttribute(): string
    {
        if ($this->account_status === 'inactive') {
            return 'Nonaktif';
        }

        $lastActivity = DB::table('sessions')
            ->where('user_id', $this->id)
            ->max('last_activity');

        if (!$lastActivity) {
            return 'Offline';
        }

        $minutesAgo = now()->diffInMinutes(Carbon::createFromTimestamp($lastActivity));

        return $minutesAgo < 5 ? 'Online' : 'Aktif';
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