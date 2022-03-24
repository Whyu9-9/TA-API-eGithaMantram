<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Tag extends Model
{
     protected $table = 'tb_tag';
     protected $primaryKey = 'id_tag';
     protected $fillable = ['nama_tag','deskripsi','gambar'];
     public $timestamps = false;

}
