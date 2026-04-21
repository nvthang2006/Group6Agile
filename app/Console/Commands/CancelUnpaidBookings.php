<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CancelUnpaidBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:cancel-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hủy các đơn đặt tour quá hạn thanh toán (15 phút)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Quá hạn 15 phút
        $cutoffTime = Carbon::now()->subMinutes(15);

        // Quét các đơn chưa thanh toán, tạo trước ngưỡng thời gian này
        $bookings = Booking::where('payment_status', 'unpaid')
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('created_at', '<=', $cutoffTime)
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('Không có đơn hàng nào quá hạn cần hủy.');
            return;
        }

        $count = 0;

        foreach ($bookings as $booking) {
            try {
                DB::transaction(function () use ($booking) {
                    $booking->update([
                        'status' => 'cancelled',
                        'cancelled_reason' => 'Hệ thống tự động hủy do quá hạn thanh toán 15 phút (Anti-Spam).',
                    ]);

                    if ($booking->departure) {
                        $booking->departure->decrement('booked_seats', $booking->quantity);
                    }
                });
                $count++;
            } catch (\Exception $e) {
                Log::error("Lỗi khi auto-cancel booking ID {$booking->id}: " . $e->getMessage());
            }
        }

        $this->info("Đã auto-cancel thành công {$count} đơn hàng.");
    }
}
