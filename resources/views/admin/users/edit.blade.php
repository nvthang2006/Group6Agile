@extends('layouts.admin')

@section('title', 'Sua Tai khoan - Tour Manager')
@section('page_heading', 'Tai khoan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tai khoan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chinh sua</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <h3 class="mb-4">Chinh sua tai khoan</h3>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Ten</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mat khau moi</label>
                    <input type="password" name="password" class="form-control" placeholder="De trong neu khong doi">
                    @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Vai tro</label>
                    <select name="role" class="form-select" required>
                        <option value="0" {{ old('role', (string) $user->role) == '0' ? 'selected' : '' }}>User</option>
                        <option value="1" {{ old('role', (string) $user->role) == '1' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cap nhat</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lai</a>
            </form>
        </div>
    </div>
@endsection
