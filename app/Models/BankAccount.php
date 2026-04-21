<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_name',
        'branch',
        'qr_code',
        'is_active',
        'is_primary',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'is_primary' => 'boolean',
    ];

    /**
     * Chỉ lấy tài khoản đang kích hoạt.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Lấy tài khoản chính (dùng hiển thị cho khách thanh toán).
     */
    public static function primary(): ?self
    {
        return static::where('is_primary', true)->where('is_active', true)->first();
    }

    /**
     * Đặt tài khoản này làm chính, hủy primary của các tài khoản khác.
     */
    public function makePrimary(): void
    {
        static::where('id', '!=', $this->id)->update(['is_primary' => false]);
        $this->update(['is_primary' => true]);
    }
}
