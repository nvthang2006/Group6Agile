@extends('layouts.admin')

@section('title', 'Quản lý Tài khoản - Tour Manager')
@section('page_heading', 'Tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Quản lý người dùng</li>
@endsection

@section('page_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0">Danh sách Tài khoản</h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.trash') }}" class="btn btn-outline-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        Thùng rác
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Thêm mới
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mt-2 mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mt-2 mb-4">{{ session('error') }}</div>
            @endif

            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ và Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th class="no-content text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 1)
                                    <span class="badge badge-light-danger">Admin</span>
                                @else
                                    <span class="badge badge-light-primary">Khách hàng</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info" title="Xem chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa tài khoản">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Chưa có tài khoản nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page_js')
    <script src="{{ asset('cork/src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Hiển thị trang _PAGE_ / _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Tìm kiếm...",
               "sLengthMenu": "Hiển thị :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
@endsection
