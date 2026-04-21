<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends AdminBaseController
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $posts = $this->postService->getAllPosts($search);
        return view('admin.posts.index', compact('posts', 'search'));
    }

    /**
     * Danh sách đã xóa mềm (Thùng rác)
     */
    public function trash()
    {
        $posts = $this->postService->getTrashedPosts();
        return view('admin.posts.trash', compact('posts'));
    }

    /**
     * Khôi phục bài viết
     */
    public function restore($id)
    {
        $this->postService->restorePost($id);
        return redirect()->route('admin.posts.trash')->with('success', 'Khôi phục bài viết thành công!');
    }

    /**
     * Xóa vĩnh viễn
     */
    public function forceDelete($id)
    {
        $this->postService->forceDeletePost($id);
        return redirect()->route('admin.posts.trash')->with('success', 'Đã xóa vĩnh viễn bài viết!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $this->postService->createPost($request->validated(), $request->file('image'));
        return redirect()->route('admin.posts.index')->with('success', 'Đăng bài viết thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->postService->updatePost($post->id, $request->validated(), $request->file('image'));
        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->postService->deletePost($post->id);
        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết!');
    }
}
