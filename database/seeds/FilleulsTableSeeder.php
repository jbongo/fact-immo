<?php

use Illuminate\Database\Seeder;

class FilleulsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('filleuls')->delete();
        
        \DB::table('filleuls')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 4,
                'parrain_id' => 2,
                'rang' => 1,
                'pourcentage' => 0.0,
                'expire' => 0,
                'created_at' => '2019-10-14 09:20:56',
                'updated_at' => '2019-10-14 09:20:56',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 12,
                'parrain_id' => 11,
                'rang' => 1,
                'pourcentage' => 5.0,
                'expire' => 0,
                'created_at' => '2019-10-17 13:28:40',
                'updated_at' => '2019-10-17 13:28:40',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 11,
                'parrain_id' => 13,
                'rang' => 1,
                'pourcentage' => 5.0,
                'expire' => 0,
                'created_at' => '2019-10-28 11:05:21',
                'updated_at' => '2019-10-28 11:08:28',
            ),
        ));
        
        
    }
}