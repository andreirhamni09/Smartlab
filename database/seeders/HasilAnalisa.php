<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HasilAnalisa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++)
        {
            DB::table('hasil_analisas')->insert(array(
                array(
                    'id_kupa'           => '1',
                    'tahun'             => '21',
                    'id_jenis_sampel'   => '1',
                    'no_lab'            => $i,
                    'kode_contoh'       => '',
                    'id_petugas'        => '',
                    'N'                 => 0.000,
                    'P'                 => 0.000,
                    'K'                 => 0.000,
                    'Mg'                => 0.000,
                    'Ca'                => 0.000,
                    'B'                 => 0.000,
                    'Cu'                => 0.000,
                    'Zn'                => 0.000,
                    'Fe'                => 0.000,
                    'Mn'                => 0.000,
                    'status'            => '0',
                    'retry'             => '0',
                ),
            ));
        }
    }
}
