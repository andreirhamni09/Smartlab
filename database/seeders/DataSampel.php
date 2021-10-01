<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSampel extends Seeder
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
                'jenis_sampels_id'      => '1',
                'pelanggans_id'         => '1',
                'pakets_id_s'           => '1-2-3',
                'tanggal_masuk'         => '2021-08-09 11:00:00',
                'tanggal_selesai'       => '10',
                'nomor_surat'           => '1010',
                'jumlah_sampel'         => '100',
                'ketersedian_alats_id'  => 1,
                'catatan_userlabs'      => '',
                'catatan_pelanggans'    => '',
                'status'                => '0'
            )
        )); 
    }
}
