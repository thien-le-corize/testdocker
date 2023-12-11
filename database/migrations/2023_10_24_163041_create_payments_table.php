<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->decimal('amount')->nullable(); // số tiền thanh toán
            $table->string('bank_code')->nullable();  // mã ngân hàng thanh toán
            $table->string('transaction_no')->nullable();  // mã giao dịch
            $table->string('card_type')->nullable();  // Loại tài khoản/thẻ khách hàng sử dụng:ATM,QRCODE, Pay
            $table->string('order_info')->nullable();  // Thông tin mô tả nội dung thanh toán
            $table->string('transaction_code')->nullable(); //Mã phản hồi kết quả thanh toán.
            $table->string('TxnRef')->nullable(); //Mã order.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
