<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = ['type', 'name', 'account_name', 'account_number'];

    public function buyTransactions(): HasMany
    {
        return $this->hasMany(BuyTransaction::class);
    }

    public function sendTransactions(): HasMany
    {
        return $this->hasMany(SendTransaction::class);
    }
}