<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class PostService
{
    public function getAllPosts()
    {
        // Kèm user (tác giả)
        return Post::with('user')->latest('created_at')->get();
    }

    public function createPost(array $data, ?UploadedFile $image = null)
    {
        if ($image) {
            $data['image'] = $image->store('posts', 'public');
        }

        // Lấy User đầu tiên, nếu chưa có thì tạo mới một User ảo để test
        $user = \App\Models\User::first(['id']);
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Admin Temp',
                'email' => 'admin_' . time() . '@example.com',
                'password' => bcrypt('password123'),
            ]);
        }
        
        $data['user_id'] = $user->id;

        return Post::create($data);
    }

    public function getPostById($id)
    {
        return Post::findOrFail($id);
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
}
