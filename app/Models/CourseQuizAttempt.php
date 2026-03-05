<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseQuizAttempt extends Model
{
    protected $fillable = ['user_id', 'quiz_id', 'score', 'is_passed'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }

    public function quiz()
    {
        return $this->belongsTo(CourseQuiz::class, 'quiz_id');
    }
}
