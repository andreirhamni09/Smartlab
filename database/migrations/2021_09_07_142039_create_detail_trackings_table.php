<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_trackings', function (Blueprint $table) {
            $table->dateTime('aktivitas_waktu');
            $table->smallInteger('data_sampels_id');
            $table->unsignedTinyInteger('aktivitas_id');
            $table->unsignedTinyInteger('lab_akuns_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_trackings');
    }
}
