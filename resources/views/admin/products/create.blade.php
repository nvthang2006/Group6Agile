<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], input[type="file"], select, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; background-color: #28a745; text-decoration: none; }
        .btn-secondary { background-color: #6c757d; }
        .text-danger { color: #dc3545; font-size: 0.875em; }
    </style>
</head>
<body>
    <h1>Thêm Sản Phẩm Mới</h1>
    
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Tên Sản Phẩm (Tour) *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="category_id">Danh Mục Liên Kết *</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Chọn Danh Mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="price">Giá Mặc Định *</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0">
            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="sale_price">Giá Khuyến Mãi</label>
            <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" min="0">
            @error('sale_price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="image">Ảnh Sản Phẩm (Không bắt buộc)</label>
            <input type="file" name="image" id="image" accept="image/*">
            @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
            @error('description')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">Lưu Sản Phẩm</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</body>
</html>
