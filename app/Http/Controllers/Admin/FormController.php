<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    // All valid field types
    const FIELD_TYPES = [
        'text','email','password','number','tel','url','search','hidden',
        'date','datetime-local','time','month','week',
        'select','select_multiple','radio','checkbox_group','toggle',
        'textarea','wysiwyg',
        'file','image','file_multiple',
    ];

    public function index(Request $request)
    {
        $query = Form::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $forms = $query->withCount('submissions')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.forms.index', ['forms' => $forms, 'title' => 'Form Intelligence | IBSEA Admin']);
    }

    public function create()
    {
        $templates = EmailTemplate::orderBy('name')->get();
        return view('admin.forms.create', [
            'title' => 'Design New Form | IBSEA Admin',
            'templates' => $templates
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'fields'         => 'required|array|min:1',
            'fields.*.name'  => 'required|string',
            'fields.*.type'  => 'required|in:' . implode(',', self::FIELD_TYPES),
            'fields.*.label' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
        ]);

        $slug = Str::slug($request->title);
        if (Form::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $settings = $request->input('settings', []);
        if ($request->hasFile('featured_image')) {
            $settings['featured_image'] = $request->file('featured_image')->store('form-banners', 'public');
        }

        Form::create([
            'title'       => $request->title,
            'description' => $request->description,
            'slug'        => $slug,
            'fields'      => $request->fields,
            'settings'    => $settings,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.forms.index')->with('success', 'Form protocol initialized successfully.');
    }

    public function edit(Form $form)
    {
        $templates = EmailTemplate::orderBy('name')->get();
        return view('admin.forms.edit', [
            'form' => $form, 
            'title' => 'Refine Form | ' . $form->title,
            'templates' => $templates
        ]);
    }

    public function update(Request $request, Form $form)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'fields'         => 'required|array|min:1',
            'fields.*.name'  => 'required|string',
            'fields.*.type'  => 'required|in:' . implode(',', self::FIELD_TYPES),
            'fields.*.label' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
        ]);

        // Preserve existing settings, then overlay new ones and new image
        $settings = array_merge($form->settings ?? [], $request->input('settings', []));
        if ($request->hasFile('featured_image')) {
            $settings['featured_image'] = $request->file('featured_image')->store('form-banners', 'public');
        }

        $form->update([
            'title'       => $request->title,
            'description' => $request->description,
            'fields'      => $request->fields,
            'settings'    => $settings,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.forms.index')->with('success', 'Form intelligence updated.');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('admin.forms.index')->with('success', 'Form data archived.');
    }
}
