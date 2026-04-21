<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'departure_id',
        'quantity',
        'unit_price',
        'total_price',
        'booking_date',
        'note',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_age',
        'status',
        'transaction_code',
        'voucher_code',
        'voucher_id',
        'discount_amount',
        'payment_method',
        'payment_status',
        'payment_proof',
        'cancelled_reason',
        'confirmed_at',
        'paid_at',
    ];

    protected $casts = [
        'booking_date'  => 'date',
        'confirmed_at'  => 'datetime',
        'paid_at'       => 'datetime',
        'unit_price'    => 'float',
        'total_price'   => 'float',
    ];

    // ─────────────────────────────────────────────
    //  Relationships
    // ─────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function departure()
    {
        return $this->belongsTo(Departure::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /**
     * Tổng tiền sau giảm giá.
     */
    public function finalPrice(): float
    {
        return max(0, $this->total_price - ($this->discount_amount ?? 0));
    }

    // ─────────────────────────────────────────────
    //  Scopes
    // ─────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeWaitingVerify($query)
    {
        return $query->where('payment_status', 'waiting_verify');
    }

    // ─────────────────────────────────────────────
    //  Helper Methods
    // ─────────────────────────────────────────────

    /**
     * Kiểm tra đơn có thể hủy bởi khách hàng không.
     * Chỉ hủy được khi còn pending và chưa thanh toán.
     */
    public function isClientCancellable(): bool
    {
        return $this->status === 'pending' && $this->payment_status === 'unpaid';
    }

    /**
     * Kiểm tra đơn có thể thanh toán không.
     */
    public function isPayable(): bool
    {
        // Chỉ cho phép vào trang thanh toán khi chưa thanh toán.
        // Khi đã waiting_verify → chờ admin duyệt, không cho ghi đè.
        return $this->status === 'pending'
            && $this->payment_status === 'unpaid';
    }

    /**
     * Kiểm tra đơn có thể cập nhật/chèn lại ảnh chuyển khoản.
     * Chỉ cho phép khi đơn còn pending và chưa hoàn tất thanh toán.
     */
    public function canUploadProof(): bool
    {
        return $this->status === 'pending'
            && $this->payment_method === 'bank_transfer'
            && in_array($this->payment_status, ['unpaid', 'waiting_verify'], true);
    }

    /**
     * Label hiển thị tiếng Việt của trạng thái đơn.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'   => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'cancelled' => 'Đã hủy',
            'completed' => 'Hoàn thành',
            default     => 'Không xác định',
        };
    }

    /**
     * Bootstrap class Bootstrap badge cho trạng thái đơn.
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'primary',
            default     => 'secondary',
        };
    }

    /**
     * Label tiếng Việt của trạng thái thanh toán.
     */
    public function paymentStatusLabel(): string
    {
        return match ($this->payment_status) {
            'unpaid'         => 'Chưa thanh toán',
            'waiting_verify' => 'Đang chờ duyệt',
            'refund_pending' => 'Chờ hoàn tiền',
            'paid'           => 'Đã thanh toán',
            'refunded'       => 'Đã hoàn tiền',
            default          => 'Không xác định',
        };
    }

    /**
     * Badge class cho trạng thái thanh toán.
     */
    public function paymentBadgeClass(): string
    {
        return match ($this->payment_status) {
            'unpaid'         => 'secondary',
            'waiting_verify' => 'warning',
            'refund_pending' => 'warning',
            'paid'           => 'success',
            'refunded'       => 'info',
            default          => 'secondary',
        };
    }

    /**
     * Label phương thức thanh toán.
     */
    public function paymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'cod'           => 'Thanh toán khi đón',
            default         => 'Chưa chọn',
        };
    }

    /**
     * Nội dung chuyển khoản để khách copy và admin đối soát.
     * Format: MaDon_TenKhach_TenTour_SoNguoinguoi
     * Ví dụ: TM260419-00042_NguyenVanA_DaLatTuyet_3nguoi
     */
    public function getTransferContentAttribute(): string
    {
        $clean = fn(string $s, int $maxLen = 0) => \Illuminate\Support\Str::limit(
            preg_replace('/[^A-Za-z0-9]/', '', \Illuminate\Support\Str::ascii($s)),
            $maxLen ?: 999,
            ''
        );

        $code     = $this->transaction_code ?? 'PENDING';
        $userName = $clean($this->user?->name ?? 'Khach', 20);
        $tourName = $clean($this->product?->name ?? 'Tour', 20);
        $quantity = $this->quantity ?? 1;

        return "{$code}_{$userName}_{$tourName}_{$quantity}nguoi";
    }

    /**
     * Sinh mã giao dịch từ ID + thời gian.
     * Dạng: TM250416-00042
     */
    public static function generateTransactionCode(int $id): string
    {
        return 'TM' . now()->format('ymd') . '-' . str_pad($id, 5, '0', STR_PAD_LEFT);
    }
}
