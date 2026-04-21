<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng voucher do Admin quản lý
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();               // Mã voucher: GIAM50K, SUMMER2026...
            $table->string('name');                               // Tên: "Giảm 50K mùa hè"
            $table->text('description')->nullable();
            $table->enum('type', ['fixed', 'percent']);           // fixed = giảm cố định, percent = giảm %
            $table->unsignedInteger('value');                     // 50000 hoặc 10 (%)
            $table->unsignedInteger('max_discount')->nullable();  // Giảm tối đa (cho loại percent)
            $table->unsignedInteger('min_order')->default(0);     // Đơn tối thiểu để dùng
            $table->unsignedInteger('max_uses')->nullable();      // Tổng lượt dùng tối đa (null = không giới hạn)
            $table->unsignedInteger('used_count')->default(0);    // Đã dùng bao nhiêu lần
            $table->date('starts_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Thêm cột voucher vào bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('voucher_id')->nullable()->constrained()->nullOnDelete()->after('voucher_code');
            $table->unsignedInteger('discount_amount')->default(0)->after('voucher_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['voucher_id', 'discount_amount']);
        });

        Schema::dropIfExists('vouchers');
    }
};
