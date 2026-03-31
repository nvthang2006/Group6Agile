<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ID Khách hàng đặt tour');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->comment('ID Tour được đặt');
            $table->integer('quantity')->default(1)->comment('Số lượng người tham gia');
            $table->decimal('total_price', 15, 2)->comment('Tổng giá trị đơn hàng lúc đặt');
            $table->date('booking_date')->comment('Ngày dự kiến khởi hành');
            $table->text('note')->nullable()->comment('Ghi chú thêm của khách hàng');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending')->comment('Trạng thái đơn hàng: pending, confirmed, cancelled');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
