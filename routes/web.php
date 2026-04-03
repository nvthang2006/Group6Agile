<?php
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PostController as ClientPostController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/welcome', fn () => view('welcome'))->name('welcome');
Route::get('/dashboard', function () {
    return auth()->user()?->role == 1
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/products/{slug}', [ClientProductController::class, 'show'])->name('products.detail');
Route::get('/posts/{slug}', [ClientPostController::class, 'show'])->name('posts.detail');
Route::get('/media/{path}', function (string $path) {
    abort_unless(Storage::disk('public')->exists($path), 404);

    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('media.file');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/bookings/{product}', [ClientBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/history', [ClientBookingController::class, 'history'])->name('bookings.history');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
});
