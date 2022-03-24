<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Tingkatan extends Model
{
    protected $table = 'tb_tingkatan';
    protected $primaryKey = 'id_tingkatan';
    protected $fillable = ['id_tag', 'nama_tingkatan'];
    public $timestamps = false;
}
