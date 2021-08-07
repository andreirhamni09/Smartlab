<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLabs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lab_akuns')->insert(array(
            array(
                'nama'                  => 'Andre Septio Irhamni Wicaksana',
                'id_akses'              => '2',
                'jabatan'               => 'ADMIN',
                'email'                 => 'andre09@gmail.com',
                'password'              => 'asdasdasd',
                'status_akun'           => '1'
            ),
            array(
                'nama'                  => 'Sulpi',
                'id_akses'              => '1',
                'jabatan'               => 'ANALIS',
                'email'                 => 'sulpi09@gmail.com',
                'password'              => 'asdasdasd',
                'status_akun'           => '1'
            ),
        ));
    }
}
