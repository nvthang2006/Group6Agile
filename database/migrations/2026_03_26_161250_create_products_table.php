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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->comment('Khóa chính của sản phẩm');
            $table->string('name')->comment('Tên sản phẩm');
            $table->string('slug')->unique()->comment('Đường dẫn thân thiện SEO (slug) của sản phẩm');
            $table->decimal('price', 15, 2)->comment('Giá bán gốc của sản phẩm');
            $table->decimal('sale_price', 15, 2)->nullable()->comment('Giá khuyến mãi của sản phẩm (tùy chọn)');
            $table->string('image')->nullable()->comment('Đường dẫn tới hình ảnh đại diện của sản phẩm');
            $table->text('description')->nullable()->comment('Đoạn mô tả chi tiết cho sản phẩm');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete()->comment('ID cấu trúc danh mục, liên kết phân loại sản phẩm');
            $table->timestamps();
            $table->softDeletes()->comment('Lưu nhật ký xóa mềm theo chuẩn Laravel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
