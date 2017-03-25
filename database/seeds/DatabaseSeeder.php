<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(CouponsTableSeeder::class);
        $this->call(ShipmentsTableSeeder::class);
        $this->call(ShipmentStatusTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderedProductsTableSeeder::class);
    }
}
