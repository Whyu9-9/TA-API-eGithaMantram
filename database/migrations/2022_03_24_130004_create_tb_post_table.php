<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_post', function (Blueprint $table) {
            $table->increments('id_post');
            $table->unsignedInteger('id_kategori')->nullable();
            $table->unsignedInteger('id_tag')->nullable();
            $table->string('nama_post');
            $table->text('deskripsi');
            $table->text('video');
            $table->string('gambar');
            $table->string('sumber_gambar');
            $table->string('sumber_video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
