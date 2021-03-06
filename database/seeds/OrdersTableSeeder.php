<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('orders')->count() < 1) {
        	DB::table('orders')->insert([
	            'id' =>1,
                'user_id' => 2,
	            'coupon_id' => 1,
                'is_finalized' => true,
                'name' => 'customer dyah rahma',
                'phone' => '085716661493',
                'email' => 'dyah.rahma777@gmail.com',
                'address' => 'Jl Pelesiran 81A/56',
                'original_price' => 7200000,
                'final_price' => 7150000,
                'payment_proof_path' => '/images/payment/1.jpg',
                'is_validated' => true,
                'is_valid' => true,
                'is_shipped' => true,
                'shipment_id' => 1,
                'date_order' => '20170323',
                'finalizing_time' => date("2017-03-23 11:00:00"),
                'validating_time' => date("2017-03-23 13:00:00"),
                'shipping_time' => date("2017-03-23 20:33:00")
	        ]);
			
			DB::table('orders')->insert([
                'id' =>2,
                'user_id' => 2,
                'coupon_id' => 2,
                'is_finalized' => true,
                'name' => 'test user',
                'phone' => '081111111111',
                'email' => '111@11.com',
                'address' => 'Jl A 1',
                'original_price' => 1900000,
                'final_price' => 1710000,
                'payment_proof_path' => '/images/payment/2.jpg',
                'is_validated' => true,
                'is_valid' => true,
                'is_shipped' => true,
                'shipment_id' => 2,
                'date_order' => '20170325',
                'finalizing_time' => date("2017-03-25 10:00:00"),
                'validating_time' => date("2017-03-25 14:00:00"),
                'shipping_time' => date("2017-03-25 18:15:00")
            ]);
	    }
    }
}
