<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'content',
        'image_path',
        'is_active',
        'sort_order',
    ];

    /**
     * Get the full URL of the image.
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset($this->image_path) : asset('assets/images/placeholder-user.png');
    }
}
