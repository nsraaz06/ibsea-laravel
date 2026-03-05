<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\DesignTemplate;
use App\Services\MediaOptimizerService;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    protected $optimizer;

    public function __construct(MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }

    public function index()
    {
        $courses = Course::withCount('modules')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $templates = DesignTemplate::where('type', 'certificate')->get();
        return view('admin.courses.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'price' => 'required|numeric|min:0',
            'access_type' => 'required|in:free,paid,membership',
            'category' => 'nullable|string',
            'certificate_template_id' => 'nullable|exists:design_templates,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->optimizer->optimizeImage($request->file('thumbnail'), 'uploads/courses/thumbs');
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'New course deployed to the Learning Hub.');
    }

    public function edit(Course $course)
    {
        $templates = DesignTemplate::where('type', 'certificate')->get();
        return view('admin.courses.edit', compact('course', 'templates'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'price' => 'required|numeric|min:0',
            'access_type' => 'required|in:free,paid,membership',
            'certificate_template_id' => 'nullable|exists:design_templates,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->optimizer->optimizeImage($request->file('thumbnail'), 'uploads/courses/thumbs');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course curriculum refined and updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course archived from the platform.');
    }
}
