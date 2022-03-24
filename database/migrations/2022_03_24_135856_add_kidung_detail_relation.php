<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKidungDetailRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_detail_kidung', function (Blueprint $table) {
            $table->foreign('kidung_id')->references('id_post')->on('tb_post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_detail_kidung', function (Blueprint $table) {
            $table->dropForeign('kidung_id');
        });
    }
}
