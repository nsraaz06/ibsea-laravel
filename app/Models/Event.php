<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'event_date', 'start_time', 'end_time', 'venue', 'city', 'state',
        'description', 'pdf_link', 'featured_image', 'status', 'is_featured',
        'certificate_template_id', 'ticket_template_id'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function getBannerImageAttribute()
    {
        return $this->featured_image;
    }

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }

    public function bookings()
    {
        return $this->hasMany(EventBooking::class);
    }
}
