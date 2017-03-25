<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('products')->count() < 1) {
        	DB::table('products')->insert([
	            'id' =>1,
	            'name' => 'Xiaomi Mi Note 2',
                'detail' => '5.7 Inch, Snapdragon 821 quad core CPU, 6GB RAM, 128GB ROM, 22.5MP rear + 8MP front dual camera, Android 6.0 OS.',
                'quantity' => 10,
                'price' => 6899000
	        ]);
			
			DB::table('products')->insert([
                'id' =>2,
                'name' => 'Xiaomi Mi Mix',
                'detail' => 'OS Android OS v6.0 (Marshmallow), Chipset Qualcomm MSM8996 Snapdragon 821 CPU Quad-core (GPU Adreno 530, 256 GB ROM, 6 GB RAM',
                'quantity' => 7,
                'price' => 10800000
            ]);

            DB::table('products')->insert([
                'id' =>3,
                'name' => 'Xiaomi Redmi 4 Prime',
                'detail' => 'RAM 3 GB, memori internal 32 GB, prosesor Snapdragon 625 dan resolusi layar 1080 x 1920 pixels',
                'quantity' => 5,
                'price' => 1900000
            ]);

            DB::table('products')->insert([
                'id' =>4,
                'name' => 'Xiaomi Redmi 4A',
                'detail' => 'RAM 2 GB, internal 16 GB, prosesor Snapdragon 425',
                'quantity' => 3,
                'price' => 1500000
            ]);

            DB::table('products')->insert([
                'id' =>5,
                'name' => 'Xiaomi Mi 5s',
                'detail' => 'Internal 64 GB, 3 GB RAM, Versi OS Android OS, v6.0 (Marshmallow), Jenis CPU Qualcomm MSM8996 Snapdragon 821 CPU Quad-core, GPU Adreno 530',
                'quantity' => 0,
                'price' => 4200000
            ]);
	    }
    }
}
