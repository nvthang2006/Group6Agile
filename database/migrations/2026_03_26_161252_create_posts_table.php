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
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->comment('Khóa chính của bài viết blog');
            $table->string('title')->comment('Tiêu đề chính thức của bài viết');
            $table->string('slug')->comment('Slug cho bài viết');
            $table->longText('content')->comment('Nội dung chi tiết của bài viết được hiển thị');
            $table->string('image')->nullable()->comment('Đường dẫn hình đại diện cho bài viết');
            // Assuming users table is already present from auth scaffolding
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ID của người dùng/tác giả đã viết bài');
            $table->timestamps();
            $table->softDeletes()->comment('Lưu thông tin thời điểm xóa thay vì xóa cứng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
