<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	Status::insert([
    	[
            'status_type' => 'Active',
        ],[
            'status_type' => 'Inactive',
        ],[
            'status_type' => 'Draft',
        ]
    ]);
        // DB::table('status')->insert();

        //  DB::table('status')->insert([
        //     'status_type' => 'Inactive',
        // ]);

        //   DB::table('status')->insert([
        //     'status_type' => 'Draft',
        // ]);
    }
}
