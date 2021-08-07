<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDataSampelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_sampels', function (Blueprint $table) {
            $table->foreign('jenis_sampels_id')->references('id')->on('jenis_sampels')->onUpdate('cascade');
            $table->foreign('pelanggans_id')->references('id')->on('pelanggans')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_sampels', function (Blueprint $table) {
            $table->dropIfExists(['jenis_sampels_id']);   
            $table->dropIfExists(['pelanggans_id']);   
        });
    }
}
