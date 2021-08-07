<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'email'                 => 'andre09@gmail.com',
                'password'              => 'asdasdasd',
                'nama'                  => 'Andre Septio Irhamni Wicaksana',
                'perusahaan'            => 'SSMS',
                'nomor_telepon'         => '085236178019',
                'alamat'                => 'RND',
                'tanggal_registrasi'    => '2021-07-21'
            ),
        ));
    }
}
