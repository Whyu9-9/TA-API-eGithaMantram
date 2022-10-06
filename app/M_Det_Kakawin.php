<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Det_Kakawin extends Model
{
    protected $table = 'tb_detail_sekar_agung';
    protected $fillable = ['sekar_agung_id','jenis_sekar_agung','urutan_bait','bait_sekar_agung','arti_sekar_agung'];
    public $timestamps = false;
}
