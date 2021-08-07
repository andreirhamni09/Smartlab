<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLabAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_akuns', function (Blueprint $table) {
            $table->foreign('akses_levels_id')->references('id')->on('akses_levels')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab_akuns', function (Blueprint $table) {
            $table->dropIfExists(['akses_levels_id']);        
        });
    }
}
