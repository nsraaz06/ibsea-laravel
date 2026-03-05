<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    protected $fillable = [
        'module_id', 'title', 'video_type', 'video_url', 
        'content', 'attachment_path', 'duration', 'order', 'is_preview', 'is_pdf_lesson'
    ];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function completions()
    {
        return $this->hasMany(CourseLessonCompletion::class, 'lesson_id');
    }
}
