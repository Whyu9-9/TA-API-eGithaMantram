<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Det_Mantram extends Model
{
    protected $table = 'tb_detail_mantram';
    protected $fillable = ['mantram_id','jenis_mantram','bait_mantram'];
    public $timestamps = false;
}
