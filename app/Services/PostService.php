<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class PostService
{
    public function getAllPosts($search = null)
    {
        $query = Post::with('user');
        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
        }
        return $query->latest('created_at')->get();
    }

    public function getTrashedPosts()
    {
        return Post::onlyTrashed()->with('user')->latest('deleted_at')->get();
    }

    public function createPost(array $data, ?UploadedFile $image = null)
    {
        if ($image) {
            $data['image'] = $image->store('posts', 'public');
        }

        $data['user_id'] = auth()->id() ?? User::where('role', 1)->first()->id;

        return Post::create($data);
    }

    public function getPostById($id, $withTrashed = false)
    {
        return $withTrashed 
            ? Post::withTrashed()->findOrFail($id) 
            : Post::findOrFail($id);
    }

    public function updatePost($id, array $data, ?UploadedFile $image = null)
    {
        $post = $this->getPostById($id);

        if ($image) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $image->store('posts', 'public');
        }

        $post->update($data);
        return $post;
    }

    public function deletePost($id)
    {
        $post = $this->getPostById($id);
        return $post->delete();
    }

    public function restorePost($id)
    {
        $post = $this->getPostById($id, true);
        return $post->restore();
    }

    public function forceDeletePost($id)
    {
        $post = $this->getPostById($id, true);
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        return $post->forceDelete();
    }
}
