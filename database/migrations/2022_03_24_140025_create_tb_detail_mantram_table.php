<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbDetailMantramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detail_mantram', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mantram_id');
            $table->enum('jenis_mantram', ['Umum', 'Khusus']);
            $table->text('bait_mantra');
            $table->text('arti_mantra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
