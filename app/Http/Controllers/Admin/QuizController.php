<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseModule;
use App\Models\CourseQuiz;
use App\Models\CourseQuestion;
use App\Models\CourseAnswer;

class QuizController extends Controller
{
    public function store(Request $request, CourseModule $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pass_percentage' => 'required|integer|min:0|max:100',
        ]);

        $quiz = CourseQuiz::create([
            'module_id' => $module->id,
            'title' => $request->title,
            'pass_percentage' => $request->pass_percentage,
        ]);

        return redirect()->back()->with('success', 'Strategic Quiz established.');
    }

    public function update(Request $request, CourseQuiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pass_percentage' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update([
            'title' => $request->title,
            'pass_percentage' => $request->pass_percentage,
        ]);

        return redirect()->back()->with('success', 'Quiz strategy refined.');
    }

    public function destroy(CourseQuiz $quiz)
    {
        $quiz->delete();
        return redirect()->back()->with('success', 'Quiz archived.');
    }

    public function addQuestion(Request $request, CourseQuiz $quiz)
    {
        $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false',
            'answers' => 'required|array|min:1',
            'correct_index' => 'required|integer'
        ]);

        $question = $quiz->questions()->create([
            'question' => $request->question,
            'type' => $request->type
        ]);

        foreach ($request->answers as $index => $answerText) {
            $question->answers()->create([
                'answer' => $answerText,
                'is_correct' => ($index == $request->correct_index)
            ]);
        }

        return redirect()->back()->with('success', 'Question integrated into quiz.');
    }

    public function removeQuestion(CourseQuestion $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Question removed.');
    }
}
