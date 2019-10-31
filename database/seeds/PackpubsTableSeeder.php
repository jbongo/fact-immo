<?php

use Illuminate\Database\Seeder;

class PackpubsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('packpubs')->delete();
        
        \DB::table('packpubs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom' => 'pack10',
                'tarif' => 150.0,
                'created_at' => '2019-10-14 08:35:05',
                'updated_at' => '2019-10-14 08:35:05',
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'pack20',
                'tarif' => 200.0,
                'created_at' => '2019-10-14 08:35:42',
                'updated_at' => '2019-10-30 14:30:08',
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => 'pack30',
                'tarif' => 300.0,
                'created_at' => '2019-10-30 14:30:21',
                'updated_at' => '2019-10-30 14:30:21',
            ),
        ));
        
        
    }
}