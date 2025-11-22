<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetailHistory extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Format tanggal Indonesia
    public function getTanggalAttribute()
    {
        return \Carbon\Carbon::parse($this->changed_at)->translatedFormat('l, j F Y');
    }
}