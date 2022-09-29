<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Det_Dharmagita extends Model
{
    protected $table = 'tb_detail_dharmagita';
    protected $fillable = ['dharmagita_id','urutan_bait','bait_dharmagita','arti_dharmagita'];
    public $timestamps = false;
}
