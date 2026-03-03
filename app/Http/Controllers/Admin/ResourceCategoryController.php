<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResourceCategoryController extends Controller
{
    /**
     * Display a listing of the resource categories.
     */
    public function index()
    {
        $categories = ResourceCategory::withCount('resources')->get();
        return view('admin.resource_categories.index', compact('categories'), ['title' => 'Sector Intelligence Management']);
    }

    /**
     * Show the form for creating a new resource category.
     */
    public function create()
    {
        return view('admin.resource_categories.create', ['title' => 'Define New Strategic Sector']);
    }

    /**
     * Store a newly created resource category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:resource_categories,name',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        ResourceCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'auto_stories',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.resource-categories.index')->with('success', 'Strategic sector defined successfully.');
    }

    /**
     * Show the form for editing the specified resource category.
     */
    public function edit(ResourceCategory $resource_category)
    {
        return view('admin.resource_categories.edit', compact('resource_category'), ['title' => 'Refine Sector Intelligence']);
    }

    /**
     * Update the specified resource category in storage.
     */
    public function update(Request $request, ResourceCategory $resource_category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:resource_categories,name,' . $resource_category->id,
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $resource_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'auto_stories',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.resource-categories.index')->with('success', 'Strategic sector updated successfully.');
    }

    /**
     * Remove the specified resource category from storage.
     */
    public function destroy(ResourceCategory $resource_category)
    {
        // Check if there are resources in this category
        if ($resource_category->resources()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete sector: Existing dossiers are mapped to this intelligence branch.');
        }

        $resource_category->delete();

        return redirect()->route('admin.resource-categories.index')->with('success', 'Strategic sector archived successfully.');
    }
}
