<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    protected $fillable = ['buy_transaction_id', 'reason', 'status'];

    public function buyTransaction(): BelongsTo
    {
        return $this->belongsTo(BuyTransaction::class);
    }
}