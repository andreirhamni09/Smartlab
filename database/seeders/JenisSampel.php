<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSampel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_sampels')->insert(array(
            array(
                'jenis_sampel'      => 'daun',
                'lambang_sampel'    => 'L'
            ),
            array(
                'jenis_sampel'      => 'racis',
                'lambang_sampel'    => 'R'
            )
        ));
    }
}
