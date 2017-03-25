<?php

use Illuminate\Database\Seeder;

class ShipmentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('shipment_status')->count() < 1) {
        	DB::table('shipment_status')->insert([
	            'id' =>1,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-23 20:33:00"),
                'status' => 'SHIPMENT RECEIVED BY JNE COUNTER OFFICER AT [JAKARTA]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>2,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-23 21:37:00"),
                'status' => 'RECEIVED AT SORTING CENTER [JAKARTA]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>3,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-23 22:04:00"),
                'status' => 'PROCESSED AT SORTING CENTER [JAKARTA]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>4,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-23 23:11:00"),
                'status' => 'SHIPMENT PICKED UP BY JNE COURIER [JAKARTA]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>5,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-24 06:15:00"),
                'status' => 'DEPARTED FROM TRANSIT [GATEWAY, BANDUNG]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>6,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-24 08:11:00"),
                'status' => 'RECEIVED AT WAREHOUSE [BANDUNG]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>7,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-24 14:17:00"),
                'status' => 'WITH DELIVERY COURIER [BANDUNG]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>8,
	            'shipment_id' => 1,
                'status_time' => date("2017-03-24 19:15:00"),
                'status' => 'DELIVERED TO [RAHMA | 12-03-2017 19:03 ]'
	        ]);

        	DB::table('shipment_status')->insert([
	            'id' =>9,
	            'shipment_id' => 2,
                'status_time' => date("2017-03-25 18:15:00"),
                'status' => 'SHIPMENT RECEIVED BY JNE COUNTER OFFICER AT [JAKARTA]'
	        ]);

	    }
    }
}
