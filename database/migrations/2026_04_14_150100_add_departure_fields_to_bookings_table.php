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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('departure_id')
                ->nullable()
                ->after('product_id')
                ->constrained('departures')
                ->nullOnDelete();
            $table->decimal('unit_price', 15, 2)->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('departure_id');
            $table->dropColumn('unit_price');
        });
    }
};

