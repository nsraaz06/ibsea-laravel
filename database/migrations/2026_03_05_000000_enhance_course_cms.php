<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Enhance Courses and Lessons
        Schema::table('courses', function (Blueprint $blueprint) {
            $blueprint->string('duration')->nullable();
        });

        Schema::table('course_lessons', function (Blueprint $blueprint) {
            $blueprint->string('duration')->nullable();
            $blueprint->boolean('is_pdf_lesson')->default(false);
        });

        // Quiz Infrastructure
        Schema::create('course_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('course_modules')->onDelete('cascade');
            $table->string('title');
            $table->integer('pass_percentage')->default(80);
            $table->timestamps();
        });

        Schema::create('course_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('course_quizzes')->onDelete('cascade');
            $table->text('question');
            $table->string('type')->default('multiple_choice'); // Changed from enum to string for flexibility
            $table->timestamps();
        });

        Schema::create('course_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('course_questions')->onDelete('cascade');
            $table->text('answer');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('course_quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('course_quizzes')->onDelete('cascade');
            $table->integer('score');
            $table->boolean('is_passed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_quiz_attempts');
        Schema::dropIfExists('course_answers');
        Schema::dropIfExists('course_questions');
        Schema::dropIfExists('course_quizzes');
        
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->dropColumn(['duration', 'is_pdf_lesson']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};
