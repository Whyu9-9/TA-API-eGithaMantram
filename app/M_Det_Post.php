<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Det_Post extends Model
{
    protected $table = 'tb_detil_post';
    protected $primaryKey = 'id_det_post';
    protected $fillable = ['id_tag','id_post','id_parent_post','id_root_post','id_root_prosesi','id_status','spesial','posisi'];
    public $timestamps = false;
}
