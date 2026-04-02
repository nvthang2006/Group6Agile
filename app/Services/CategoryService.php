<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Lấy toàn bộ danh sách danh mục và sắp xếp mới nhất
     */
    public function getAllCategories()
    {
        // Tuân thủ quy tắc Laravel chuyên nghiệp: Dùng Eloquent Model thay vì DB facade, 
        // phục vụ dễ dàng tích hợp SoftDeletes và relationship
        return Category::latest('created_at')->get();
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    public function updateCategory($id, array $data)
    {
        $category = $this->getCategoryById($id);
        $category->update($data);
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = $this->getCategoryById($id);
        return $category->delete(); // Sử dụng Soft Deletes
    }
}
