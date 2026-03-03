<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'layout_json',
        'background_path',
        'width',
        'height',
        'status'
    ];

    protected $casts = [
        'layout_json' => 'array',
        'status' => 'boolean',
        'width' => 'float',
        'height' => 'float'
    ];

    /**
     * Get the resolved URL for the background image.
     */
    public function getBackgroundUrlAttribute()
    {
        if (empty($this->background_path)) {
            return null;
        }

        // If it's already a full URL, return it directly
        if (filter_var($this->background_path, FILTER_VALIDATE_URL)) {
            return $this->background_path;
        }

        // Otherwise, resolve via storage
        return asset('storage/' . $this->background_path);
    }
}
