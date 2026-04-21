@extends('layouts.admin')

@section('title', 'Lịch khởi hành - Tour Manager')
@section('page_heading', 'Lịch khởi hành')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Tours</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Lịch khởi hành</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Quản lý lịch khởi hành — {{ $product->name }}</h4>
                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-1"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Quay lại
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Form thêm lịch mới --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Thêm lịch khởi hành mới
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.departures.store', $product->id) }}" method="POST" class="row g-3 align-items-end">
                        @csrf
                        <div class="col-md-3">
                            <label class="form-label">Ngày khởi hành</label>
                            <input type="date" name="departure_date" class="form-control" required min="{{ date('Y-m-d') }}" value="{{ old('departure_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Giờ khởi hành</label>
                            <input type="time" name="departure_time" class="form-control" required value="{{ old('departure_time') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sức chứa</label>
                            <input type="number" name="capacity" class="form-control" min="1" required placeholder="VD: 30" value="{{ old('capacity') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Giá (VNĐ)</label>
                            <input type="number" name="price" class="form-control" min="0" step="1000" required placeholder="VD: 500000" value="{{ old('price') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select" required>
                                <option value="open" {{ old('status') === 'closed' ? '' : 'selected' }}>Mở bán</option>
                                <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Đóng</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Thêm lịch khởi hành
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Bảng danh sách lịch khởi hành --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Giờ</th>
                            <th>Giá</th>
                            <th>Sức chứa</th>
                            <th>Đã đặt</th>
                            <th>Còn trống</th>
                            <th>Trạng thái</th>
                            <th width="280">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departures as $departure)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($departure->departure_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($departure->departure_time)->format('H:i') }}</td>
                                <td>{{ number_format($departure->price, 0, ',', '.') }} VNĐ</td>
                                <td class="text-center">{{ $departure->capacity }}</td>
                                <td class="text-center">
                                    <span class="badge badge-light-primary">{{ $departure->booked_seats }}</span>
                                </td>
                                <td class="text-center">
                                    @php $available = max(0, $departure->capacity - $departure->booked_seats); @endphp
                                    <span class="badge {{ $available > 0 ? 'badge-light-success' : 'badge-light-danger' }}">{{ $available }}</span>
                                </td>
                                <td>
                                    @if($departure->status === 'open')
                                        <span class="badge badge-light-success">Mở bán</span>
                                    @elseif($departure->status === 'closed')
                                        <span class="badge badge-light-warning">Đóng</span>
                                    @else
                                        <span class="badge badge-light-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.products.departures.update', [$product->id, $departure->id]) }}" method="POST" class="d-flex gap-2 mb-2 align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="date" name="departure_date" class="form-control form-control-sm" value="{{ $departure->departure_date->format('Y-m-d') }}">
                                        <input type="time" name="departure_time" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($departure->departure_time)->format('H:i') }}">
                                        <input type="number" name="capacity" class="form-control form-control-sm" min="1" value="{{ $departure->capacity }}" style="width:80px">
                                        <input type="number" name="price" class="form-control form-control-sm" min="0" step="1000" value="{{ (int) $departure->price }}" style="width:100px">
                                        <select name="status" class="form-select form-select-sm" style="width:100px">
                                            <option value="open" @selected($departure->status === 'open')>Mở bán</option>
                                            <option value="closed" @selected($departure->status === 'closed')>Đóng</option>
                                            <option value="cancelled" @selected($departure->status === 'cancelled')>Đã hủy</option>
                                        </select>
                                        <button class="btn btn-sm btn-warning" type="submit" title="Lưu thay đổi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.departures.destroy', [$product->id, $departure->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch khởi hành này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa lịch khởi hành">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar d-block mx-auto mb-2 text-muted"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    Chưa có lịch khởi hành nào. Hãy thêm lịch mới ở form phía trên.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
