<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Thêm voucher_code vào bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('voucher_code', 20)->nullable()->unique()->after('transaction_code');
        });

        // Bảng thông báo
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type', 50);           // booking_confirmed, payment_verified, booking_cancelled
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();    // URL để redirect khi click
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('voucher_code');
        });

        Schema::dropIfExists('notifications');
    }
};
