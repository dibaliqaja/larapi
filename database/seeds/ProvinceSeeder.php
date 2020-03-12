<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for($i = 1; $i <= 10; $i++){
    		DB::table('provinces')->insert([
    			'province_name' => $faker->ciy,
    			'capital_city' => $faker->city
    		]);

    	}
    }
}
