<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i < 12000; $i++) {

        	$clients[] = [
        			     'client' => $faker->name,
        				];  
        }

        $chunks = array_chunk($clients, 250);

        foreach ($chunks as $chunk) {
                DB::table('clients')->insert($chunk);
            }
    }
}
