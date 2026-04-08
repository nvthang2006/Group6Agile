@php($isEdit = isset($category))

<form action="{{ $isEdit ? route('categories.update', $category->id) : route('categories.store') }}" method="POST" class="row g-4">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="col-lg-8">
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Tên danh mục</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control form-control-lg @error('name') is-invalid @enderror"
                value="{{ old('name', $isEdit ? $category->name : '') }}"
                placeholder="Ví dụ: Tour biển, Tour núi, Tour gia đình"
                required
            >
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-0">
            <label for="description" class="form-label fw-semibold">Mô tả</label>
            <textarea
                name="description"
                id="description"
                rows="6"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Mô tả ngắn gọn về nhóm sản phẩm này"
            >{{ old('description', $isEdit ? $category->description : '') }}</textarea>
            @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="p-4 rounded-4 border bg-light h-100">
            <h5 class="fw-bold mb-2">Thiết lập nhanh</h5>
            <p class="text-muted small mb-4">Slug sẽ được tự động sinh từ tên danh mục khi lưu.</p>

            <div class="mb-4">
                <div class="text-muted small">Slug</div>
                <div class="fw-semibold">
                    {{ old('slug', $isEdit ? $category->slug : 'Tự động tạo') }}
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    {{ $isEdit ? 'Cập nhật danh mục' : 'Lưu danh mục' }}
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</form>

