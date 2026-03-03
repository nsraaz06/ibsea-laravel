<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'ticket_name', 'benefits', 'original_price', 'offer_price',
        'last_date_to_buy', 'ticket_quantity', 'allow_membership_pass', 'expiry_date'
    ];

    protected $casts = [
        'last_date_to_buy' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings()
    {
        return $this->hasMany(EventBooking::class, 'ticket_id');
    }
}
