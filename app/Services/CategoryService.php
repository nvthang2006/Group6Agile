<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories($search = null)
    {
        $query = Category::query();
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        return $query->latest('created_at')->get();
    }

    public function getTrashedCategories()
    {
        return Category::onlyTrashed()->latest('deleted_at')->get();
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function getCategoryById($id, $withTrashed = false)
    {
        return $withTrashed 
            ? Category::withTrashed()->findOrFail($id) 
            : Category::findOrFail($id);
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

    public function restoreCategory($id)
    {
        $category = $this->getCategoryById($id, true);
        return $category->restore();
    }

    public function forceDeleteCategory($id)
    {
        $category = $this->getCategoryById($id, true);
        return $category->forceDelete();
    }
}
