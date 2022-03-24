<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Post extends Model
{
    protected $table = 'tb_post';
    protected $primaryKey = 'id_post';
    protected $fillable = ['id_kategori','id_tag','nama_post','deskripsi','video','gambar'];
    public $timestamps = false;

    // public function kategori(){
    // 	return $this->belongsTo('App\M_Kategori');
    // }
}
