<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'expiry_date',
        'usage_limit',
        'used_count',
        'min_amount',
        'status',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'value' => 'decimal:2',
        'min_amount' => 'decimal:2',
    ];

    /**
     * Check if the coupon is valid for a given amount and member.
     */
    public function isValid($amount = 0, $memberId = null)
    {
        if ($this->status !== 'Active') {
            return [false, 'Coupon is inactive.'];
        }

        if ($this->expiry_date && Carbon::now()->gt($this->expiry_date)) {
            return [false, 'Coupon has expired.'];
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return [false, 'Coupon usage limit reached.'];
        }

        if ($amount < $this->min_amount) {
            return [false, 'Minimum amount of ₹' . number_format($this->min_amount) . ' required to use this coupon.'];
        }

        if ($memberId) {
            $alreadyUsed = \App\Models\Payment::where('member_id', $memberId)
                ->where('coupon_id', $this->id)
                ->where('status', 'Success')
                ->exists();
            
            if ($alreadyUsed) {
                return [false, 'You have already used this coupon once.'];
            }
        }

        return [true, 'Coupon applied successfully.'];
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount($amount)
    {
        if ($this->type === 'percent') {
            return ($amount * $this->value) / 100;
        }

        return min($this->value, $amount); // Ensure discount doesn't exceed amount
    }
}
