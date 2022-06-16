<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_User extends Model
{
    protected $table = 'users';
    protected  $primaryKey = 'id_user';
    protected $fillable = ['name','email','password', 'role', 'mobile_is_logged'];
    
    // public function post(){
    // 	return $this->hasMany('App\M_Post');
}
