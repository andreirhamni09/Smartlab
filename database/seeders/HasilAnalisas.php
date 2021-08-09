<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HasilAnalisas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) { 
            
            DB::table('hasil_analisas')->insert(array(
                array(
                    'jenis_sampels_id'      => '1',
                    'data_sampels_id'       => '1',
                    'tahun'                 => '21',
                    'no_lab'                => $i,
                    'kode_contoh'           => '',
                    'parameters_id_s'       => '1-2-3',
                    'hasil'                 => '',
                    'status'                => '0',
                    'retry'                 => 0
                )
            )); 
        }
    }
}
