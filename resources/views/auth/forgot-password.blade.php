<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quen mat khau</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 p-6">
<div class="mx-auto mt-20 max-w-md rounded-2xl bg-white p-8 shadow">
    <h1 class="text-2xl font-bold text-gray-900">Quen mat khau</h1>
    <p class="mt-2 text-sm text-gray-600">Nhap email de nhan link dat lai mat khau.</p>

    @if (session('status'))
        <div class="mt-4 rounded-lg bg-green-50 px-3 py-2 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="mt-6 space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <button class="w-full rounded-xl bg-blue-600 px-4 py-2.5 font-semibold text-white hover:bg-blue-700">Gui link dat lai</button>
    </form>
</div>
</body>
</html>
