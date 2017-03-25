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
            $table->integer('user_id')->unsigned();
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->integer('shipment_id')->unsigned()->nullable();
            $table->boolean('is_finalized')->default(false);    //is_submitted
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->double('original_price')->nullable();
            $table->double('final_price')->nullable();
            $table->string('payment_proof_path')->nullable();
            $table->boolean('is_validated')->default(false);
            $table->boolean('is_valid')->default(false); //is_canceled vs is_prepared
            $table->boolean('is_shipped')->default(false);
            $table->dateTime('date_order');
            $table->dateTime('finalizing_time')->nullable();
            $table->dateTime('validating_time')->nullable();
            $table->dateTime('shipping_time')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->foreign('shipment_id')->references('id')->on('shipments');
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
