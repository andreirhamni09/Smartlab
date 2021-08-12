<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Aktivitas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aktivitas')->insert(array(
            array(
                'aktivitas'     => 'registrasi_sampel'
            ),
            array(
                'aktivitas'     => 'verifikasi_lab'
            ),
            array(
                'aktivitas'     => 'verifikasi_pelanggan'
            ),
            array(
                'aktivitas'     => 'oven'
            ),
            array(
                'aktivitas'     => 'preparasi'
            ),
        )); 
    }
}
