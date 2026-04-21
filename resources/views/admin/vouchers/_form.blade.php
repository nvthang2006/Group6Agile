@php $v = $voucher ?? null; @endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Mã Voucher <span class="text-danger">*</span></label>
        <input type="text" name="code" class="form-control text-uppercase" placeholder="VD: GIAM50K, SUMMER2026"
               value="{{ old('code', $v?->code) }}" required style="letter-spacing: 2px; font-weight: bold;">
    </div>
    <div class="col-md-6">
        <label class="form-label">Tên voucher <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" placeholder="VD: Giảm 50K mùa hè"
               value="{{ old('name', $v?->name) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="2" placeholder="Mô tả ngắn về voucher...">{{ old('description', $v?->description) }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
        <select name="type" class="form-select" required id="voucherType">
            <option value="fixed" {{ old('type', $v?->type) === 'fixed' ? 'selected' : '' }}>Giảm cố định (VNĐ)</option>
            <option value="percent" {{ old('type', $v?->type) === 'percent' ? 'selected' : '' }}>Giảm theo %</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Giá trị <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="number" name="value" class="form-control" min="1" placeholder="50000"
                   value="{{ old('value', $v?->value) }}" required>
            <span class="input-group-text" id="valueSuffix">đ</span>
        </div>
    </div>
    <div class="col-md-4" id="maxDiscountWrap" style="{{ old('type', $v?->type) !== 'percent' ? 'display:none' : '' }}">
        <label class="form-label">Giảm tối đa</label>
        <div class="input-group">
            <input type="number" name="max_discount" class="form-control" min="0" placeholder="100000"
                   value="{{ old('max_discount', $v?->max_discount) }}">
            <span class="input-group-text">đ</span>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Đơn tối thiểu</label>
        <div class="input-group">
            <input type="number" name="min_order" class="form-control" min="0" placeholder="0"
                   value="{{ old('min_order', $v?->min_order ?? 0) }}">
            <span class="input-group-text">đ</span>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Số lượt dùng tối đa</label>
        <input type="number" name="max_uses" class="form-control" min="1" placeholder="Không giới hạn"
               value="{{ old('max_uses', $v?->max_uses) }}">
    </div>
    <div class="col-md-4">
        <div class="form-check form-switch mt-4 pt-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                   {{ old('is_active', $v?->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="isActive">Kích hoạt</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Ngày bắt đầu</label>
        <input type="date" name="starts_at" class="form-control"
               value="{{ old('starts_at', $v?->starts_at?->format('Y-m-d')) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Ngày hết hạn</label>
        <input type="date" name="expires_at" class="form-control"
               value="{{ old('expires_at', $v?->expires_at?->format('Y-m-d')) }}">
    </div>
</div>

<script>
    document.getElementById('voucherType')?.addEventListener('change', function() {
        const isPercent = this.value === 'percent';
        document.getElementById('maxDiscountWrap').style.display = isPercent ? '' : 'none';
        document.getElementById('valueSuffix').textContent = isPercent ? '%' : 'đ';
    });
</script>
