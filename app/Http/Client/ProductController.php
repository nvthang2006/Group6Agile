<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified resource for public.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        // Lấy các tour liên quan cùng danh mục
        $relatedProducts = Product::where('category_id', '=', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest('created_at')
            ->take(4)
            ->get();
            
        return view('client.products.show', compact('product', 'relatedProducts'));
    }
}
