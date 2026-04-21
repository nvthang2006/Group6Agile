<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getPaginated($perPage = 10, $search = null)
    {
        $query = User::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        return $query->orderBy('id', 'desc')->get(); // Changed to get() for DataTables support
    }

    public function getTrashed($perPage = 10)
    {
        return User::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);
    }

    public function getById($id, $withTrashed = false)
    {
        return $withTrashed 
            ? User::withTrashed()->findOrFail($id) 
            : User::findOrFail($id);
    }

    // Thêm mới tài khoản
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // Đã dùng Hashed cast trong Model
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

    // Xóa tài khoản
    public function delete(User $user)
    {
        return $user->delete();
    }

    public function restore($id)
    {
        $user = $this->getById($id, true);
        return $user->restore();
    }

    public function forceDelete($id)
    {
        $user = $this->getById($id, true);
        return $user->forceDelete();
    }
}