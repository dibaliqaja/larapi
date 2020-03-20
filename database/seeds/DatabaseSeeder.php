<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('provinces')->insert([
            'province_code' => 35,
    	    'province_name' => 'Jawa Timur',
        ]);

        DB::table('cities')->insert([
            'province_code' => 35,
            'city_code' => 1,
    	    'city_name' => 'Pacitan',
        ]);

        DB::table('areas')->insert([
            'province_code' => 35,
            'city_code' => 1,
            'area_code' => 1,
    	    'area_name' => 'Area Pacitan 1',
        ]);
    }
}
