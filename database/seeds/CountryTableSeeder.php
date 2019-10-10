<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data=[['country'=>'Thailand'],['country'=>'cambodia']];
    	Country::insert($data);
    }
}
