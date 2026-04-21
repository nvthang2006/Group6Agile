@php($isEdit = isset($product))

<form action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="row g-4">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="col-lg-8">
        <div class="widget-content-area" style="padding: 30px !important;">
            <div class="row g-4">
                <div class="col-12 mb-2">
                    <h5 class="fw-bold text-dark mb-0">Tóm tắt Sản phẩm</h5>
                    <p class="text-muted small">Cung cấp các thông tin cơ bản của sản phẩm / tour</p>
                </div>
                
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
                    <label for="price" class="form-label fw-semibold">Giá gốc (VNĐ)</label>
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
                    <label for="sale_price" class="form-label fw-semibold">Giá khuyến mãi (VNĐ)</label>
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
    </div>

    <div class="col-lg-4">
        <div class="widget-content-area h-100" style="padding: 30px !important;">
            <h5 class="fw-bold mb-1">Ảnh & Trạng Thái</h5>
            <p class="text-muted small mb-4">Ảnh là tùy chọn. Tên sẽ tự động sinh slug hợp lệ.</p>

            <div class="mb-4">
                <label for="image" class="form-label fw-semibold">Ảnh sản phẩm</label>
                <div class="position-relative">
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                </div>
                @error('image')
                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                @enderror

                @if($isEdit && !empty($product->image_url))
                    <div class="mt-4 p-2 border rounded-4 bg-light text-center">
                        <img src="{{ $product->image_url }}" alt="Ảnh sản phẩm hiện tại" class="img-fluid rounded-3" style="max-height: 200px; object-fit: cover;">
                        <div class="badge bg-secondary mt-3 mb-1 px-3 py-2">Ảnh hiện tại</div>
                    </div>
                @endif
            </div>

            <div class="mb-5 p-3 rounded-3" style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                <div class="text-muted small text-uppercase fw-bold mb-1">Đường dẫn SEO (Slug)</div>
                <div class="fw-semibold text-primary text-truncate" style="font-size: 14px;">{{ old('slug', $isEdit ? $product->slug : 'Tự động tạo (auto-generated)') }}</div>
            </div>

            <div class="d-grid gap-3 mt-auto">
                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo sản phẩm' }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">Hủy bỏ</a>
            </div>
        </div>
    </div>
</form>


@section('page_js')
{{-- Không sử dụng CKEditor cho mô tả ngắn. Mô tả tour chỉ cần textarea thuần. --}}
@endsection