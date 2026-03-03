<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'category',
        'content',
        'featured_image',
        'show_on_slider',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'show_on_slider' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the author of the post.
     */
    public function author()
    {
        return $this->belongsTo(Member::class, 'author_id');
    }
}
