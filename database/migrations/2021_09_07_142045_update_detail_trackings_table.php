<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetailTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_trackings', function (Blueprint $table) {
            $table->foreign('data_sampels_id')->references('id')->on('data_sampels')->onUpdate('cascade');
            $table->foreign('aktivitas_id')->references('id')->on('aktivitas')->onUpdate('cascade');
            $table->foreign('lab_akuns_id')->references('id')->on('lab_akuns')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_trackings', function (Blueprint $table) {
            $table->dropIfExists(['data_sampels_id']);    
            $table->dropIfExists(['aktivitas_id']);    
            $table->dropIfExists(['lab_akuns_id']);        
        });
    }
}
