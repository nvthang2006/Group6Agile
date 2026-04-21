<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->comment('Tên ngân hàng, ví dụ: Vietcombank, MB Bank');
            $table->string('account_number')->comment('Số tài khoản');
            $table->string('account_name')->comment('Tên chủ tài khoản');
            $table->string('branch')->nullable()->comment('Chi nhánh');
            $table->string('qr_code')->nullable()->comment('Ảnh QR thanh toán');
            $table->boolean('is_active')->default(true)->comment('Đang kích hoạt hay không');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
