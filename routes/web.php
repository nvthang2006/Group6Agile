<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Trang chủ khách hàng
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route Đăng nhập / Đăng ký (Chỉ khách chưa login mới vào được)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route cần đăng nhập (Dùng chung cho cả khách và Admin)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route dành riêng cho Admin (Phải có role = 1)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Chào mừng sếp đã vào Dashboard!";
    })->name('admin.dashboard');
    
    // Sau này Sprint 2 CRUD Categories, Products bạn sẽ nhét vào đây
});
