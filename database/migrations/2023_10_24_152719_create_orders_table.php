<?php

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            
            $table->foreignId('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('payment_method')->default(Order::CASH_ON_DELIVERY); 
            // $table->integer('status')->default(Order::PENDING);
            
            $table->foreignId('shop_id');
            $table->foreign('shop_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreignId('address_id')->nullable();
            $table->foreign('address_id')
                ->references('id')
                ->on('address')
                ->onDelete('cascade');

            $table->string('note')->nullable();
            $table->timestamps();
        });

        DB::statement('
            ALTER TABLE orders 
                ADD COLUMN discount_amount numeric NULL,
                ADD COLUMN amount numeric NULL,
                ADD COLUMN shipping_fee numeric NULL
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
