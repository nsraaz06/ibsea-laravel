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
        $galleryQuery = Gallery::query();

        if ($request->has('category')) {
            $galleryQuery->where('category', $request->category);
        }

        $galleries = $galleryQuery->with('event')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.gallery.index', compact('galleries'));
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
            'title' => 'nullable|string|max:255',
            'event_id' => 'nullable|exists:events,id',
            'category' => 'required|string'
        ]);

        $uploadedCount = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->optimizer->optimizeImage($image, 'uploads/gallery');

                Gallery::create([
                    'title' => $request->title ?: $image->getClientOriginalName(),
                    'image_path' => $imagePath,
                    'event_id' => $request->event_id,
                    'category' => $request->category
                ]);
                $uploadedCount++;
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', $uploadedCount . ' Media items uploaded to gallery successfully.');
    }

    public function edit(Gallery $gallery)
    {
        $events = Event::latest()->get();
        return view('admin.gallery.edit', compact('gallery', 'events'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'event_id' => 'nullable|exists:events,id',
            'category' => 'required|string'
        ]);

        $data = $request->only(['title', 'event_id', 'category']);

        if ($request->hasFile('image')) {
            if (file_exists(public_path($gallery->image_path))) {
                @unlink(public_path($gallery->image_path));
            }

            $data['image_path'] = $this->optimizer->optimizeImage($request->image, 'uploads/gallery');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        if (file_exists(public_path($gallery->image_path))) {
            @unlink(public_path($gallery->image_path));
        }
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
