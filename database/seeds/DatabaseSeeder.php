<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Database\seeds\RoleTableSeeder;
use Database\seeds\ApisTableSeeder;
use Database\seeds\BackgroundsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        $this->call(RoleTableSeeder::class);
        $this->call(ApisTableSeeder::class);
        $this->call(BackgroundsTableSeeder::class);

        Model::reguard();
    }
}
