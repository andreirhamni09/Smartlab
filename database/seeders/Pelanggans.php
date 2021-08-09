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
                'email'                 => '1-2-3',
                'password'              => '3',
                'nama'                  => 'Indah',
                'perusahaan'            => 'indah09@gmail.com',
                'nomor_telepon'         => 'asdasdasd',
                'alamat'                => 'penyelia',
                'tanggal_registrasi'    => '2021-07-21'
            )
        )); 
    }
}
