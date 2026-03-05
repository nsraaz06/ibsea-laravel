<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseEnrollment;
use App\Models\CourseLessonCompletion;
use App\Models\DesignTemplate;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CourseController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    private function getBase64Image($path)
    {
        if (!$path) return null;
        
        // Handle full URLs
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            try {
                $client = new \GuzzleHttp\Client(['verify' => false, 'timeout' => 5]);
                $response = $client->get($path);
                $type = $response->getHeaderLine('Content-Type');
                if (!$type) $type = 'image/' . (pathinfo($path, PATHINFO_EXTENSION) ?: 'png');
                return 'data:' . $type . ';base64,' . base64_encode($response->getBody()->getContents());
            } catch (\Exception $e) {
                return null;
            }
        }

        $paths = [
            storage_path('app/public/' . $path),
            public_path('storage/' . $path),
            public_path($path),
            storage_path($path)
        ];

        $fullPath = null;
        foreach ($paths as $p) {
            if (file_exists($p) && !is_dir($p)) {
                $fullPath = $p;
                break;
            }
        }

        if (!$fullPath) return null;

        $type = 'image/' . pathinfo($fullPath, PATHINFO_EXTENSION);
        $data = file_get_contents($fullPath);
        return 'data:' . $type . ';base64,' . base64_encode($data);
    }
    public function index()
    {
        $courses = Course::where('is_published', true)->withCount('modules')->get();
        $enrolledCourseIds = CourseEnrollment::where('member_id', Auth::guard('member')->id())->pluck('course_id')->toArray();
        
        return view('member.courses.index', compact('courses', 'enrolledCourseIds'));
    }

    public function show(Course $course)
    {
        $course->load('modules.lessons');
        $memberId = Auth::guard('member')->id();
        
        $enrollment = CourseEnrollment::where('member_id', $memberId)
                                    ->where('course_id', $course->id)
                                    ->first();

        // Auto-enroll if free
        if (!$enrollment && $course->access_type == 'free') {
            $enrollment = CourseEnrollment::create([
                'member_id' => $memberId,
                'course_id' => $course->id,
                'payment_status' => 'free'
            ]);
        }

        // Calculate Progress
        $progress = 0;
        $completedLessonsCount = 0;
        $totalLessonsCount = $course->modules->sum(function($m) { return $m->lessons->count(); });
        
        if ($enrollment) {
            $completedLessonsCount = CourseLessonCompletion::where('member_id', $memberId)
                                                          ->where('course_id', $course->id)
                                                          ->count();
            if ($totalLessonsCount > 0) {
                $progress = round(($completedLessonsCount / $totalLessonsCount) * 100);
            }
        }

        return view('member.courses.show', compact('course', 'enrollment', 'progress', 'completedLessonsCount', 'totalLessonsCount'));
    }

    public function watch(Course $course, CourseLesson $lesson)
    {
        $course->load(['modules.lessons' => function($q) {
            $q->orderBy('order');
        }]);

        $memberId = Auth::guard('member')->id();
        $enrollment = CourseEnrollment::where('member_id', $memberId)
                                    ->where('course_id', $course->id)
                                    ->first();

        // Security: Must be enrolled OR it must be a preview lesson
        if (!$enrollment && !$lesson->is_preview && $course->access_type != 'free') {
            return redirect()->route('user.courses.show', $course->slug)
                             ->with('error', 'Strategic access required for this lesson.');
        }

        // Check if current lesson is completed
        $isCompleted = CourseLessonCompletion::where('member_id', $memberId)
                                            ->where('lesson_id', $lesson->id)
                                            ->exists();

        return view('member.courses.player', compact('course', 'lesson', 'enrollment', 'isCompleted'));
    }

    public function completeLesson(Course $course, CourseLesson $lesson)
    {
        $memberId = Auth::guard('member')->id();
        
        CourseLessonCompletion::firstOrCreate([
            'member_id' => $memberId,
            'course_id' => $course->id,
            'lesson_id' => $lesson->id
        ]);

        // Find next lesson
        $allLessons = $course->modules->pluck('lessons')->flatten();
        $currentIndex = $allLessons->search(function($item) use ($lesson) {
            return $item->id == $lesson->id;
        });

        $nextLesson = $allLessons->get($currentIndex + 1);

        if ($nextLesson) {
            return redirect()->route('user.courses.watch', [$course->slug, $nextLesson->id])
                             ->with('success', 'Progress tracked. Moving to next strategic phase.');
        }

        return redirect()->route('user.courses.show', $course->slug)
                         ->with('success', 'Final lesson completed. Curriculum finalized!');
    }

    public function downloadCertificate(Course $course)
    {
        $member = Auth::guard('member')->user();
        $totalLessons = $course->modules->sum(function($m) { return $m->lessons->count(); });
        $completedCount = CourseLessonCompletion::where('member_id', $member->id)
                                               ->where('course_id', $course->id)
                                               ->count();

        if ($completedCount < $totalLessons || $totalLessons == 0) {
            return redirect()->back()->with('error', 'Complete all lessons to unlock your institutional certificate.');
        }

        $template = null;
        if ($course->certificate_template_id) {
            $template = DesignTemplate::find($course->certificate_template_id);
        }

        if (!$template) {
            $template = DesignTemplate::where('type', 'certificate')->latest()->first();
        }

        if ($template) {
            $certificateNo = $this->documentService->getUniqueDocumentNo($member, 'certificate');

            $data = [
                'user' => $member,
                'event' => (object)['title' => $course->title, 'name' => $course->title],
                'background' => $this->getBase64Image($template->background_path),
                'elements' => $template->layout_json['objects'] ?? [],
                'width' => $template->width,
                'height' => $template->height,
                'date' => now()->format('d M, Y'),
                'serial_id' => 'IBSEA-' . strtoupper(substr(md5($member->id . $course->id), 0, 8)),
                'certificate_no' => $certificateNo,
                'membership_type' => $member->membershipPlan->title ?? 'Standard Member',
                'start_date' => $member->membership_start ? \Carbon\Carbon::parse($member->membership_start)->format('d M, Y') : 'N/A',
                'end_date' => $member->membership_end ? \Carbon\Carbon::parse($member->membership_end)->format('d M, Y') : 'N/A',
                'profile_image' => $this->getBase64Image($member->profile_image),
            ];

            $pdf = Pdf::loadView('pdf.dynamic', $data);
            $orientation = $template->width > $template->height ? 'landscape' : 'portrait';
            $pdf->setPaper([0, 0, $template->width, $template->height], $orientation);
            
            return $pdf->download('IBSEA_Certificate_' . str_replace(' ', '_', $course->title) . '.pdf');
        }

        // Fallback to simpler static view if no template found at all
        $data = [
            'member_name' => $member->name,
            'course_title' => $course->title,
            'date' => date('d M, Y'),
            'verification_id' => 'IBSEA-' . strtoupper(substr(md5($member->id . $course->id), 0, 8))
        ];

        $pdf = Pdf::loadView('member.courses.certificate', $data)
                  ->setPaper('a4', 'landscape');
                  
        return $pdf->download('IBSEA_Certificate_' . str_replace(' ', '_', $course->title) . '.pdf');
    public function quiz(Course $course, \App\Models\CourseQuiz $quiz)
    {
        $quiz->load('questions.answers');
        return view('member.courses.quiz', compact('course', 'quiz'));
    }

    public function submitQuiz(Request $request, Course $course, \App\Models\CourseQuiz $quiz)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $score = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $selectedAnswerId = $request->answers[$question->id] ?? null;
            $correctAnswer = $question->answers()->where('is_correct', true)->first();

            if ($selectedAnswerId && $correctAnswer && $selectedAnswerId == $correctAnswer->id) {
                $score++;
            }
        }

        $percentage = ($totalQuestions > 0) ? ($score / $totalQuestions) * 100 : 0;
        $isPassed = $percentage >= $quiz->pass_percentage;

        \App\Models\CourseQuizAttempt::create([
            'user_id' => Auth::guard('member')->id(),
            'quiz_id' => $quiz->id,
            'score' => $percentage,
            'is_passed' => $isPassed
        ]);

        if ($isPassed) {
            return redirect()->route('user.courses.show', $course->slug)
                             ->with('success', "Strategic proficiency verified! Score: {$percentage}%. Module finalized.");
        }

        return redirect()->back()->with('error', "Assessment threshold not met. Score: {$percentage}%. Re-evaluate strategy and try again.");
    }
}
