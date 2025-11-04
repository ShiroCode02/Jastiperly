<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SendTransaction extends Model
{
    protected $fillable = [
        'sender_id', 'reciever_id', 'product_id', 'dimension', 'weight', 'delivery_code',
        'delivery_method', 'delivery_type', 'delivery_image', 'payment_method_id', 'payment_proof',
        'payment_status'
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function reciever(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}