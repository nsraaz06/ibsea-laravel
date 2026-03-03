<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Event;
use App\Services\MediaOptimizerService;

class GalleryController extends Controller
{
    protected $optimizer;

    public function __construct(MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }
    public function index(Request $request)
    {
        $galleryQuery = Gallery::select('title', 'category', 'event_id')
            ->selectRaw('MIN(id) as id')
            ->selectRaw('MIN(image_path) as image_path')
            ->selectRaw('COUNT(*) as image_count')
            ->groupBy('title', 'category', 'event_id');

        if ($request->has('category')) {
            $galleryQuery->where('category', $request->category);
        }

        $galleries = $galleryQuery->with('event')
            ->orderBy('title', 'asc')
            ->paginate(12);

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the contents of a specific gallery folder.
     */
    public function show($id)
    {
        // Decode to handle + or %20 from URL
        $id = urldecode($id);

        // If ID is numeric, just go to edit
        if (is_numeric($id)) {
            return redirect()->route('admin.gallery.edit', $id);
        }

        // If it's a title (string), find the first image with this title
        $gallery = Gallery::where('title', $id)->first();
        
        if (!$gallery) {
            abort(404);
        }

        return redirect()->route('admin.gallery.edit', $gallery->id);
    }

    public function create()
    {
        $events = Event::latest()->get();
        return view('admin.gallery.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'required|string|max:255',
            'event_id' => 'nullable|exists:events,id',
            'category' => 'required|string'
        ]);

        $uploadedCount = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->optimizer->optimizeImage($image, 'uploads/gallery');

                Gallery::create([
                    'title' => $request->title,
                    'image_path' => $imagePath,
                    'event_id' => $request->event_id,
                    'category' => $request->category
                ]);
                $uploadedCount++;
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', $uploadedCount . ' media items archived in "' . $request->title . '" successfully.');
    }

    public function edit($id)
    {
        $current = Gallery::findOrFail($id);
        $title = $current->title;
        $category = $current->category;
        
        $images = Gallery::where('title', $title)
            ->where('category', $category)
            ->get();
            
        $events = Event::latest()->get();
        
        return view('admin.gallery.edit', compact('current', 'images', 'title', 'category', 'events'));
    }

    public function update(Request $request, $id)
    {
        $current = Gallery::findOrFail($id);
        $oldTitle = $current->title;
        $oldCategory = $current->category;

        $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'required|string|max:255',
            'event_id' => 'nullable|exists:events,id',
            'category' => 'required|string'
        ]);

        // 1. Update existing records (Title/Category/Event change)
        Gallery::where('title', $oldTitle)
            ->where('category', $oldCategory)
            ->update([
                'title' => $request->title,
                'category' => $request->category,
                'event_id' => $request->event_id
            ]);

        // 2. Add new images if uploaded
        $uploadedCount = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->optimizer->optimizeImage($image, 'uploads/gallery');

                Gallery::create([
                    'title' => $request->title,
                    'image_path' => $imagePath,
                    'event_id' => $request->event_id,
                    'category' => $request->category
                ]);
                $uploadedCount++;
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Asset folder updated successfully. ' . ($uploadedCount > 0 ? "Added $uploadedCount new images." : ""));
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $title = $gallery->title;
        $category = $gallery->category;

        $items = Gallery::where('title', $title)->where('category', $category)->get();

        foreach ($items as $item) {
            if (file_exists(public_path($item->image_path))) {
                @unlink(public_path($item->image_path));
            }
            $item->delete();
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Asset folder "' . $title . '" and its contents erased.');
    }

    /**
     * Remove individual image from a folder.
     */
    public function removeImage($id)
    {
        $image = Gallery::findOrFail($id);
        $title = $image->title;
        
        if (file_exists(public_path($image->image_path))) {
            @unlink(public_path($image->image_path));
        }
        $image->delete();

        // Check if there are any images left with this title
        $remaining = Gallery::where('title', $title)->first();
        if (!$remaining) {
            return redirect()->route('admin.gallery.index')->with('success', 'Individual image removed. Folder was empty and also removed.');
        }

        return back()->with('success', 'Individual mission asset removed from folder.');
    }
}
