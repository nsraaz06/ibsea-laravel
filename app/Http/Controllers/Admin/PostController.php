<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MediaOptimizerService;

class PostController extends Controller
{
    protected $optimizer;

    public function __construct(MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = \App\Models\Post::latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'category' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|string',
            'content' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['author_id'] = auth()->id() ?? 1;

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->optimizer->optimizeImage($request->featured_image, 'uploads/posts');
        }

        $data['show_on_slider'] = $request->has('show_on_slider');
        $data['published_at'] = $request->status === 'Published' ? now() : null;

        \App\Models\Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Dispatch broadcast successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = \App\Models\Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
            'category' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|string',
            'content' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                @unlink(public_path($post->featured_image));
            }

            $data['featured_image'] = $this->optimizer->optimizeImage($request->featured_image, 'uploads/posts');
        }

        $data['show_on_slider'] = $request->has('show_on_slider');
        
        if ($request->status === 'Published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Intelligence dispatch refined successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        
        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            @unlink(public_path($post->featured_image));
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Dispatch archived successfully.');
    }
}
