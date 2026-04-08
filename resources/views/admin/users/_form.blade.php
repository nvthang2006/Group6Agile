@php($isEdit = isset($user))

<form action="{{ $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" class="row g-4">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label fw-semibold">Họ và tên</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                    value="{{ old('name', $isEdit ? $user->name : '') }}"
                    placeholder="Nhập tên người dùng"
                    required
                >
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    value="{{ old('email', $isEdit ? $user->email : '') }}"
                    placeholder="email@example.com"
                    required
                >
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label fw-semibold">
                    {{ $isEdit ? 'Mật khẩu mới' : 'Mật khẩu' }}
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    placeholder="{{ $isEdit ? 'Để trống nếu không đổi' : 'Nhập mật khẩu tối thiểu 8 ký tự' }}"
                    {{ $isEdit ? '' : 'required' }}
                >
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="role" class="form-label fw-semibold">Vai trò</label>
                <select
                    name="role"
                    id="role"
                    class="form-select form-select-lg @error('role') is-invalid @enderror"
                    required
                >
                    <option value="0" {{ old('role', $isEdit ? (string) $user->role : '') == '0' ? 'selected' : '' }}>User</option>
                    <option value="1" {{ old('role', $isEdit ? (string) $user->role : '') == '1' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="p-4 rounded-4 border bg-light h-100">
            <h5 class="fw-bold mb-2">Lưu ý</h5>
            <p class="text-muted small mb-4">
                Mật khẩu chỉ bắt buộc khi tạo mới. Khi chỉnh sửa, bạn có thể để trống nếu không muốn thay đổi.
            </p>

            <div class="mb-4">
                <div class="text-muted small">Trạng thái</div>
                <div class="fw-semibold">{{ $isEdit ? 'Đang cập nhật' : 'Tạo mới' }}</div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    {{ $isEdit ? 'Cập nhật tài khoản' : 'Lưu tài khoản' }}
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</form>

