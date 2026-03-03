<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberResource;
use App\Models\ResourceCategory;
use Illuminate\Support\Str;

class PublicResourceController extends Controller
{
    /**
     * Display the public resource archive with filtering.
     */
    public function index(Request $request)
    {
        $query = MemberResource::where('is_active', true)->with('resourceCategory');

        if ($request->filled('sector')) {
            $query->whereHas('resourceCategory', function($q) use ($request) {
                $q->where('slug', $request->sector);
            });
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $resources = $query->latest()->paginate(12);
        $categories = ResourceCategory::withCount('resources')->get();

        return view('resources.archive', compact('resources', 'categories'), ['title' => 'Intelligence Hub | IBSEA Global Resources']);
    }

    /**
     * Display resource in 3D Flipbook viewer.
     */
    public function show(MemberResource $resource)
    {
        // Ensure it's a PDF for viewer
        if (!Str::endsWith(strtolower($resource->file_path), '.pdf')) {
            return redirect(asset($resource->file_path));
        }

        return view('resources.viewer', compact('resource'), ['title' => $resource->title . ' | IBSEA Intelligence']);
    }

    /**
     * Securely stream PDF to browser.
     */
    public function stream(MemberResource $resource)
    {
        $path = public_path($resource->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            // Explicitly allow embedding
            'X-Frame-Options' => 'SAMEORIGIN', 
        ]);
    }
}
