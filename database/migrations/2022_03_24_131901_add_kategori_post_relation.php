<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKategoriPostRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_post', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('tb_kategori')->onDelete('Set Null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_post', function (Blueprint $table) {
            $table->dropForeign('id_kategori');
        });
    }
}
