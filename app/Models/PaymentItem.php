<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    use HasFactory;

    protected $table = 'payments_item';

    protected $fillable = [
        'payment_id',
        'course_id',
        'amount',
        'description',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}