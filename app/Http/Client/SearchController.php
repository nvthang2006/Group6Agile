<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    /**
     * Xử lý tìm kiếm sản phẩm và Lọc theo Danh mục
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        $categoryId = $request->input('category');

        $products = Product::query();

        // Tìm kiếm theo tên hoặc mô tả
        if ($query) {
            $products->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        // Lọc theo danh mục nếu có truyền id danh mục
        if ($categoryId) {
            $products->where('category_id', '=', $categoryId);
        }

        // Thực thi query với phân trang
        $results = $products->with('category')->latest('created_at')->paginate(12);
        
        // Cung cấp danh sách categories để load ra thanh bộ lọc form
        $categories = Category::all();

        return view('client.search_results', compact('results', 'query', 'categories', 'categoryId'));
    }
}
