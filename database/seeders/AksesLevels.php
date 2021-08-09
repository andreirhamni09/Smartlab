<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AksesLevels extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('akses_levels')->insert(array(
            array(
                'id'                          => '1',
                'jabatan'                     => 'analis',
                'halamans_id_s'               => ''
            ),
            array(
                'id'                          => '2',
                'jabatan'                     => 'admin',
                'halamans_id_s'               => ''
            ),
            array(
                'id'                          => '3',
                'jabatan'                     => 'penyelia',
                'halamans_id_s'               => ''
            ),
            array(
                'id'                          => '4',
                'jabatan'                     => 'qc',
                'halamans_id_s'               => ''
            ),
            array(
                'id'                          => '5',
                'jabatan'                     => 'penyelia',
                'halamans_id_s'               => ''
            )
        )); 
    }
}
