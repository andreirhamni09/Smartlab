<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSampels extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_sampels')->insert(array(
            array(
                'id_pelanggan'      => '1',
                'id_parameter'      => '1-2-3-4',
                'id_jenis_sampel'   => '1',
                'tanggal_masuk'     => '2021-08-04 10:31:00',
                'tanggal_selesai'   => '10',
                'nomor_surat'       => 'ssms',
                'perusahaan'        => 'SSMS',
                'jumlah_sampel'     => '10',
                'status'            => ''
            ),
        ));
    }
}
