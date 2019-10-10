<?php

use Illuminate\Database\Seeder;

class PropertiesTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_types')->insert([
            'type' => 'Condo'
        ]);

         DB::table('property_types')->insert([
            'type' => 'House'
        ]);

          DB::table('property_types')->insert([
            'type' => 'Land'
        ]);
    }
}
