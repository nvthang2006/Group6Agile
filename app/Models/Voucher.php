<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'max_discount',
        'min_order',
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at'  => 'date',
        'expires_at' => 'date',
        'is_active'  => 'boolean',
    ];

    // ─────────────────────────────────────────────
    //  Relationships
    // ─────────────────────────────────────────────

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ─────────────────────────────────────────────
    //  Business Logic
    // ─────────────────────────────────────────────

    /**
     * Kiểm tra voucher có hợp lệ để sử dụng không.
     */
    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        
        // Sử dụng startOfDay để cho phép dùng ngay trong ngày thiết lập
        if ($this->starts_at && now()->lt($this->starts_at->startOfDay())) return false;
        if ($this->expires_at && now()->gt($this->expires_at->endOfDay())) return false;

        return true;
    }

    /**
     * Kiểm tra đơn hàng đạt giá trị tối thiểu.
     */
    public function meetsMinOrder(float $orderTotal): bool
    {
        return $orderTotal >= $this->min_order;
    }

    /**
     * Tính số tiền được giảm cho 1 đơn hàng.
     */
    public function calculateDiscount(float $orderTotal): int
    {
        if ($this->type === 'fixed') {
            return min($this->value, (int) $orderTotal);
        }

        // percent
        $discount = (int) ($orderTotal * $this->value / 100);

        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return min($discount, (int) $orderTotal);
    }

    /**
     * Tăng biến đếm đã sử dụng.
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    /**
     * Label hiển thị mô tả giảm giá.
     */
    public function discountLabel(): string
    {
        if ($this->type === 'fixed') {
            return 'Giảm ' . number_format($this->value, 0, ',', '.') . 'đ';
        }

        $label = 'Giảm ' . $this->value . '%';
        if ($this->max_discount) {
            $label .= ' (tối đa ' . number_format($this->max_discount, 0, ',', '.') . 'đ)';
        }
        return $label;
    }

    /**
     * Label trạng thái.
     */
    public function statusLabel(): string
    {
        if (!$this->is_active) return 'Đã tắt';
        if ($this->max_uses && $this->used_count >= $this->max_uses) return 'Đã hết lượt';
        if ($this->expires_at && now()->gt($this->expires_at->endOfDay())) return 'Đã hết hạn';
        if ($this->starts_at && now()->lt($this->starts_at)) return 'Chưa bắt đầu';
        return 'Đang hoạt động';
    }
}
