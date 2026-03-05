<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    protected $fillable = ['quiz_id', 'question', 'type'];

    public function quiz()
    {
        return $this->belongsTo(CourseQuiz::class, 'quiz_id');
    }

    public function answers()
    {
        return $this->hasMany(CourseAnswer::class, 'question_id');
    }
}
