@php($isEdit = isset($post))

<form action="{{ $isEdit ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="row g-4">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="col-lg-8">
        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">Tiêu đề bài viết</label>
            <input
                type="text"
                name="title"
                id="title"
                class="form-control form-control-lg @error('title') is-invalid @enderror"
                value="{{ old('title', $isEdit ? $post->title : '') }}"
                placeholder="Ví dụ: 10 điểm đến đẹp nhất mùa hè"
                required
            >
            @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="post_content" class="form-label fw-semibold">Nội dung chi tiết</label>
            <textarea
                name="content"
                id="post_content"
                rows="10"
                class="form-control @error('content') is-invalid @enderror"
                placeholder="Viết nội dung bài viết ở đây..."
                required
            >{{ old('content', $isEdit ? $post->content : '') }}</textarea>
            @error('content')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="p-4 rounded-4 border bg-light h-100">
            <h5 class="fw-bold mb-2">Ảnh & SEO</h5>
            <p class="text-muted small mb-4">Ảnh đại diện là tùy chọn, slug được sinh tự động từ tiêu đề.</p>

            <div class="mb-3">
                <label for="image" class="form-label fw-semibold">Ảnh minh họa</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                @if($isEdit && !empty($post->image_url))
                    <div class="mt-3">
                        <img src="{{ $post->image_url }}" alt="Ảnh bài viết hiện tại" class="img-fluid rounded-3 border">
                        <div class="text-muted small mt-2">Ảnh hiện tại</div>
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <div class="text-muted small">Slug</div>
                <div class="fw-semibold">{{ old('slug', $isEdit ? $post->slug : 'Tự động tạo') }}</div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    {{ $isEdit ? 'Cập nhật bài viết' : 'Lưu bài viết' }}
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</form>

