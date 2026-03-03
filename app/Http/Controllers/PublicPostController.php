<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    /**
     * Display a listing of the news posts.
     */
    public function index(Request $request)
    {
        $category = $request->query('category', 'All');
        
        $query = Post::where('status', 'Published');

        if ($category !== 'All') {
            $query->where('category', $category);
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);

        $categories = ['All', 'News', 'Blog', 'Press Release', 'Vyapar Badhao'];

        return view('news.index', [
            'title' => 'Mission Updates & News | IBSEA',
            'posts' => $posts,
            'category' => $category,
            'categories' => $categories
        ]);
    }

    /**
     * Display the specified news post.
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();

        // Fetch related posts
        $related = Post::where('category', $post['category'])
            ->where('id', '!=', $post['id'])
            ->where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('news.show', [
            'title' => $post->title . ' | IBSEA News',
            'post' => $post,
            'related' => $related
        ]);
    }
}
