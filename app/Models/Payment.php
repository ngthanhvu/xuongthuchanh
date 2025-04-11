<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'course_id', 'payment_date', 'amount', 'payment_method', 'status', 'coupon_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}