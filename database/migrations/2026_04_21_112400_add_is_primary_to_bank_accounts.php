<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->boolean('is_primary')->default(false)->after('is_active')
                  ->comment('Tài khoản chính hiển thị cho khách thanh toán');
        });
    }

    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('is_primary');
        });
    }
};
