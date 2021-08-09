<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabAkuns extends Seeder
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
                'metodes_id_s'          => '1-2-3',
                'akses_levels_id'       => '3',
                'nama'                  => 'Indah',
                'email'                 => 'indah09@gmail.com',
                'password'              => 'asdasdasd',
                'jabatan'               => 'penyelia',
                'status_akun'           => '1'
            ),
            array(
                'metodes_id_s'          => '1-2-3',
                'akses_levels_id'       => '1',
                'nama'                  => 'Yolanda Aptria',
                'email'                 => 'yolanda_aptria09@gmail.com',
                'password'              => 'asdasdasd',
                'jabatan'               => 'analis',
                'status_akun'           => '1'
            )
        )); 
    }
}
