<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function getAllProducts($search = null)
    {
        $query = Product::with('category');
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        return $query->latest('created_at')->get();
    }

    public function getTrashedProducts()
    {
        return Product::onlyTrashed()->with('category')->latest('deleted_at')->get();
    }

    public function createProduct(array $data, ?UploadedFile $image = null)
    {
        if ($image) {
            $data['image'] = $image->store('products', 'public');
        }

        return Product::create($data);
    }

    public function getProductById($id, $withTrashed = false)
    {
        return $withTrashed 
            ? Product::withTrashed()->findOrFail($id) 
            : Product::findOrFail($id);
    }

    public function updateProduct($id, array $data, ?UploadedFile $image = null)
    {
        $product = $this->getProductById($id);

        if ($image) {
            // Xóa ảnh cũ nếu có
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $image->store('products', 'public');
        }

        $product->update($data);
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = $this->getProductById($id);
        return $product->delete();
    }

    public function restoreProduct($id)
    {
        $product = $this->getProductById($id, true);
        return $product->restore();
    }

    public function forceDeleteProduct($id)
    {
        $product = $this->getProductById($id, true);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        return $product->forceDelete();
    }
}
