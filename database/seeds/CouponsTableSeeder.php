<?php

use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('coupons')->count() < 1) {
        	DB::table('coupons')->insert([
	            'id' =>1,
	            'code' => 'PROMO50K',
                'is_nominal' => true,
                'discount_nominal' => 50000,
                'discount_percentage' => 0,
                'start_date' => '20170101',
                'expired_date' => '20170501',
                'quantity' => 15
	        ]);
			
			DB::table('coupons')->insert([
                'id' =>2,
                'code' => 'MARCH10',
                'is_nominal' => false,
                'discount_nominal' => 0,
                'discount_percentage' => 10,
                'start_date' => '20170101',
                'expired_date' => '20170501',
                'quantity' => 7
            ]);

            DB::table('coupons')->insert([
                'id' =>3,
                'code' => 'ENDYEAR16',
                'is_nominal' => true,
                'discount_nominal' => 75000,
                'discount_percentage' => 0,
                'start_date' => '20161201',
                'expired_date' => '20171231',
                'quantity' => 5
            ]);
	    }
    }
}
