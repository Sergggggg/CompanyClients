<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
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

        	$company[] = [
        			     'company' => $faker->company,
        				];  
        }

        $chunks = array_chunk($company, 250);

        foreach ($chunks as $chunk) {
                DB::table('companies')->insert($chunk);
            }
    }
}