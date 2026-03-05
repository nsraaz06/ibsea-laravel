<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseModule;

class ModuleController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate(['title' => 'required|string|max:255']);
        
        $order = $course->modules()->count();
        
        $course->modules()->create([
            'title' => $request->title,
            'order' => $order
        ]);

        return redirect()->back()->with('success', 'New module added to ' . $course->title);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:course_modules,id'
        ]);

        foreach ($request->ids as $index => $id) {
            CourseModule::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(CourseModule $module)
    {
        $module->delete();
        return redirect()->back()->with('success', 'Module and all its lessons archived.');
    }
}
