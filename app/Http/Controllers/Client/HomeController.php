<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ với dữ liệu Danh mục, Tour mới và Bài viết mới.
     */
    public function index()
    {
        $categories = Category::all();
        // Lấy 6 tour mới nhất
        $products = Product::with('category')->latest('created_at')->take(6)->get();
        // Lấy 3 bài viết mới nhất
        $posts = Post::with('user')->latest('created_at')->take(3)->get();

        return view('client.home', compact('categories', 'products', 'posts'));
    }
}
