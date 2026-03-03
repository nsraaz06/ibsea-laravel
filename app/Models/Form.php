<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'fields',
        'settings',
        'is_active'
    ];

    protected $casts = [
        'fields' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($form) {
            if (!$form->slug) {
                $form->slug = Str::slug($form->title);
            }
        });
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }
}
