<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Bài Viết</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; background-color: #007bff; text-decoration: none; }
        .btn-secondary { background-color: #6c757d; }
        .text-danger { color: #dc3545; font-size: 0.875em; }
        img { display: block; margin-top: 5px; max-width: 250px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Cập nhật Bài Viết</h1>
    
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Tiêu đề bài viết *</label>
            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required>
            @error('title')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="image">Thay đổi Ảnh minh họa</label>
            <input type="file" name="image" id="image" accept="image/*">
            @if($post->image)
                <img src="{{ Storage::url($post->image) }}" alt="Current Post Image">
                <small>Ảnh hiện tại</small>
            @endif
            @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="content">Nội dung chi tiết *</label>
            <textarea name="content" id="content" rows="8" required>{{ old('content', $post->content) }}</textarea>
            @error('content')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">Lưu Lại</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Hủy bỏ</a>
    </form>
</body>
</html>
