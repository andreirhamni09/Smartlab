<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Parameters extends Seeder
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
                'simbol'                  => 'N',
                'nama_unsur'              => 'nitrogen'
            ),
            array(
                'simbol'                  => 'P',
                'nama_unsur'              => 'pospor'
            ),
            array(
                'simbol'                  => 'K',
                'nama_unsur'              => 'kalium'
            ),array(
                'simbol'                  => 'Mg',
                'nama_unsur'              => 'magnesium'
            ),
            array(
                'simbol'                  => 'Ca',
                'nama_unsur'              => 'kalsium'
            ),array(
                'simbol'                  => 'Cu',
                'nama_unsur'              => 'tembaga'
            ),
            array(
                'simbol'                  => 'Zn',
                'nama_unsur'              => 'seng'
            ),array(
                'simbol'                  => 'Mn',
                'nama_unsur'              => 'mangan'
            ),
            array(
                'simbol'                  => 'Fe',
                'nama_unsur'              => 'beso'
            ),
            array(
                'simbol'                  => 'B',
                'nama_unsur'              => 'boron'
            )
        ));
    }
}
