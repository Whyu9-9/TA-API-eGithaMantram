<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Det_LaguAnak extends Model
{
    protected $table = 'tb_detail_lagu_anak';
    protected $fillable = ['lagu_anak_id','urutan_bait','bait_lagu'];
    public $timestamps = false;
}
