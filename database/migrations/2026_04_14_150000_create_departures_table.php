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
        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->date('departure_date');
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('booked_seats')->default(0);
            $table->decimal('price', 15, 2);
            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['product_id', 'departure_date']);
            $table->index(['status', 'departure_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departures');
    }
};

