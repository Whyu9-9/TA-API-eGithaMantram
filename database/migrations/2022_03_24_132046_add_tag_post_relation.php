<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagPostRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_post', function (Blueprint $table) {
            $table->foreign('id_tag')->references('id_tag')->on('tb_tag')->onDelete('Set Null');
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
            $table->dropForeign('id_tag');
        });
    }
}
