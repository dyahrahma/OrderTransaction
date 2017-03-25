<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id')->unsigned();
            $table->integer('shipping_id')->unsigned();
            $table->boolean('is_finalized');    //is_submitted
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->double('original_price');
            $table->double('final_price');
            $table->string('payment_proof_path');
            $table->boolean('is_validated');
            $table->boolean('is_valid'); //is_canceled vs is_prepared
            $table->boolean('is_shipped');
            $table->dateTime('date_order');
            $table->timestamps();

            $table->foreign('coupon_id')->references('id')->on('coupons')->nullable();
            $table->foreign('shipping_id')->references('id')->on('shipments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');
    }
}
