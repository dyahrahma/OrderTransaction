<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Role::count() < 1) {
        	DB::table('roles')->insert([
	            [
	            'id' => 1,
	            'role' => 'Admin'
	            ],
	            [
	            'id' => 2,
	            'role' => 'Customer'
	            ]
	        ]);
	    }
    }
}
