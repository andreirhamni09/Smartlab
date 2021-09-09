<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_akuns', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->tinyInteger('akses_levels_id');
            $table->string('metodes_id_s', 45);
            $table->string('nama', 100);
            $table->string('email');
            $table->string('password');
            $table->string('jabatan', 45);
            $table->enum('status_akun', ['0', '1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_akuns');
    }
}
