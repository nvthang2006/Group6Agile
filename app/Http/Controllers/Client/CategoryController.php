<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $categories = Category::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->withCount('products')
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('client.categories.index', compact('categories', 'search'));
    }
}
