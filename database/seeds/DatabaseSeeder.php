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
        // $this->call(UsersTableSeeder::class);
        $faker = Faker::create('id_ID');
    	for($i = 1; $i <= 5; $i++){
    		DB::table('cities')->insert([
    			'city_name' => $faker->city,
            ]);
            DB::table('areas')->insert([
    			'area_name' => $faker->city,
    		]);
        }
    }
}
