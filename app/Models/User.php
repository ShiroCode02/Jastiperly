<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
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
        'name',
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

        if ($lastActivity) {
            return 'Online';
        }

        $minutesAgo = now()->diffInMinutes(Carbon::createFromTimestamp(!$lastActivity));

        if ($minutesAgo < 1) {
            return 'Offline';
        }

        return 'Aktif';
    }

    public function detailHistories()
    {
        return $this->hasMany(UserDetailHistory::class);
    }

    protected $appends = ['profile_photo_url'];

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? Storage::url($this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}