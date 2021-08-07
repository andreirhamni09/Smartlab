<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilAnalisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_analisas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('jenis_sampels_id');
            $table->smallInteger('data_sampels_id');
            $table->string('tahun', 2);
            $table->integer('no_lab');
            $table->string('kode_contoh', 45);
            $table->string('parameters_id_s', 45);
            $table->text('hasil');
            $table->enum('status', ['0', '1']);
            $table->integer('retry');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_analisas');
    }
}
