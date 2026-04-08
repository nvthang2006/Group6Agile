@php($isEdit = isset($product))

<form action="{{ $isEdit ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data" class="row g-4">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-12">
                <label for="name" class="form-label fw-semibold">Tên sản phẩm / tour</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                    value="{{ old('name', $isEdit ? $product->name : '') }}"
                    placeholder="Ví dụ: Tour Đà Nẵng 3 ngày 2 đêm"
                    required
                >
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="category_id" class="form-label fw-semibold">Danh mục</label>
                <select
                    name="category_id"
                    id="category_id"
                    class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                    required
                >
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $isEdit ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label fw-semibold">Giá gốc</label>
                <input
                    type="number"
                    name="price"
                    id="price"
                    class="form-control form-control-lg @error('price') is-invalid @enderror"
                    value="{{ old('price', $isEdit ? $product->price : '') }}"
                    min="0"
                    step="1"
                    required
                >
                @error('price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="sale_price" class="form-label fw-semibold">Giá khuyến mãi</label>
                <input
                    type="number"
                    name="sale_price"
                    id="sale_price"
                    class="form-control form-control-lg @error('sale_price') is-invalid @enderror"
                    value="{{ old('sale_price', $isEdit ? $product->sale_price : '') }}"
                    min="0"
                    step="1"
                    placeholder="Bỏ trống nếu không áp dụng"
                >
                @error('sale_price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label fw-semibold">Mô tả</label>
                <textarea
                    name="description"
                    id="description"
                    rows="7"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Mô tả ngắn về sản phẩm / tour"
            >{{ old('description', $isEdit ? $product->description : '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="p-4 rounded-4 border bg-light h-100">
            <h5 class="fw-bold mb-2">Ảnh & thông tin</h5>
            <p class="text-muted small mb-4">Ảnh là tùy chọn. Tên sẽ tự sinh slug ở backend.</p>

            <div class="mb-3">
                <label for="image" class="form-label fw-semibold">Ảnh sản phẩm</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                @if($isEdit && !empty($product->image_url))
                    <div class="mt-3">
                        <img src="{{ $product->image_url }}" alt="Ảnh sản phẩm hiện tại" class="img-fluid rounded-3 border">
                        <div class="text-muted small mt-2">Ảnh hiện tại</div>
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <div class="text-muted small">Slug</div>
                <div class="fw-semibold">{{ old('slug', $isEdit ? $product->slug : 'Tự động tạo') }}</div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    {{ $isEdit ? 'Cập nhật sản phẩm' : 'Lưu sản phẩm' }}
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</form>

