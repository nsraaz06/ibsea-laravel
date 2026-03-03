<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display submissions for a specific form.
     */
    public function index(Request $request, $formId = null)
    {
        $query = FormSubmission::query();

        if ($formId) {
            $query->where('form_id', $formId);
            $form = Form::findOrFail($formId);
        } else {
            $form = null;
        }

        $submissions = $query->with(['form', 'member'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        return view('admin.submissions.index', [
            'submissions' => $submissions,
            'form' => $form,
            'title' => ($form ? 'Submissions: ' . $form->title : 'Global Form Submissions') . ' | IBSEA Admin'
        ]);
    }

    /**
     * Display details of a specific submission.
     */
    public function show(FormSubmission $submission)
    {
        $submission->load(['form', 'member']);
        return view('admin.submissions.show', [
            'submission' => $submission,
            'title' => 'Submission Detail | IBSEA Admin'
        ]);
    }

    /**
     * Export submissions to CSV.
     */
    public function export(Request $request, $formId = null)
    {
        $query = FormSubmission::query();
        if ($formId) {
            $query->where('form_id', $formId);
            $form = Form::findOrFail($formId);
            $filename = Str::slug($form->title) . '_submissions_' . date('Y-m-d') . '.csv';
        } else {
            $form = null;
            $filename = 'global_submissions_' . date('Y-m-d') . '.csv';
        }

        $submissions = $query->with(['form', 'member'])->orderBy('created_at', 'desc')->get();

        if ($submissions->isEmpty()) {
            return back()->with('error', 'No submissions found to export.');
        }

        // Determine dynamic headers from submissions data
        $headers = ['Submission Date', 'Time', 'Agent/Member', 'Email', 'IP Address'];
        if (!$form) {
            array_splice($headers, 2, 0, ['Protocol/Form']);
        }

        $dataKeys = [];
        foreach ($submissions as $sub) {
            foreach ($sub->data as $key => $val) {
                if (!in_array($key, $dataKeys)) {
                    $dataKeys[] = $key;
                }
            }
        }
        
        // Add dynamic keys to headers
        foreach ($dataKeys as $key) {
            $headers[] = ucwords(str_replace(['_', '-'], ' ', $key));
        }

        $callback = function() use ($submissions, $headers, $dataKeys, $form) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($submissions as $submission) {
                $row = [
                    $submission->created_at->format('Y-m-d'),
                    $submission->created_at->format('H:i:s'),
                    $submission->member ? $submission->member->name : 'Guest',
                    $submission->member ? $submission->member->email : 'N/A',
                    $submission->ip_address,
                ];

                if (!$form) {
                    array_splice($row, 2, 0, [$submission->form->title]);
                }

                // Map data based on keys
                foreach ($dataKeys as $key) {
                    $val = $submission->data[$key] ?? '';
                    $row[] = is_array($val) ? json_encode($val) : $val;
                }

                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Remove a submission.
     */
    public function destroy(FormSubmission $submission)
    {
        $submission->delete();
        return back()->with('success', 'Submission record deleted.');
    }
}
