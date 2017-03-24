<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('role_user')->count() < 1) {
        	DB::table('role_user')->insert([
	            'user_id' =>1,
	            'role_id' => 1
	        ]);
			
			DB::table('role_user')->insert([
	            'user_id' =>2,
	            'role_id' => 2
	        ]);
	    }
    }
}
