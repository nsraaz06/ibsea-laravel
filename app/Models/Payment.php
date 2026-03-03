<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'amount', 'currency', 'payment_type', 'item_id', 
        'razorpay_order_id',        'cashfree_order_id',
        'payment_session_id',
        'status',
        'gateway',
        'coupon_id',
        'discount_amount'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
