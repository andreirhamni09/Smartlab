<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSampelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_sampels', function (Blueprint $table) {
            $table->smallInteger('id')->primary()->autoIncrement();
            $table->unsignedTinyInteger('jenis_sampels_id');
            $table->unsignedInteger('pelanggans_id');
            $table->string('pakets_id_s', 45);
            $table->dateTime('tanggal_masuk');
            $table->tinyInteger('tanggal_selesai');
            $table->string('nomor_surat');
            $table->integer('jumlah_sampel');
            $table->unsignedSmallInteger('ketersedian_alats_id');
            $table->text('catatan_userlabs');
            $table->text('catatan_pelanggans');
            $table->string('status');
            $table->string('verifikasi_sampel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_sampels');
    }
}
