<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use Illuminate\Http\Request;

class PublicInitiativeController extends Controller
{
    /**
     * Display a listing of active initiatives.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $initiatives = Initiative::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('initiatives.index', compact('initiatives'));
    }

    /**
     * Display the specified initiative.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $initiative = Initiative::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($initiative->custom_url) {
            return redirect($initiative->custom_url);
        }

        // Get other active initiatives for a "Explore More" section if needed
        $otherInitiatives = Initiative::where('is_active', true)
            ->where('id', '!=', $initiative->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('initiatives.show', compact('initiative', 'otherInitiatives'));
    }

    /**
     * Download the PDF for the initiative.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function download($slug)
    {
        $initiative = Initiative::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if (!$initiative->pdf_path || !file_exists(public_path($initiative->pdf_path))) {
            return back()->with('error', 'The PDF dossier for this initiative is currently unavailable.');
        }

        return response()->download(public_path($initiative->pdf_path));
    }

    /**
     * View the PDF dossier in a native browser viewer.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function view($slug)
    {
        $initiative = Initiative::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if (!$initiative->pdf_path || !file_exists(public_path($initiative->pdf_path))) {
            return back()->with('error', 'The PDF dossier for this initiative is currently unavailable.');
        }

        return view('initiatives.viewer', compact('initiative'));
    }
}
