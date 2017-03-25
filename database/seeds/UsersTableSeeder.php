<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::count() < 1) {
            User::create([
            	'name' => 'admin dyah rahma',
                'email' => 'dyraw777@gmail.com',
                'password' => Hash::make('dyah123'),
            	'phone' => '0895606479693',
                'address' => 'Coblong',
            ]);
			
			User::create([
            	'name' => 'customer dyah rahma',
                'email' => 'dyah.rahma777@gmail.com',
                'password' => Hash::make('dyah123'),
            	'phone' => '085716661493',
                'address' => 'Jl Pelesiran 81A/56',
            ]);
        }
    }
}
