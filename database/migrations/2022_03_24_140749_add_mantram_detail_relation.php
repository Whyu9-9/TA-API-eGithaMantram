<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMantramDetailRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_detail_mantram', function (Blueprint $table) {
            $table->foreign('mantram_id')->references('id_post')->on('tb_post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_detail_mantram', function (Blueprint $table) {
            $table->dropForeign('mantram_id');
        });
    }
}
