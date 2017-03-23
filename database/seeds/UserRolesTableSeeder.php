<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('user_roles')->count() < 1) {
        	DB::table('user_roles')->insert([
	            'email' =>'dyah.rahma777@gmail.com',
	            'role_id' => 1
	        ]);
			
			DB::table('user_roles')->insert([
	            'email' =>'dyraw777@gmail.com',
	            'role_id' => 2
	        ]);
	    }
    }
}
