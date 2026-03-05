<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'slug', 'thumbnail', 'description', 'category', 
        'price', 'duration', 'access_type', 'membership_type', 'is_published',
        'certificate_template_id'
    ];

    public function modules()
    {
        return $this->hasMany(CourseModule::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function completions()
    {
        return $this->hasMany(CourseLessonCompletion::class);
    }

    public function certificateTemplate()
    {
        return $this->belongsTo(DesignTemplate::class, 'certificate_template_id');
    }
}
