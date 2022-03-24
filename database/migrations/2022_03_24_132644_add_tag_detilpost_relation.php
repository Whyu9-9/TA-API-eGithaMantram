<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagDetilpostRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_detil_post', function (Blueprint $table) {
            $table->foreign('id_tag')->references('id_tag')->on('tb_tag')->onDelete('Set Null');
            $table->foreign('id_post')->references('id_post')->on('tb_post')->onDelete('Set Null');
            $table->foreign('id_parent_post')->references('id_post')->on('tb_post')->onDelete('Set Null');
            $table->foreign('id_root_post')->references('id_post')->on('tb_post')->onDelete('Set Null');
            $table->foreign('id_root_prosesi')->references('id_post')->on('tb_post')->onDelete('Set Null');
            $table->foreign('id_status')->references('id_status')->on('tb_status')->onDelete('Set Null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_detil_post', function (Blueprint $table) {
            $table->dropForeign('id_tag');
            $table->dropForeign('id_post');
            $table->dropForeign('id_parent_post');
            $table->dropForeign('id_root_post');
            $table->dropForeign('id_root_prosesi');
            $table->dropForeign('id_status');
        });
    }
}
