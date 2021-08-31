<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Halamans extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('halamans')
        ->insert(array(
            array(
                'halaman'   => 'USERLAB',
                'url'       => 'admin/labakuns',
                'simbol'    => 'nav-icon fas fa-user'
            ),
            array(
                'halaman'   => 'PELANGGAN',
                'url'       => 'admin/pelanggans',
                'simbol'    => 'nav-icon fas fa-user'
            ),
            array(
                'halaman'   => 'DAFTAR SAMPEL',
                'url'       => 'admin/pelanggans',
                'simbol'    => 'nav-icon fas fa-list'
            ),
        ));
    }
}
