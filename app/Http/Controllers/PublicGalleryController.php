<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class PublicGalleryController extends Controller
{
    /**
     * Show the public gallery page.
     */
    public function index(Request $request)
    {
        $query = Gallery::select('title', 'category')
            ->selectRaw('MIN(image_path) as cover_image')
            ->selectRaw('COUNT(*) as image_count')
            ->whereNotIn('category', [
                'Strategic Partner - MOU', 
                'Strategic Partner - National', 
                'Strategic Partner - International'
            ])
            ->groupBy('title', 'category')
            ->orderBy('title', 'asc');

        // Filter by category if requested
        if ($request->filled('category')) {
            if ($request->category === 'Others') {
                $query->whereIn('category', ['Global Alliance', 'Press & Media']);
            } else {
                $query->where('category', $request->category);
            }
        }

        $folders = $query->paginate(12);
        
        $title = 'Media Room | Institutional Gallery';

        return view('gallery', compact('folders', 'title'));
    }

    /**
     * Show images within a specific folder.
     */
    public function show($title)
    {
        // Decode title to handle + or %20 as spaces
        $title = urldecode($title);
        $images = Gallery::where('title', $title)->get();
        
        if ($images->isEmpty()) {
            abort(404);
        }

        $folderTitle = $title;
        $title = $folderTitle . ' | IBSEA Gallery';

        return view('gallery_show', compact('images', 'folderTitle', 'title'));
    }
}
