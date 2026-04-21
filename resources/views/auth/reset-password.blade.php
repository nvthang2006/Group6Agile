<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dat lai mat khau</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 p-6">
<div class="mx-auto mt-20 max-w-md rounded-2xl bg-white p-8 shadow">
    <h1 class="text-2xl font-bold text-gray-900">Dat lai mat khau</h1>

    <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div>
            <label class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', request('email')) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold text-gray-700">Mat khau moi</label>
            <input type="password" name="password" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold text-gray-700">Xac nhan mat khau</label>
            <input type="password" name="password_confirmation" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
        </div>

        <button class="w-full rounded-xl bg-blue-600 px-4 py-2.5 font-semibold text-white hover:bg-blue-700">Cap nhat mat khau</button>
    </form>
</div>
</body>
</html>
