<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;

class HomeController extends Controller
{
    public function listYadnyaMaster()
    {
        $data = M_Kategori::get();

        foreach($data as $d){
            $jumlah = M_Post::where('id_kategori', $d->id_kategori)
                            ->where('tb_post.id_tag', '=', null)
                            ->count();
            $all_yadnya[]=(object) array(
                'id_kategori'   => $d->id_kategori,
                'nama_kategori' => $d->nama_kategori,
                'jumlah'        => $jumlah,
            );
        }

        return response()->json($all_yadnya);
    }

    public function selectedHomeYadnya($nama_yadnya){
        $data = M_post::where('tb_post.id_tag', null)
                    ->where('tb_kategori.nama_kategori', $nama_yadnya)
                    ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        if(count($data) > 0){
            foreach ($data as $d) {
                $new_yadnya[]=(object) array(
                    'id_post'     => $d->id_post,
                    'id_kategori' => $d->id_kategori,
                    'kategori'    => $d->nama_kategori,
                    'nama_post'   => $d->nama_post,
                    'gambar'      => $d->gambar,
                );
            }
        }else{
            $new_yadnya = [];
        }

        return response()->json($new_yadnya);
    }
}
