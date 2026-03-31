<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viết Bài Viết Mới</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; background-color: #28a745; text-decoration: none; }
        .btn-secondary { background-color: #6c757d; }
        .text-danger { color: #dc3545; font-size: 0.875em; }
    </style>
</head>
<body>
    <h1>Đăng Bài Viết (Tự động gán user hiện tại)</h1>
    
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Tiêu đề bài viết *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="image">Ảnh minh họa (Banner)</label>
            <input type="file" name="image" id="image" accept="image/*">
            @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="content">Nội dung chi tiết *</label>
            <textarea name="content" id="content" rows="8" required>{{ old('content') }}</textarea>
            @error('content')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">Lưu Bài Viết</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</body>
</html>
