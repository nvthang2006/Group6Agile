<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Thêm mã giao dịch tự sinh
            $table->string('transaction_code', 20)->nullable()->unique()->after('note')
                ->comment('Mã giao dịch tự sinh cho mỗi đơn hàng');

            // Thông tin thanh toán
            $table->enum('payment_method', ['bank_transfer', 'cod'])->nullable()->after('transaction_code')
                ->comment('Phương thức thanh toán: bank_transfer | cod');

            $table->enum('payment_status', ['unpaid', 'waiting_verify', 'paid', 'refunded'])
                ->default('unpaid')->after('payment_method')
                ->comment('Trạng thái thanh toán');

            // Bằng chứng thanh toán (ảnh chụp chuyển khoản)
            $table->string('payment_proof')->nullable()->after('payment_status')
                ->comment('Đường dẫn ảnh chứng minh chuyển khoản');

            // Ghi chú cho lý do hủy
            $table->text('cancelled_reason')->nullable()->after('payment_proof')
                ->comment('Lý do hủy đơn');

            // Timestamps mở rộng
            $table->timestamp('confirmed_at')->nullable()->after('cancelled_reason');
            $table->timestamp('paid_at')->nullable()->after('confirmed_at');

            // Cập nhật enum status thêm trạng thái 'completed'
            // Lưu ý: MySQL không hỗ trợ ALTER ENUM trực tiếp đơn giản,
            // ta dùng change() với doctrine/dbal
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
                ->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'transaction_code',
                'payment_method',
                'payment_status',
                'payment_proof',
                'cancelled_reason',
                'confirmed_at',
                'paid_at',
            ]);

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                ->default('pending')->change();
        });
    }
};
