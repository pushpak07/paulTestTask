<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(
         	CountryTableSeeder::class);

         $this->call(PropertiesTypeTableSeeder::class);
         $this->call(RegionsTableSeeder::class);
         $this->call(StatusTableSeeder::class);
    }
}
