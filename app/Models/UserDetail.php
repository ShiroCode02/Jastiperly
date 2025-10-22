<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id', 'verified_type', 'name', 'phone', 'address', 'date_birth',
        'gender', 'bank_name', 'bank_number', 'id_card_image', 'pasport_image', 'account_image'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}