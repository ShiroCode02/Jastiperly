<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
        'account_status', // Tambahkan kolom baru
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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

    public function getDisplayStatusAttribute(): string
    {
        if ($this->account_status === 'inactive') {
            return 'Nonaktif';
        }

        $lastActivity = DB::table('sessions')
            ->where('user_id', $this->id)
            ->max('last_activity');

        // Belum pernah login / session sudah expired (logout otomatis)
        if (!$lastActivity) {
            return 'Offline';
        }

        $minutesAgo = now()->diffInMinutes(Carbon::createFromTimestamp($lastActivity));

        if ($minutesAgo < 1) {
            return 'Online';
        }

        // Masih ada session aktif = masih login, walau sudah agak lama
        return 'Aktif';
    }
}