<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHasilAnalisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hasil_analisas', function (Blueprint $table) {
            $table->foreign('jenis_sampels_id')->references('id')->on('jenis_sampels')->onUpdate('cascade');
            $table->foreign('data_sampels_id')->references('id')->on('data_sampels')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hasil_analisas', function (Blueprint $table) {
            $table->dropIfExists(['jenis_sampels_id']);
            $table->dropIfExists(['data_sampels_id']);
        });
    }
}
