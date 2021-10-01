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
                'aktivitas'     => 'registrasi_sampel',
                'groups_id'     => 1
            ),
            array(
                'aktivitas'     => 'verifikasi_lab',
                'groups_id'     => 1
            ),
            array(
                'aktivitas'     => 'verifikasi_pelanggan',
                'groups_id'     => 1
            ),
            array(
                'aktivitas'     => 'oven',
                'groups_id'     => 2
            ),
            array(
                'aktivitas'     => 'preparasi',
                'groups_id'     => 3
            ),
        )); 
    }
}
