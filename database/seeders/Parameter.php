<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Parameter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parameters')->insert(array(
            array(
                'simbol'         => 'N',
                'nama_unsur'     => 'Nitrogen'
            ),
            array(
                'simbol'         => 'P',
                'nama_unsur'     => 'Pospor'
            ),
            array(
                'simbol'         => 'K',
                'nama_unsur'     => 'Kalium'
            ),
            array(
                'simbol'         => 'Mg',
                'nama_unsur'     => 'Mangan'
            ),
            array(
                'simbol'         => 'Ca',
                'nama_unsur'     => 'Kalsium'
            ),
            array(
                'simbol'         => 'Cu',
                'nama_unsur'     => 'Tembaga'
            ),
            array(
                'simbol'         => 'Zn',
                'nama_unsur'     => 'Seng'
            ),
            array(
                'simbol'         => 'Mn',
                'nama_unsur'     => 'Mangan'
            ),
            array(
                'simbol'         => 'Fe',
                'nama_unsur'     => 'Besi'
            ),
            array(
                'simbol'         => 'B',
                'nama_unsur'     => 'Boron'
            )
        ));
    }
}
