<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailTrackings extends Seeder
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
                'aktivitas_waktu'          => '2021-08-09 11:00:00',
                'data_sampels_id'          => '1',
                'aktivitas_id'             => '1',
                'lab_akuns_id'             => '1'
            )
        )); 
    }
}
