<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'waiting_verify', 'refund_pending', 'paid', 'refunded'])
                ->default('unpaid')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'waiting_verify', 'paid', 'refunded'])
                ->default('unpaid')
                ->change();
        });
    }
};

