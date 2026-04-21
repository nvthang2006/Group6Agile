<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'link',
        'booking_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // ─────────────────────────────────────────────
    //  Relationships
    // ─────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // ─────────────────────────────────────────────
    //  Scopes
    // ─────────────────────────────────────────────

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ─────────────────────────────────────────────
    //  Helper Methods
    // ─────────────────────────────────────────────

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Tạo thông báo nhanh.
     */
    public static function send(int $userId, string $type, string $title, string $message, ?string $link = null, ?int $bookingId = null): self
    {
        return self::create([
            'user_id'    => $userId,
            'type'       => $type,
            'title'      => $title,
            'message'    => $message,
            'link'       => $link,
            'booking_id' => $bookingId,
        ]);
    }

    /**
     * Icon cho từng loại thông báo.
     */
    public function icon(): string
    {
        return match ($this->type) {
            'new_booking'        => '🌟',
            'booking_confirmed'  => '✅',
            'payment_verified'   => '💰',
            'booking_cancelled'  => '❌',
            'voucher_issued'     => '🎫',
            default              => '🔔',
        };
    }
}
