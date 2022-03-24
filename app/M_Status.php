<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Status extends Model
{
    protected $table = 'tb_status';
    protected $primaryKey = 'id_status';
    protected $fillable = ['id_status','nama_status'];
    public $timestamps = false;

    // public function kategori(){
    // 	return $this->belongsTo('App\M_Kategori');
    // }
}
