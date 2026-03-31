<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], input[type="file"], select, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; background-color: #007bff; text-decoration: none; }
        .btn-secondary { background-color: #6c757d; }
        .text-danger { color: #dc3545; font-size: 0.875em; }
        img { display: block; margin-top: 5px; max-width: 150px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Cập nhật Sản Phẩm: {{ $product->name }}</h1>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Tên Sản Phẩm (Tour) *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="category_id">Danh Mục Liên Kết *</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Chọn Danh Mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="price">Giá Cũ (Gốc) *</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0">
            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="sale_price">Giá Khuyến Mãi (Sale)</label>
            <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0">
            @error('sale_price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="image">Ảnh Sản Phẩm Mới (Chọn để thay thế)</label>
            <input type="file" name="image" id="image" accept="image/*">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="Current Image">
                <small>Ảnh hiện tại</small>
            @endif
            @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea name="description" id="description" rows="4">{{ old('description', $product->description) }}</textarea>
            @error('description')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">Lưu Lại</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy Bỏ</a>
    </form>
</body>
</html>
