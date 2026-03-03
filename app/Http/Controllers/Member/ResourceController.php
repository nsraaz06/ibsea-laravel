<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberResource;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberResource::where('is_active', true);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        $resources = $query->latest()->paginate(12);
        $categories = MemberResource::where('is_active', true)->distinct()->pluck('category');

        return view('user.resources.index', compact('resources', 'categories'));
    }

    public function download(MemberResource $resource)
    {
        if (!$resource->is_active) {
            abort(404);
        }

        $path = public_path($resource->file_path);
        if (file_exists($path)) {
            return response()->download($path);
        }

        return redirect()->back()->with('error', 'File not found on server.');
    }
}
