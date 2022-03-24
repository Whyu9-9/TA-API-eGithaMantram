<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Det_Kidung extends Model
{
    protected $table = 'tb_detail_kidung';
    protected $fillable = ['kidung_id','urutan_bait','bait_kidung'];
    public $timestamps = false;
}
