<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends AdminBaseController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $categories = $this->categoryService->getAllCategories($search);
        return view('admin.categories.index', compact('categories', 'search'));
    }

    /**
     * Danh sách đã xóa mềm (Thùng rác)
     */
    public function trash()
    {
        $categories = $this->categoryService->getTrashedCategories();
        return view('admin.categories.trash', compact('categories'));
    }

    /**
     * Khôi phục danh mục
     */
    public function restore($id)
    {
        $this->categoryService->restoreCategory($id);
        return redirect()->route('categories.trash')->with('success', 'Khôi phục danh mục thành công!');
    }

    /**
     * Xóa vĩnh viễn
     */
    public function forceDelete($id)
    {
        $this->categoryService->forceDeleteCategory($id);
        return redirect()->route('categories.trash')->with('success', 'Đã xóa vĩnh viễn danh mục!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->createCategory($request->validated());
        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $this->categoryService->updateCategory($id, $request->validated());
        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->deleteCategory($id);
        return redirect()->route('categories.index')->with('success', 'Đã xóa danh mục thành công!');
    }
}
