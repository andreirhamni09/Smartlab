<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pakets extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pakets')->insert(array(
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'N',
                'parameters_id_s'   => '1',
                'harga'             => '40000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'P',
                'parameters_id_s'   => '2',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'K',
                'parameters_id_s'   => '3',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'Mg',
                'parameters_id_s'   => '4',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'Ca',
                'parameters_id_s'   => '5',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'Cu',
                'parameters_id_s'   => '6',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'Zn',
                'parameters_id_s'   => '7',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'Mn',
                'parameters_id_s'   => '8',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'Fe',
                'parameters_id_s'   => '9',
                'harga'             => '35000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'N,P,K',
                'parameters_id_s'   => '1-2-3',
                'harga'             => '100000'
            ),
            
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'N,P,K,B',
                'parameters_id_s'   => '1-2-3-10',
                'harga'             => '135000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'N,P,K,Mg',
                'parameters_id_s'   => '1-2-3-4',
                'harga'             => '130000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'N,P,K,Mg,B',
                'parameters_id_s'   => '1-2-3-4-10',
                'harga'             => '160000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'N,P,K,Mg,Ca',
                'parameters_id_s'   => '1-2-3-4-5',
                'harga'             => '150000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'N,P,K,Mg,Ca,B',
                'parameters_id_s'   => '1-2-3-4-5-10',
                'harga'             => '190000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'P,K',
                'parameters_id_s'   => '2-3',
                'harga'             => '56000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'P,K,Mg',
                'parameters_id_s'   => '2-3-4',
                'harga'             => '84000'
            ),
            array(
                'jenis_sampels_id'  => '1',
                'paket'             => 'P,K,Mg,Ca',
                'parameters_id_s'   => '2-3-4-5',
                'harga'             => '110000'
            )
        )); 
    }
}
