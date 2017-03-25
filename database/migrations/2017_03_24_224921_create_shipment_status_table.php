<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_status', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('status_time');
            $table->string('status', 255);            
            $table->integer('shipping_id')->unsigned();
            $table->timestamps();

            $table->foreign('shipping_id')->references('id')->on('shipments');
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
        Schema::dropIfExists('shipment_status');
    }
}
