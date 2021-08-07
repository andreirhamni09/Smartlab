<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tabel_aktivitas')->insert(array(
            array(
                'aktivitas'    => 'registrasi sampel'
            ),
            array(
                'aktivitas'    => 'verifikasi lab'
            ),
            array(
                'aktivitas'    => 'verifikasi pelanggan'
            ),
            array(
                'aktivitas'    => 'preparasi'
            ),
            array(
                'aktivitas'    => 'oven'
            )
        ));
    }
}
