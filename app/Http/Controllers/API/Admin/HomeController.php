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
}
