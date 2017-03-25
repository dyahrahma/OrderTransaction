<?php

use Illuminate\Database\Seeder;

class OrderedProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('ordered_products')->count() < 1) {
            DB::table('ordered_products')->insert([
                'id' =>1,
                'order_id' => 1,
                'product_id' => 4,
                'quantity' => 2,
                'total_price' => 3000000
            ]);
            
            DB::table('ordered_products')->insert([
                'id' =>2,
                'order_id' => 1,
                'product_id' => 5,
                'quantity' => 1,
                'total_price' => 4200000
            ]);
            
            DB::table('ordered_products')->insert([
                'id' =>3,
                'order_id' => 2,
                'product_id' => 3,
                'quantity' => 1,
                'total_price' => 1900000
            ]);
        }
    }
}
