<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'event_id', 'ticket_id', 'payment_id', 'is_pass_usage', 'pass_source', 'status', 'secret_token'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket()
    {
        return $this->belongsTo(EventTicket::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
