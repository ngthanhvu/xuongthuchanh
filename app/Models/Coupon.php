<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order_value',
        'max_discount_amount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'coupon_id');
    }

    public function isValid()
    {
        $now = now();
        return $this->is_active &&
               ($this->start_date === null || $this->start_date <= $now) &&
               ($this->end_date === null || $this->end_date >= $now) &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }
}