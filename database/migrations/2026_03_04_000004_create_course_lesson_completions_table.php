<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_lesson_completions', function (Blueprint $row) {
            $row->id();
            $row->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $row->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $row->foreignId('lesson_id')->constrained('course_lessons')->onDelete('cascade');
            $row->timestamps();
            
            // Prevent duplicate completion records
            $row->unique(['member_id', 'lesson_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_lesson_completions');
    }
};
