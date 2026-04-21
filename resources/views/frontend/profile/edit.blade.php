@extends('layouts.app')

@section('title', 'Thong tin tai khoan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-900">Thong tin ca nhan</h1>
        <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Ho ten</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <button class="rounded-xl bg-blue-600 px-5 py-2.5 font-semibold text-white hover:bg-blue-700">Cap nhat thong tin</button>
        </form>
    </section>

    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-gray-900">Doi mat khau</h2>
        <form action="{{ route('profile.password') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Mat khau hien tai</label>
                <input type="password" name="current_password" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
                @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Mat khau moi</label>
                <input type="password" name="password" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Xac nhan mat khau moi</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <button class="rounded-xl bg-gray-900 px-5 py-2.5 font-semibold text-white hover:bg-black">Cap nhat mat khau</button>
        </form>
    </section>
</div>
@endsection
