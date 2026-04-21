<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departures', function (Blueprint $table) {
            $table->time('departure_time')
                ->default('08:00:00')
                ->after('departure_date');
        });
    }

    public function down(): void
    {
        Schema::table('departures', function (Blueprint $table) {
            $table->dropColumn('departure_time');
        });
    }
};

