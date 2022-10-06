<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Det_Pupuh extends Model
{
    protected $table = 'tb_detail_pupuh';
    protected $fillable = ['pupuh_id','urutan_bait','bait_pupuh'];
    public $timestamps = false;
}
