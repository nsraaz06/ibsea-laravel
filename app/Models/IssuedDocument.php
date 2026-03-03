<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_no',
        'member_id',
        'event_booking_id',
        'document_type',
        'year',
        'sequence_number',
        'issued_at'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function eventBooking()
    {
        return $this->belongsTo(EventBooking::class);
    }
}
