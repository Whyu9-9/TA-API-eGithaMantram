<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Kategori extends Model
{
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori','deskripsi','gambar'];
    public $timestamps = false;
}
