<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Hiển thị danh sách
    public function index()
    {
        $users = $this->userService->getPaginated(10);
        return view('admin.users.index', compact('users'));
    }

    // Form thêm mới
    public function create()
    {
        return view('admin.users.create');
    }

    // Lưu thêm mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:0,1',
        ]);

        $this->userService->create($data);
        return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản thành công!');
    }

    // Form chỉnh sửa
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Lưu chỉnh sửa
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8', // Không bắt buộc nhập khi sửa
            'role' => 'required|in:0,1',
        ]);

        $this->userService->update($user, $data);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    // Xóa
    public function destroy(User $user)
    {
        // Chống Admin tự xóa chính mình
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Bạn không thể tự xóa chính mình!');
        }

        $this->userService->delete($user);
        return redirect()->route('admin.users.index')->with('success', 'Đã xóa tài khoản!');
    }
}