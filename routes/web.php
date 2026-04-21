<?php
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DepartureController as AdminDepartureController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PostController as ClientPostController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/welcome', fn () => view('welcome'))->name('welcome');
Route::get('/dashboard', function () {
    return auth()->user()?->role == 1
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/categories', [ClientCategoryController::class, 'index'])->name('client.categories.index');
Route::get('/products', [ClientProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ClientProductController::class, 'show'])->name('products.detail');
Route::get('/posts', [ClientPostController::class, 'index'])->name('posts.index');
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

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', function () {
        $credentials = request()->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($credentials);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::view('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
    Route::post('/reset-password', function () {
        $request = request();

        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $validated,
            function ($user) use ($validated) {
                $user->forceFill([
                    'password' => Hash::make($validated['password']),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/bookings/{product}', [ClientBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/history', [ClientBookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/{booking}', [ClientBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/customer-info', [ClientBookingController::class, 'updateCustomerInfo'])->name('bookings.update_info');
    Route::get('/bookings/{booking}/payment', [ClientBookingController::class, 'paymentPage'])->name('bookings.payment');
    Route::post('/bookings/{booking}/pay', [ClientBookingController::class, 'submitPayment'])->name('bookings.pay');
    Route::post('/bookings/{booking}/proof', [ClientBookingController::class, 'uploadProof'])->name('bookings.proof');
    Route::post('/bookings/{booking}/cancel', [ClientBookingController::class, 'cancel'])->name('bookings.cancel');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Client\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Client\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Voucher PDF
    Route::get('/vouchers', [\App\Http\Controllers\Client\VoucherController::class, 'index'])->name('vouchers.index');
    Route::get('/bookings/{booking}/voucher', [\App\Http\Controllers\Client\VoucherController::class, 'download'])->name('bookings.voucher');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Category trash and helper actions
    Route::get('/categories/trash', [AdminCategoryController::class, 'trash'])->name('categories.trash');
    Route::post('/categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{id}/force-delete', [AdminCategoryController::class, 'forceDelete'])->name('categories.force-delete');
    Route::resource('categories', AdminCategoryController::class);
    // Product trash and helper actions
    Route::get('/products/trash', [AdminProductController::class, 'trash'])->name('admin.products.trash');
    Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('admin.products.restore');
    Route::delete('/products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('admin.products.force-delete');
    Route::resource('products', AdminProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::get('/products/{product}/departures', [AdminDepartureController::class, 'index'])->name('admin.products.departures.index');
    Route::post('/products/{product}/departures', [AdminDepartureController::class, 'store'])->name('admin.products.departures.store');
    Route::put('/products/{product}/departures/{departure}', [AdminDepartureController::class, 'update'])->name('admin.products.departures.update');
    Route::delete('/products/{product}/departures/{departure}', [AdminDepartureController::class, 'destroy'])->name('admin.products.departures.destroy');
    // Post trash and helper actions
    Route::get('/posts/trash', [AdminPostController::class, 'trash'])->name('admin.posts.trash');
    Route::post('/posts/{id}/restore', [AdminPostController::class, 'restore'])->name('admin.posts.restore');
    Route::delete('/posts/{id}/force-delete', [AdminPostController::class, 'forceDelete'])->name('admin.posts.force-delete');
    Route::resource('posts', AdminPostController::class)->names([
        'index' => 'admin.posts.index',
        'create' => 'admin.posts.create',
        'store' => 'admin.posts.store',
        'show' => 'admin.posts.show',
        'edit' => 'admin.posts.edit',
        'update' => 'admin.posts.update',
        'destroy' => 'admin.posts.destroy',
    ]);
    // User management (resource routes)
    Route::get('/users/trash', [AdminUserController::class, 'trash'])->name('admin.users.trash');
    Route::post('/users/{id}/restore', [AdminUserController::class, 'restore'])->name('admin.users.restore');
    Route::delete('/users/{id}/force-delete', [AdminUserController::class, 'forceDelete'])->name('admin.users.force-delete');
    Route::resource('users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('admin.bookings.confirm');
    Route::post('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('admin.bookings.reject');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');

    // Quản lý tài khoản ngân hàng
    Route::get('/bank-accounts', [BankAccountController::class, 'index'])->name('admin.bank-accounts.index');
    Route::post('/bank-accounts', [BankAccountController::class, 'store'])->name('admin.bank-accounts.store');
    Route::put('/bank-accounts/{bankAccount}', [BankAccountController::class, 'update'])->name('admin.bank-accounts.update');
    Route::delete('/bank-accounts/{bankAccount}', [BankAccountController::class, 'destroy'])->name('admin.bank-accounts.destroy');
    Route::post('/bank-accounts/{bankAccount}/set-primary', [BankAccountController::class, 'setPrimary'])->name('admin.bank-accounts.set-primary');

    // Quản lý Voucher giảm giá
    Route::get('/vouchers', [\App\Http\Controllers\Admin\VoucherController::class, 'index'])->name('admin.vouchers.index');
    Route::get('/vouchers/create', [\App\Http\Controllers\Admin\VoucherController::class, 'create'])->name('admin.vouchers.create');
    Route::post('/vouchers', [\App\Http\Controllers\Admin\VoucherController::class, 'store'])->name('admin.vouchers.store');
    Route::get('/vouchers/{voucher}/edit', [\App\Http\Controllers\Admin\VoucherController::class, 'edit'])->name('admin.vouchers.edit');
    Route::put('/vouchers/{voucher}', [\App\Http\Controllers\Admin\VoucherController::class, 'update'])->name('admin.vouchers.update');
    Route::delete('/vouchers/{voucher}', [\App\Http\Controllers\Admin\VoucherController::class, 'destroy'])->name('admin.vouchers.destroy');
});

// API kiểm tra voucher (dùng cho AJAX trên trang payment)
Route::get('/api/voucher/check', function (\Illuminate\Http\Request $request) {
    $code = strtoupper(trim($request->query('code', '')));
    $total = floatval($request->query('total', 0));

    if (!$code) {
        return response()->json(['valid' => false, 'message' => 'Vui lòng nhập mã voucher.']);
    }

    $voucher = \App\Models\Voucher::where('code', $code)->first();

    if (!$voucher) {
        return response()->json(['valid' => false, 'message' => 'Mã voucher không tồn tại.']);
    }
    if (!$voucher->isValid()) {
        return response()->json(['valid' => false, 'message' => 'Voucher này ' . strtolower($voucher->statusLabel()) . '.']);
    }
    if (!$voucher->meetsMinOrder($total)) {
        return response()->json(['valid' => false, 'message' => 'Đơn tối thiểu ' . number_format($voucher->min_order, 0, ',', '.') . 'đ để dùng voucher này.']);
    }

    return response()->json([
        'valid'    => true,
        'name'     => $voucher->name,
        'label'    => $voucher->discountLabel(),
        'discount' => $voucher->calculateDiscount($total),
    ]);
})->name('api.voucher.check');

