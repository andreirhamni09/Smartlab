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
            array (
                    'halaman'   => 'DAFTAR USERLAB', 
                    'url'       => 'admin/labakuns', 
                    'simbol'    => 'nav-icon fas fa-user-circle'
            ),
            array (
                    'halaman'   => 'DAFTAR PELANGGAN', 
                    'url'       => 'admin/pelanggans', 
                    'simbol'    => 'nav-icon far fa-user-circle'
            ),
            array (
                    'halaman'   => 'DAFTAR KUPA', 
                    'url'       => 'admin/datasampels', 
                    'simbol'    => 'nav-icon fas fa-file-invoice'
            ),
            array (
                    'halaman'   => 'DAFTAR PARAMETERS', 
                    'url'       => 'admin/parameters', 
                    'simbol'    => 'nav-icon fas fa-atom'
            ),
            array (
                    'halaman'   => 'DAFTAR METODE', 
                    'url'       => 'admin/metodes', 
                    'simbol'    => 'nav-icon fas fa-mortar-pestle'
            ),
            array (
                    'halaman'   => 'DAFTAR PAKET', 
                    'url'       => 'admin/pakets', 
                    'simbol'    => 'nav-icon fas fa-archive'
            ),
            array (
                    'halaman'   => 'DAFTAR AKTIVITAS', 
                    'url'       => 'admin/aktivitas', 
                    'simbol'    => 'nav-icon fas fa-percent'
            ),
            array (
                    'halaman'   => 'DAFTAR JENIS SAMPEL', 
                    'url'       => 'admin/jenissampels', 
                    'simbol'    => 'nav-icon fas fa-leaf'
            ),
            array (
                    'halaman'   => 'DAFTAR GROUP AKTIVITAS', 
                    'url'       => 'admin/groupaktivitas', 
                    'simbol'    => 'nav-icon fas fa-percentage'
            ),
            array (
                    'halaman'   => 'DAFTAR HALAMAN', 
                    'url'       => 'admin/halamans', 
                    'simbol'    => 'nav-icon fas fa-atlas'
            ),
            array (
                    'halaman'   => 'DAFTAR AKSES LEVEL', 
                    'url'       => 'admin/akseslevels', 
                    'simbol'    => 'nav-icon fas fa-users-cog'
            )
        ));
    }
}
