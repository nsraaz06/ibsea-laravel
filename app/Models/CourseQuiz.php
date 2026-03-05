<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseQuiz extends Model
{
    protected $fillable = ['module_id', 'title', 'pass_percentage'];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function questions()
    {
        return $this->hasMany(CourseQuestion::class, 'quiz_id');
    }

    public function attempts()
    {
        return $this->hasMany(CourseQuizAttempt::class, 'quiz_id');
    }
}
