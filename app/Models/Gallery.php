<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image_path', 'event_id', 'category', 'order'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
