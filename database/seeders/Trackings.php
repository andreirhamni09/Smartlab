<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Trackings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_trackings')->insert(array(
            array(
                'aktivitas_waktu'       => '2021-08-04 05:50:53',
                'kupa_id'               => '1',
                'aktivitas_id'          => '1',
                'petugas_id'            => '1'
            ),
            array(
                'aktivitas_waktu'       => '2021-08-04 06:50:53',
                'kupa_id'               => '1',
                'aktivitas_id'          => '2',
                'petugas_id'            => '2'
            ),
        ));
    }
}
