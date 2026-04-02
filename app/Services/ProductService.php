<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function getAllProducts()
    {
        // Kèm theo danh mục (Eager Loading)
        return Product::with('category')->latest('created_at')->get();
    }

    public function createProduct(array $data, ?UploadedFile $image = null)
    {
        if ($image) {
            $data['image'] = $image->store('products', 'public');
        }

        return Product::create($data);
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function updateProduct($id, array $data, ?UploadedFile $image = null)
    {
        $product = $this->getProductById($id);

        if ($image) {
            // Xóa ảnh cũ nếu có (Cơ chế tùy chọn)
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
        
        // Không xóa ảnh vật lý nếu dùng SoftDelete, nếu muốn xóa có thể kích hoạt ở đây.
        
        return $product->delete();
    }
}
