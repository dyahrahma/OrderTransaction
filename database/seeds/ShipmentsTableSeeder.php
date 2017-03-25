<?php

use Illuminate\Database\Seeder;

class ShipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('shipments')->count() < 1) {
        	DB::table('shipments')->insert([
	            'id' =>1,
	            'no_awb' => '01067105501317',
                'shipment_date' => '20170323'
	        ]);
			
			DB::table('shipments')->insert([
                'id' =>2,
                'no_awb' => '00351107667777',
                'shipment_date' => '20170325'
            ]);
	    }
    }
}
