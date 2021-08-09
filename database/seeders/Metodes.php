<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Metodes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metodes')->insert(array(
            array(
                'metode'            => 'Flamephotometry/AAS',
                'parameters_id_s'   => '3-4-5-6-7-8-9'    
            ),
            array(
                'metode'            => 'Spektrophotometry',
                'parameters_id_s'   => '2-10'    
            ),
            array(
                'metode'            => 'Kjedahl',
                'parameters_id_s'   => '1'
            )
        )); 
    }
}
