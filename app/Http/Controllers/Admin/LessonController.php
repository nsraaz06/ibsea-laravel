<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseModule;
use App\Models\CourseLesson;

class LessonController extends Controller
{
    public function store(Request $request, CourseModule $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:youtube,vimeo,upload,embed',
            'video_url' => 'nullable|string',
            'duration' => 'nullable|string|max:50',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400', // 100MB max
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
        ]);

        $videoUrl = $request->video_url;

        // Handle File Upload for White-Label Hosting
        if ($request->video_type == 'upload' && $request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses/videos'), $filename);
            $videoUrl = 'uploads/courses/videos/' . $filename;
        }

        // Handle Attachment
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses/attachments'), $filename);
            $attachmentPath = 'uploads/courses/attachments/' . $filename;
        }

        $order = $module->lessons()->count();

        $module->lessons()->create([
            'title' => $request->title,
            'video_type' => $request->video_type,
            'video_url' => $videoUrl,
            'content' => $request->content,
            'attachment_path' => $attachmentPath,
            'duration' => $request->duration,
            'order' => $order,
            'is_preview' => $request->has('is_preview'),
            'is_pdf_lesson' => $request->has('is_pdf_lesson')
        ]);

        return redirect()->back()->with('success', 'Strategic lesson deployed to module.');
    }

    public function update(Request $request, CourseLesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:youtube,vimeo,upload,embed',
            'video_url' => 'nullable|string',
            'duration' => 'nullable|string|max:50',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400', // 100MB max
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
        ]);

        $videoUrl = $request->video_url;

        // Handle File Upload for White-Label Hosting
        if ($request->video_type == 'upload' && $request->hasFile('video_file')) {
            // Delete old video if exists
            if ($lesson->video_type == 'upload' && file_exists(public_path($lesson->video_url))) {
                @unlink(public_path($lesson->video_url));
            }
            
            $file = $request->file('video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses/videos'), $filename);
            $videoUrl = 'uploads/courses/videos/' . $filename;
        }

        // Handle Attachment
        $attachmentPath = $lesson->attachment_path;
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($attachmentPath && file_exists(public_path($attachmentPath))) {
                @unlink(public_path($attachmentPath));
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses/attachments'), $filename);
            $attachmentPath = 'uploads/courses/attachments/' . $filename;
        }

        $lesson->update([
            'title' => $request->title,
            'video_type' => $request->video_type,
            'video_url' => $videoUrl,
            'content' => $request->content,
            'attachment_path' => $attachmentPath,
            'duration' => $request->duration,
            'is_preview' => $request->has('is_preview'),
            'is_pdf_lesson' => $request->has('is_pdf_lesson')
        ]);

        return redirect()->back()->with('success', 'Lesson strategy refined successfully.');
    }

    public function destroy(CourseLesson $lesson)
    {
        $lesson->delete();
        return redirect()->back()->with('success', 'Lesson archived.');
    }
}
