<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BuyTransaction extends Model
{
    protected $fillable = [
        'buyer_id', 'traveler_id', 'product_id', 'quantity', 'total_price', 'delivery_type', 
        'payment_method_id', 'payment_proof', 'payment_status'
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function traveler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'traveler_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }
}