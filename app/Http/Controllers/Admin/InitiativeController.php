<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Initiative;
use App\Services\MediaOptimizerService;
use Illuminate\Support\Str;

class InitiativeController extends Controller
{
    protected $optimizer;

    public function __construct(MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }

    public function index()
    {
        $initiatives = Initiative::latest()->paginate(20);
        return view('admin.initiatives.index', compact('initiatives'));
    }

    public function create()
    {
        return view('admin.initiatives.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:initiatives,slug',
            'custom_url' => 'nullable|string|max:1000',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10240',
            'youtube_link' => 'nullable|string|max:500',
            'icon' => 'nullable|string',
            'organizer_name' => 'nullable|string|max:255',
            'organizer_role' => 'nullable|string|max:255',
            'organizer_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'organizer_email' => 'nullable|email|max:255',
            'organizer_linkedin' => 'nullable|url|max:255',
        ]);

        $data = $request->except(['banner', 'logo', 'pdf', 'organizer_image']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('banner')) {
            $data['banner_path'] = $this->optimizer->optimizeImage($request->banner, 'uploads/initiatives/banners');
        }

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $this->optimizer->optimizeImage($request->logo, 'uploads/initiatives/logos');
        }

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $this->optimizer->optimizePdf($request->pdf, 'uploads/initiatives/pdfs');
        }

        if ($request->hasFile('organizer_image')) {
            $data['organizer_image_path'] = $this->optimizer->optimizeImage($request->organizer_image, 'uploads/initiatives/organizers');
        }

        Initiative::create($data);

        return redirect()->route('admin.initiatives.index')->with('success', 'Strategic initiative launched successfully.');
    }

    public function edit($id)
    {
        $initiative = Initiative::findOrFail($id);
        return view('admin.initiatives.edit', compact('initiative'));
    }

    public function update(Request $request, $id)
    {
        $initiative = Initiative::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:initiatives,slug,' . $id,
            'custom_url' => 'nullable|string|max:1000',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10240',
            'youtube_link' => 'nullable|string|max:500',
            'icon' => 'nullable|string',
            'organizer_name' => 'nullable|string|max:255',
            'organizer_role' => 'nullable|string|max:255',
            'organizer_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'organizer_email' => 'nullable|email|max:255',
            'organizer_linkedin' => 'nullable|url|max:255',
        ]);

        $data = $request->except(['banner', 'logo', 'pdf', 'organizer_image']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('banner')) {
            if ($initiative->banner_path && file_exists(public_path($initiative->banner_path))) {
                @unlink(public_path($initiative->banner_path));
            }
            $data['banner_path'] = $this->optimizer->optimizeImage($request->banner, 'uploads/initiatives/banners');
        }

        if ($request->hasFile('logo')) {
            if ($initiative->logo_path && file_exists(public_path($initiative->logo_path))) {
                @unlink(public_path($initiative->logo_path));
            }
            $data['logo_path'] = $this->optimizer->optimizeImage($request->logo, 'uploads/initiatives/logos');
        }

        if ($request->hasFile('pdf')) {
            if ($initiative->pdf_path && file_exists(public_path($initiative->pdf_path))) {
                @unlink(public_path($initiative->pdf_path));
            }
            $data['pdf_path'] = $this->optimizer->optimizePdf($request->pdf, 'uploads/initiatives/pdfs');
        }

        if ($request->hasFile('organizer_image')) {
            if ($initiative->organizer_image_path && file_exists(public_path($initiative->organizer_image_path))) {
                @unlink(public_path($initiative->organizer_image_path));
            }
            $data['organizer_image_path'] = $this->optimizer->optimizeImage($request->organizer_image, 'uploads/initiatives/organizers');
        }

        $initiative->update($data);

        return redirect()->route('admin.initiatives.index')->with('success', 'Initiative updated successfully.');
    }

    public function show($idOrSlug)
    {
        $initiative = Initiative::where('id', $idOrSlug)
            ->orWhere('slug', $idOrSlug)
            ->firstOrFail();
            
        return redirect()->route('public.initiatives.show', $initiative->slug);
    }

    public function destroy($id)
    {
        $initiative = Initiative::findOrFail($id);

        // Delete files
        foreach (['banner_path', 'pdf_path', 'organizer_image_path'] as $field) {
            if ($initiative->$field && file_exists(public_path($initiative->$field))) {
                @unlink(public_path($initiative->$field));
            }
        }

        $initiative->delete();

        return redirect()->route('admin.initiatives.index')->with('success', 'Initiative archived successfully.');
    }
}
