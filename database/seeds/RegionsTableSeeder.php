<?php

use Illuminate\Database\Seeder;


class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'region_name' => 'region 1',
            'country'=>'1',
        ]);

         DB::table('regions')->insert([
            'region_name' => 'region 2',
            'country'=>'1',
        ]);

          DB::table('regions')->insert([
            'region_name' => 'region 3',
            'country'=>'2',
        ]);

           DB::table('regions')->insert([
            'region_name' => 'region 4',
            'country'=>'2',
        ]);
    }
}
