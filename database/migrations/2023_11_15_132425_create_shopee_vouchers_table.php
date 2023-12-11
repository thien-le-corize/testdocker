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
        Schema::create('shopee_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('discount');
            $table->date('start_at');
            $table->date('end_at');
            $table->string('description')->nullable();
            $table->boolean('type_reduction')->default(true);
            $table->integer('usage_quantity');
            $table->jsonb('rule')->nullable();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('
            ALTER TABLE shopee_vouchers 
                ADD COLUMN max_value_reduction numeric,
                ADD COLUMN min_price numeric
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopee_vouchers');
    }
};
