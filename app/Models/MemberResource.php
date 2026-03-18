<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberResource extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'category_id', 'category', 'description', 'file_path', 'cover_image', 'is_active', 'show_on_home'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resourceCategory()
    {
        return $this->belongsTo(ResourceCategory::class, 'category_id');
    }
}
