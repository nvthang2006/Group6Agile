<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $posts = Post::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('client.posts.index', compact('posts', 'search'));
    }

    /**
     * Display the specified resource for public.
     */
    public function show($slug)
    {
        $post = Post::where('slug', '=', $slug)->firstOrFail();
        
        // Lấy các bài viết mới nhất khác
        $recentPosts = Post::where('id', '!=', $post->id)
            ->latest('created_at')
            ->take(4)
            ->get();
            
        return view('client.posts.show', compact('post', 'recentPosts'));
    }
}
