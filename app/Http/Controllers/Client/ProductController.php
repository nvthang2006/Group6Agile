<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_range')) {
            if ($request->price_range == 'under_2m') {
                $query->where('price', '<', 2000000);
            } elseif ($request->price_range == '2m_5m') {
                $query->whereBetween('price', [2000000, 5000000]);
            } elseif ($request->price_range == 'over_5m') {
                $query->where('price', '>', 5000000);
            }
        }

        // Sắp xếp
        if ($request->filled('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->latest('created_at');
            }
        } else {
            $query->latest('created_at');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Category::all();

        return view('client.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified resource for public.
     */
    public function show($slug)
    {
        $cutoffHours = \App\Models\Departure::bookingCutoffHours();

        $product = Product::with(['departures' => function ($query) {
            $query->where('status', 'open')
                ->whereDate('departure_date', '>=', now()->toDateString())
                ->orderBy('departure_date')
                ->orderBy('departure_time');
        }])->where('slug', $slug)->firstOrFail();

        $product->setRelation(
            'departures',
            $product->departures
                ->filter(fn ($departure) => $departure->isBookable($cutoffHours))
                ->values()
        );
        
        // Lấy các tour liên quan cùng danh mục
        $relatedProducts = Product::where('category_id', '=', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest('created_at')
            ->take(4)
            ->get();
            
        return view('client.products.show', compact('product', 'relatedProducts'));
    }
}
