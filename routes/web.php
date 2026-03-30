<?php
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProfileController;
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
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // --- Bổ sung 3 dòng này cho Duy ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
// Nhóm Route dành riêng cho Admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Đổi thành view dashboard của bạn
    })->name('dashboard');
    
    // Đăng ký toàn bộ 7 route CRUD cho User Management
    Route::resource('users', UserController::class);
    
});