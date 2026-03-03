<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignTemplateController extends Controller
{
    public function index()
    {
        $templates = DesignTemplate::orderBy('created_at', 'desc')->get();
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:certificate,id_card,ticket',
            'background' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['name', 'type']);
        
        if ($request->hasFile('background')) {
            $path = $request->file('background')->store('templates', 'public');
            $data['background_path'] = $path;
        }

        // Default layout for new templates
        $data['layout_json'] = [
            'elements' => []
        ];

        DesignTemplate::create($data);

        return redirect()->route('admin.design-templates.index')->with('success', 'Template created successfully.');
    }

    public function edit(DesignTemplate $designTemplate)
    {
        return view('admin.templates.edit', compact('designTemplate'));
    }

    public function update(Request $request, DesignTemplate $designTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:certificate,id_card,ticket',
            'background' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'layout_json' => 'nullable',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric'
        ]);

        $data = $request->only(['name', 'type', 'width', 'height']);

        if ($request->hasFile('background')) {
            if ($designTemplate->background_path) {
                Storage::disk('public')->delete($designTemplate->background_path);
            }
            $path = $request->file('background')->store('templates', 'public');
            $data['background_path'] = $path;
        }

        if ($request->has('layout_json')) {
            $layoutData = $request->layout_json;
            // If it's a string, decode it. If it's already an array, use it.
            $data['layout_json'] = is_string($layoutData) ? json_decode($layoutData, true) : $layoutData;
        }

        $designTemplate->update($data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Template updated.']);
        }

        return redirect()->route('admin.design-templates.builder', $designTemplate->id)->with('success', 'Template updated.');
    }

    public function destroy(DesignTemplate $designTemplate)
    {
        if ($designTemplate->background_path) {
            Storage::disk('public')->delete($designTemplate->background_path);
        }
        $designTemplate->delete();
        return back()->with('success', 'Template deleted.');
    }

    public function builder(DesignTemplate $designTemplate)
    {
        return view('admin.templates.builder', compact('designTemplate'));
    }
}
