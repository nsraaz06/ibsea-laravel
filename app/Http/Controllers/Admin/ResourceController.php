<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberResource;
use App\Models\ResourceCategory;
use Illuminate\Support\Facades\Storage;
use App\Services\MediaOptimizerService;

class ResourceController extends Controller
{
    protected $optimizer;

    public function __construct(MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }
    public function index()
    {
        $resources = MemberResource::with('resourceCategory')->latest()->paginate(10);
        return view('admin.resources.index', compact('resources'));
    }

    public function show($id)
    {
        return redirect()->route('admin.resources.index');
    }

    public function create()
    {
        $categories = ResourceCategory::all();
        return view('admin.resources.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:resource_categories,id',
            'description' => 'nullable|string',
            'file' => 'required|mimes:pdf,doc,docx,zip|max:102400',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $extension = $request->file->getClientOriginalExtension();
            
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
                $filePath = $this->optimizer->optimizeImage($request->file, 'uploads/resources');
            } else {
                $filePath = $this->optimizer->optimizePdf($request->file, 'uploads/resources');
            }

            $category = ResourceCategory::find($request->category_id);

            $resource = MemberResource::create([
                'title' => $request->title,
                'slug' => \Illuminate\Support\Str::slug($request->title),
                'category_id' => $request->category_id,
                'category' => $category->name,
                'description' => $request->description,
                'file_path' => $filePath,
                'is_active' => $request->has('is_active'),
                'show_on_home' => $request->has('show_on_home'),
            ]);

            // Handle Cover Image
            if ($request->hasFile('cover_image')) {
                $resource->cover_image = $this->optimizer->optimizeImage($request->cover_image, 'uploads/resources/covers');
            } else {
                // Auto-generate cover
                $resource->cover_image = $this->optimizer->generateDossierCover($resource, $category);
            }
            $resource->save();
        }

        return redirect()->route('admin.resources.index')->with('success', 'Strategic resource deployed successfully.');
    }

    public function edit($id)
    {
        $resource = MemberResource::findOrFail($id);
        $categories = ResourceCategory::all();
        return view('admin.resources.edit', compact('resource', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $resource = MemberResource::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:resource_categories,id',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx,zip|max:102400',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $category = ResourceCategory::find($request->category_id);
        $data = [
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'category_id' => $request->category_id,
            'category' => $category->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if (file_exists(public_path($resource->file_path))) {
                @unlink(public_path($resource->file_path));
            }

            $extension = $request->file->getClientOriginalExtension();
            
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
                $data['file_path'] = $this->optimizer->optimizeImage($request->file, 'uploads/resources');
            } else {
                $data['file_path'] = $this->optimizer->optimizePdf($request->file, 'uploads/resources');
            }

            // If a new file is uploaded and no new manual cover is provided, we should ideally regenerate the cover
            // unless the user specifically uploaded a new manual cover.
        }

        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($resource->cover_image && file_exists(public_path($resource->cover_image))) {
                @unlink(public_path($resource->cover_image));
            }
            $data['cover_image'] = $this->optimizer->optimizeImage($request->cover_image, 'uploads/resources/covers');
        } elseif ($request->hasFile('file')) {
            // New file but no new cover -> regenerate
            if ($resource->cover_image && file_exists(public_path($resource->cover_image))) {
                @unlink(public_path($resource->cover_image));
            }
            // Temporarily update resource with new file path so generator has access to it
            $resource->file_path = $data['file_path'];
            $data['cover_image'] = $this->optimizer->generateDossierCover($resource, $category);
        }

        $data['show_on_home'] = $request->has('show_on_home');
        $resource->update($data);

        return redirect()->route('admin.resources.index')->with('success', 'Resource updated successfully.');
    }

    public function destroy($id)
    {
        $resource = MemberResource::findOrFail($id);
        
        if (file_exists(public_path($resource->file_path))) {
            @unlink(public_path($resource->file_path));
        }
        if ($resource->cover_image && file_exists(public_path($resource->cover_image))) {
            @unlink(public_path($resource->cover_image));
        }
        $resource->delete();
        return redirect()->route('admin.resources.index')->with('success', 'Resource deleted successfully.');
    }
}
