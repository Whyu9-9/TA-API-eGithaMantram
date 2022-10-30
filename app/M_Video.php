<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Video extends Model
{
    protected $table = 'tb_video';
    protected $primaryKey = 'id_video';
    protected $fillable = ['id_dharmagita','judul_video','gambar_video','video'.'is_approved'];
    public $timestamps = false;
}
