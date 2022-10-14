<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Audio extends Model
{
    protected $table = 'tb_audio';
    protected $primaryKey = 'id_audio';
    protected $fillable = ['id_dharmagita','judul_video','gambar_video','audio'];
    public $timestamps = false;
}
