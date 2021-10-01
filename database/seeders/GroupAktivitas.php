<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupAktivitas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_aktivitas')
        ->insert(array(
            array(
                'group'     => 'REGISTRASI SAMPEL'
            ),
            array(
                'group'     => 'PREPARASI'
            ),
            array(
                'group'     => 'ANALISIS SAMPEL'
            ),
        ));
    }
}
