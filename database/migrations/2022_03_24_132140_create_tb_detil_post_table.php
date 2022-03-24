<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbDetilPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detil_post', function (Blueprint $table) {
            $table->increments('id_det_post');
            $table->unsignedInteger('id_tag')->nullable();
            $table->unsignedInteger('id_post')->nullable();
            $table->unsignedInteger('id_parent_post')->nullable();
            $table->unsignedInteger('id_root_post')->nullable();
            $table->unsignedInteger('id_root_prosesi')->nullable();
            $table->unsignedInteger('id_status')->nullable();
            $table->integer('spesial');
            $table->integer('posisi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detil_post');
    }
}
