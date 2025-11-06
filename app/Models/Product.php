<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'submiter_id',
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'status',
        'approval',
        'reject_reason',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function submiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submiter_id');
    }
}