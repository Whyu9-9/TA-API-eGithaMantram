<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Post;
use App\M_Tag;

class TabuhListController extends Controller
{
    public function listAllTabuh()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post','tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    // ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_tag', '=', '5')->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_tabuh[]=(object) array(
                'id_post'     => $data->id_post,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        return response()->json($new_tabuh);
    }

    public function detailTabuh($id_post)
    {
        $detail_post = M_Post::where('tb_post.id_post',$id_post)
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',)
                            ->first();
        $detail_post['deskripsi'] = filter_var($detail_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($detail_post);
    }
}
