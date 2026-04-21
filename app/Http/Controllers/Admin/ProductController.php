<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends AdminBaseController
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $products = $this->productService->getAllProducts($search);
        return view('admin.products.index', compact('products', 'search'));
    }

    /**
     * Danh sách đã xóa mềm (Thùng rác)
     */
    public function trash()
    {
        $products = $this->productService->getTrashedProducts();
        return view('admin.products.trash', compact('products'));
    }

    /**
     * Khôi phục sản phẩm
     */
    public function restore($id)
    {
        $this->productService->restoreProduct($id);
        return redirect()->route('admin.products.trash')->with('success', 'Khôi phục sản phẩm thành công!');
    }

    /**
     * Xóa vĩnh viễn
     */
    public function forceDelete($id)
    {
        $this->productService->forceDeleteProduct($id);
        return redirect()->route('admin.products.trash')->with('success', 'Đã xóa vĩnh viễn sản phẩm!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $this->productService->createProduct($request->validated(), $request->file('image'));
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->updateProduct($product->id, $request->validated(), $request->file('image'));
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product->id);
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm thành công!');
    }
}
