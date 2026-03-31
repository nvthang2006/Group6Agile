<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    // Lấy danh sách phân trang
    public function getPaginated($perPage = 10)
    {
        return User::orderBy('id', 'desc')->paginate($perPage);
    }

    // Thêm mới tài khoản
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
           'password' => $data['password'], // Mã hóa pass
            'role' => $data['role'] ?? 0,
        ]);
    }

    // Cập nhật tài khoản
    public function update(User $user, array $data)
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? 0,
        ];

        // Chỉ cập nhật mật khẩu nếu người dùng nhập pass mới
        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        return $user->update($updateData);
    }

    // Xóa tài khoản (Có thể làm xóa mềm sau nếu muốn)
    public function delete(User $user)
    {
        return $user->delete();
    }
}