<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
