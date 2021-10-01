<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pelanggans extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pelanggans')->insert(array(
            array(
                'email'                 => 'indah09@gmail.com',
                'password'              => 'asdasdasd',
                'nama'                  => 'Indah',
                'perusahaan'            => 'RND',
                'nomor_telepon'         => '088288102811',
                'alamat'                => 'RND',
                'npwp'                  => '93.057.498.0-000.000',
                'kuesioner'             => '',
                'tanggal_registrasi'    => '2021-07-21'
            )
        )); 
    }
}
