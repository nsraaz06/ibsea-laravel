<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiative extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'custom_url',
        'summary',
        'content',
        'banner_path',
        'logo_path',
        'pdf_path',
        'youtube_link',
        'icon',
        'organizer_name',
        'organizer_role',
        'organizer_image_path',
        'organizer_email',
        'organizer_linkedin',
        'is_active',
        'sort_order',
    ];

    public function getBannerUrlAttribute()
    {
        return $this->banner_path ? asset($this->banner_path) : null;
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset($this->logo_path) : null;
    }

    public function getPdfUrlAttribute()
    {
        return $this->pdf_path ? asset($this->pdf_path) : null;
    }

    public function getOrganizerImageUrlAttribute()
    {
        return $this->organizer_image_path ? asset($this->organizer_image_path) : asset('image/default-avatar.png');
    }
}
