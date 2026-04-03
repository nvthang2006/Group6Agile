@extends('layouts.admin')

@section('title', 'Quan ly Tai khoan - Tour Manager')
@section('page_heading', 'Tai khoan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tai khoan</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0">Danh sach tai khoan</h3>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Them moi</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ten</th>
                            <th>Email</th>
                            <th>Vai tro</th>
                            <th class="text-center">Thao tac</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Sua</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Ban co chac muon xoa tai khoan nay khong?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xoa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Khong co tai khoan nao.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
