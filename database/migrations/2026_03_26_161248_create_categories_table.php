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
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment('Khóa chính của danh mục');
            $table->string('name')->comment('Tên danh mục');
            $table->string('slug')->unique()->comment('Đường dẫn thân thiện SEO (slug) của danh mục');
            $table->text('description')->nullable()->comment('Mô tả chi tiết về danh mục');
            $table->timestamps();
            $table->softDeletes()->comment('Lưu thời điểm xóa mềm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
