<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique()->comment('Mã coupon');
            $table->text('description')->nullable()->comment('Mô tả coupon');
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage')->comment('Loại giảm giá');
            $table->decimal('discount_value', 10, 2)->comment('Giá trị giảm giá');
            $table->decimal('min_order_value', 10, 2)->nullable()->comment('Giá trị đơn hàng tối thiểu');
            $table->decimal('max_discount_amount', 10, 2)->nullable()->comment('Số tiền giảm tối đa');
            $table->integer('usage_limit')->nullable()->comment('Giới hạn số lần sử dụng');
            $table->integer('used_count')->default(0)->comment('Số lần đã sử dụng');
            $table->dateTime('start_date')->nullable()->comment('Ngày bắt đầu hiệu lực');
            $table->dateTime('end_date')->nullable()->comment('Ngày hết hạn');
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->comment('Người tạo coupon');
            $table->timestamps();
            
            $table->index('code', 'idx_coupon_code');
            $table->index(['start_date', 'end_date'], 'idx_coupon_dates');
        });

        // Cập nhật bảng payments
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null')->comment('Coupon sử dụng');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn('coupon_id');
        });
        
        Schema::dropIfExists('coupons');
    }
};